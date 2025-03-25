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

class InstituteController extends Controller
{

    protected $districtAccess;

    public function __construct()
    {
        $this->middleware('auth');
        $this->districtAccess = DB::table('usr')->where('id', Auth::id())->value('joblvl');
    }

    private array $defaultInstituteValues = [
        'firebase_id' => '',
        'imgProfile' => '',
        'isustaz' => '',
        'iskariah' => '',
        'sid' => 1,
        'app' => 'CLIENT',
    ];
    private function validateInstitute(Request $request): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'cate1' => 'required|string|max:50',
            'cate' => 'required|string|max:50',
            'rem8' => 'required|string|max:50',
            'rem9' => 'required|string|max:50',
            'addr' => 'nullable|string|max:500',
            'addr1' => 'nullable|string|max:500',
            'pcode' => 'nullable|string|max:8',
            'city' => 'nullable|string|max:50',
            'state' => 'nullable|string|max:50',
            'hp' => 'nullable|string|max:50',
            'fax' => 'nullable|string|max:50',
            'mel' => 'nullable|email|max:255',
            'web' => 'nullable|string|max:255',
            'rem10' => 'nullable|string|max:50',
            'rem11' => 'nullable|string|max:50',
            'rem12' => 'nullable|string|max:50',
            'rem13' => 'nullable|string|max:50',
            'rem14' => 'nullable|string|max:50',
            'rem15' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'con1' => 'nullable|string|max:50',
            'ic' => 'nullable|string|max:50',
            'pos1' => 'nullable|string|max:50',
            'tel1' => 'nullable|string|max:50',
            'sta' => 'nullable|string|max:50',
            'state' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:50',
        ];

        return Validator::make($request->all(), $rules)->validate();
    }
    
    private function generateUniqueUid()
    {
        $lastUid = DB::table('client')->orderBy('uid', 'desc')->value('uid');

        $numericPart = intval(substr($lastUid, 1)) ?? 0;

        do {
            $numericPart++;
            $newUid = 'C' . str_pad($numericPart, 5, '0', STR_PAD_LEFT);
            $exists = DB::table('client')->where('uid', $newUid)->exists();

        } while ($exists); 

        return $newUid;
    }

    private function applyFilters($query, Request $request)
    {
        foreach ($request->all() as $field => $value) {
            // Use isset() instead of !empty() to allow filtering when value is 0
            if (isset($value) && \Schema::hasColumn('client', $field)) {
                $query->where($field, $value);
            }
        }

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', "%{$searchTerm}%");
        }

        return $query;
    }


    public function list(Request $request)
    {
        $districtAccess = DB::table('usr')->where('mel', Auth::user()->mel)->value('joblvl');

        $perPage = $request->input('per_page', 10);

        $query = Institute::query();

        if ($districtAccess != null) {
            $query->where('rem8', $districtAccess);
        }

        $query = $this->applyFilters($query, $request);

        $institutes = $query->with(['Type', 'Category', 'City', 'Subdistrict', 'District'])
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        $institutes->getCollection()->transform(function ($institute) {
            $institute->TYPE = isset($institute->Type->prm) ? strtoupper($institute->Type->prm) : null;
            $institute->CATEGORY = isset($institute->Category->prm) ? strtoupper($institute->Category->prm) : null;
            $institute->SUBDISTRICT = isset($institute->Subdistrict->prm) ? strtoupper($institute->Subdistrict->prm) : null;
            $institute->DISTRICT = isset($institute->District->prm) ? strtoupper($institute->District->prm) : null;
            $institute->NAME = strtoupper($institute->name ?? '');
            $institute->STATUS = Parameter::where('grp', 'clientstatus')
                ->where('val', $institute->sta)
                ->pluck('prm', 'val')
                ->map(fn($prm, $val) => ['val' => $val, 'prm' => $prm])
                ->first();
            return $institute;
        });

        $parameters = $this->getCommon();
        if($districtAccess != null){
            $parameters['districts'] = Parameter::where('grp', 'district')
                ->where('code', $districtAccess)
                ->pluck('prm', 'code')
                ->toArray();
            $parameters['subdistricts'] = Parameter::where('grp', 'subdistrict')
                ->where('etc', $districtAccess)
                ->pluck('prm', 'code')
                ->toArray();
        }


        if ($request->filled('cate1')) {
            $parameters['categories'] = Parameter::where('grp', 'type_CLIENT')
                ->where('etc', $request->cate1)
                ->pluck('prm', 'code')
                ->toArray();
        }

        if ($request->filled('rem8')) {
            $parameters['subdistricts'] = Parameter::where('grp', 'subdistrict')
                ->where('etc', $request->rem8)
                ->pluck('prm', 'code')
                ->toArray();
        }

        return view('Institute.list', [
            'parameters' => $parameters,
            'institutes' => $institutes
        ]);
    }





    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $validatedData = $this->validateInstitute($request);

            $validatedData['uid'] = $this->generateUniqueUid();

            $dataToInsert = array_merge($this->defaultInstituteValues, $validatedData);

            Institute::create($dataToInsert);

            return redirect()->route('instituteList')->with('success', 'Institusi telah berjaya didaftarkan!');
        }
        return view('Institute.create', ['parameters' => $this->getCommon()]);
    }

    public function edit(Request $request, $id)
    {

        $institute = Institute::with('type', 'category', 'City', 'subdistrict', 'district')->find($id);

        if ($request->isMethod('post')) {
            
            $validatedData = $this->validateInstitute($request);
            $institute->update($validatedData);
            // $institute->update($request->except('_token'));

            return redirect()->route('instituteList')->with('success', 'Institusi tidak berjaya dikemaskini!');
        }


        return view('Institute.edit', ['institute' => $institute, 'parameters' => $this->getCommon()]);        
    }

    public function registrationRequests(Request $request)
    {
        $districtAccess = DB::table('usr')->where('mel', Auth::user()->mel)->value('joblvl');

        $perPage = $request->input('per_page', 10);

        $query = Institute::query();

        if ($districtAccess != null) {
            $query->where('rem8', $districtAccess);
        }

        $query = $query->where('sta', 1)
            ->whereNotNull('registration_request_date')
            ->where(function ($q) {
                $q->whereNull('regdt') 
                ->orWhere('regdt', '0000-00-00'); 
            });


        $query = $this->applyFilters($query, $request);

        $institutes = $query->with('type', 'category', 'City', 'subdistrict', 'district')
            ->orderBy('id', 'desc')
            ->paginate($perPage)->withQueryString();

        
            $institutes->getCollection()->transform(function ($institute) {
            $institute->TYPE = isset($institute->Type->prm) ? strtoupper($institute->Type->prm) : null;
            $institute->CATEGORY = isset($institute->Category->prm) ? strtoupper($institute->Category->prm) : null;
            $institute->SUBDISTRICT = isset($institute->Subdistrict->prm) ? strtoupper($institute->Subdistrict->prm) : null;
            $institute->DISTRICT = isset($institute->District->prm) ? strtoupper($institute->District->prm) : null;
            $institute->NAME = strtoupper($institute->name ?? '');
            $institute->REGISTRATION_DATE = date('d-m-Y', strtotime($institute->registration_request_date));

            return $institute;
        });

        $parameters = $this->getCommon();
        if($districtAccess != null){
            $parameters['districts'] = Parameter::where('grp', 'district')
                ->where('code', $districtAccess)
                ->pluck('prm', 'code')
                ->toArray();
            $parameters['subdistricts'] = Parameter::where('grp', 'subdistrict')
                ->where('etc', $districtAccess)
                ->pluck('prm', 'code')
                ->toArray();
        }

        if ($request->filled('cate1')) {
            $parameters['categories'] = Parameter::where('grp', 'type_CLIENT')
                ->where('etc', $request->cate1)
                ->pluck('prm', 'code')
                ->toArray();
        }

        if ($request->filled('rem8')) {
            $parameters['subdistricts'] = Parameter::where('grp', 'subdistrict')
                ->where('etc', $request->rem8)
                ->pluck('prm', 'code')
                ->toArray();
        }

        return view('Institute.registration_requests', [
            'parameters' => $parameters,
            'institutes' => $institutes
        ]);
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

        $updated = $institute->update([
            'sta' => 0,
            'mel' => $request->mel,
            'regdt' => now()->toDateString(),
        ]);

        if ($updated) {
            Mail::to($request->mel)->send(new RegistrationApproveConfirmation($request->mel, $institute->name));
            return redirect()->route('registrationRequests')->with('success', 'Pendaftaran Institusi diluluskan dan email pengesahan telah berjaya dihantar!');
        } else {
            return redirect()->back()->with('error', 'Pengesahan pendaftaran institusi tidak berjaya, sila cuba sebetar lagi!');
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
            ->where('prm', 'LIKE', "%{$search}%") // Search for matching cities
            ->pluck('prm', 'code')
            ->toArray();

        return response()->json($cities);
    }
}
