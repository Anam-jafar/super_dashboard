<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Parameter;
use App\Models\Institute;

class InstituteController extends Controller
{
    //
    private array $defaultInstituteValues = [
        'firebase_id' => '',
        'imgProfile' => '',
        'isustaz' => '',
        'iskariah' => '',
        'sid' => 1,
    ];
    private function validateInstitute(Request $request): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'cate1' => 'required|string|max:50',
            'cate' => 'required|string|max:50',
            'rem8' => 'required|string|max:50',
            'rem9' => 'required|string|max:50',
            'addr' => 'required|string|max:500',
            'addr1' => 'nullable|string|max:500',
            'pcode' => 'nullable|string|max:50',
            'city' => 'required|string|max:50',
            'state' => 'required|string|max:50',
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
            'country' => 'required|string|max:50',
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
            if (!empty($value) && \Schema::hasColumn('client', $field)) {
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
        $perPage = $request->input('per_page', 10);

        $query = $this->applyFilters(Institute::query(), $request);

        $institutes = $query->with('type', 'category', 'City', 'subdistrict', 'district')
            ->orderBy('id', 'desc')
            ->paginate($perPage)->withQueryString();

        
            $institutes->getCollection()->transform(function ($institute) {
            $institute->TYPE = $institute->Type->prm ?? null;
            $institute->CATEGORY = $institute->Category->prm ?? null;
            $institute->CITY = $institute->City->prm ?? null;
            $institute->SUBDISTRICT = $institute->Subdistrict->prm ?? null;
            $institute->DISTRICT = $institute->District->prm ?? null;
            return $institute;
        });

        return view('Institute.list', [
            'parameters' => $this->getCommon(),
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

            return redirect()->back();
        }
        return view('Institute.create', ['parameters' => $this->getCommon()]);
    }

    public function edit(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $institute = Parameter::find($id);
            $institute->update($request->all());
            return redirect()->route('institute.list');
        }

        $institute = Institute::with('type', 'category', 'City', 'subdistrict', 'district')->find($id);

        return view('Institute.edit', ['institute' => $institute, 'parameters' => $this->getCommon()]);        
    }

    public function registrationRequests(Request $request)
    {
        $per_page = $request->per_page ?? 10;

        $query = Parameter::where('grp', 'type_CLIENT')
            ->where('etc', 1);

        if ($request->filled('search')) {
            $query->where('prm', 'like', '%' . $request->search . '%');
        }

        $institutes = $query->paginate($per_page);

        return view('Institute.registration_requests', compact('institutes'));
    }

    public function registrationRequestDetail($id)
    {
        return view('Institute.registration_request_detail', ['institute' => Parameter::find($id)]);
    }

    public function approveRegistrationRequest(Request $request, $id)
    {
        $institute = Parameter::find($id);
        $institute->update(['etc' => 2]);

        return redirect()->route('institute.registrationRequests');
    }
}
