<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Mail\RegistrationApproveConfirmation;
use Illuminate\Support\Facades\Mail;
use App\Models\Parameter;
use App\Models\Institute;
use Illuminate\Support\Facades\Log;
use App\Services\InstituteService;
use App\Services\DistrictAccessService;

class InstituteController extends Controller
{
    protected $instituteService;
    protected $districtAccessService;

    public function __construct(InstituteService $instituteService, DistrictAccessService $districtAccessService)
    {
        $this->instituteService = $instituteService;
        $this->districtAccessService = $districtAccessService;
    }

    public function list(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $query = Institute::query();
        $query = $this->instituteService->applyFilters($query, $request);
        $institutes = $query->with(['Type', 'Category', 'City', 'Subdistrict', 'District'])
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();
        $institutes->getCollection()->transform(function ($institute) {
            return $this->instituteService->transformInstituteRelations($institute);
        });


        $parameters = $this->getCommon();
        $parameters = array_merge($parameters, $this->districtAccessService->fetchDistrictParameters());
        $filteredParameters = $this->fetchParameterOptions($request, [
            'cate1' => ['type_CLIENT', 'categories'],
            'rem8'  => ['subdistrict', 'subdistricts'],
        ]);
        $parameters = array_merge($parameters, $filteredParameters);

        return view('Institute.list', compact('parameters', 'institutes'));
    }


    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $validatedData = $this->instituteService->validateInstitute($request);
            $validatedData['uid'] = $this->instituteService->generateUniqueUid();
            $dataToInsert = array_merge($this->instituteService->defaultInstituteValues, $validatedData);

            Institute::create($dataToInsert);

            return redirect()->route('instituteList')->with('success', 'Institusi telah berjaya didaftarkan!');
        }

        return view('Institute.create', ['parameters' => $this->getCommon()]);
    }

    public function edit(Request $request, $id)
    {
        $institute = Institute::with('type', 'category', 'City', 'subdistrict', 'district')->findOrFail($id);

        if ($request->isMethod('post')) {
            $validatedData = $this->instituteService->validateInstitute($request, $id);
            $institute->update($validatedData);

            return redirect()->route('instituteList')->with('success', 'Institusi berjaya dikemaskini!');
        }

        return view('Institute.edit', ['institute' => $institute, 'parameters' => $this->getCommon()]);
    }

    public function registrationRequests(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $query = Institute::query();
        $query = $query->where('sta', 1)
            ->where(function ($q) {
                $q->whereNotNull('registration_request_date')
                ->where('registration_request_date', '!=', '0000-00-00');
            })
            ->where(function ($q) {
                $q->whereNull('regdt')
                ->orWhere('regdt', '0000-00-00');
            });
        $query = $this->instituteService->applyFilters($query, $request);
        $institutes = $query->with('type', 'category', 'City', 'subdistrict', 'district')
            ->orderBy('id', 'desc')
            ->paginate($perPage)->withQueryString();
        $institutes->getCollection()->transform(function ($institute) {
            return $this->instituteService->transformInstituteRelations($institute);
        });


        $parameters = $this->getCommon();
        $parameters = array_merge($parameters, $this->districtAccessService->fetchDistrictParameters());
        $filteredParameters = $this->fetchParameterOptions($request, [
            'cate1' => ['type_CLIENT', 'categories'],
            'rem8'  => ['subdistrict', 'subdistricts'],
        ]);
        $parameters = array_merge($parameters, $filteredParameters);

        return view('Institute.registration_requests', compact('parameters', 'institutes'));
    }

    public function registrationRequestDetail($id)
    {
        $institute = Institute::with('type', 'category', 'City', 'subdistrict', 'district')->find($id);

        return view('Institute.registration_request_detail', ['institute' => $institute]);
    }


    public function approveRegistrationRequest(Request $request, $id)
    {
        $institute = Institute::find($id);
        if (!$institute) {
            return redirect()->back()->with('error', 'Tiada rekod ditemui!');
        }

        $request->validate([
            'mel' => 'required|email|max:255|unique:client,mel,' . $id,
        ], [
            'mel.required' => 'E-mel diperlukan.',
            'mel.email' => 'Sila masukkan alamat e-mel yang sah.',
            'mel.max' => 'Alamat e-mel tidak boleh melebihi 255 aksara.',
            'mel.unique' => 'E-mel ini telah digunakan. Sila gunakan e-mel lain.',
        ]);

        $updated = $institute->update([
            'sta' => 0,
            'mel' => $request->mel,
            'regdt' => now()->toDateString(),
        ]);

        if ($updated) {
            try {
                Mail::to($request->mel)->send(new RegistrationApproveConfirmation($request->mel, $institute->name));
            } catch (\Exception $e) {
                Log::error('Failed to send registration approval confirmation email', [
                    'email' => $request->mel,
                    'error' => $e->getMessage(),
                ]);
            }
            return redirect()->route('registrationRequests')->with('success', 'Pendaftaran Institusi diluluskan dan e-mel pengesahan telah berjaya dihantar!');
        } else {
            return redirect()->back()->with('error', 'Pengesahan pendaftaran institusi tidak berjaya, sila cuba sebentar lagi!');
        }
    }


    public function getInstitutionCategories(Request $request)
    {
        $categoryId = $request->input('category_id');

        if (!$categoryId) {
            return response()->json([]);
        }

        $institutionTypes = Parameter::where('grp', 'type_CLIENT')
            ->where('etc', $categoryId)
            ->pluck('prm', 'code')
            ->toArray();

        return response()->json($institutionTypes);
    }

    public function getSubDistricts(Request $request)
    {
        $districtId = $request->input('district_id');

        if (!$districtId) {
            return response()->json([]);
        }

        $subDistricts = Parameter::where('grp', 'subdistrict')
            ->where('etc', $districtId)
            ->pluck('prm', 'code')
            ->toArray();

        return response()->json($subDistricts);
    }

    public function getBandar(Request $request)
    {
        $search = $request->input('query');

        $cities = Parameter::where('grp', 'city')
            ->where('prm', 'LIKE', "%{$search}%")
            ->pluck('prm', 'code')
            ->toArray();

        return response()->json($cities);
    }
}
