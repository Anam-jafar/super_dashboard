<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Institute;
use App\Models\Parameter;

class InstituteService
{
    protected DistrictAccessService $districtAccessService;

    public function __construct(DistrictAccessService $districtAccessService)
    {
        $this->districtAccessService = $districtAccessService;
    }

    public array $defaultInstituteValues = [
        'firebase_id' => '',
        'imgProfile' => '',
        'isustaz' => '',
        'iskariah' => '',
        'sid' => 1,
        'app' => 'CLIENT',
    ];

    public function validateInstitute(Request $request, $id = null): array
    {
        $rules = [
            'name' => 'required|string|max:255|unique:client,name,NULL,id,rem8,' . $request->input('rem8'),
            'cate1' => 'required|string|max:50',
            'cate' => 'required|string|max:50',
            'rem8' => 'required|string|max:50',
            'rem9' => 'required|string|max:50',
            'addr' => 'nullable|string|max:128',
            'addr1' => 'nullable|string|max:128',
            'pcode' => 'nullable|numeric|max:8',
            'city' => 'nullable|string|max:50',
            'state' => 'nullable|string|max:50',
            'hp' => 'nullable|numeric|digits:11',
            'fax' => 'nullable|numeric|digits:11',
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
            'tel1' => 'nullable|numeric|digits:11',
            'sta' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:50',
        ];

        // Unique check for name in rem8 during creation and edit
        if ($id) {
            // Edit: Name must be unique except for the current record
            $rules['name'] = [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request, $id) {
                    $exists = DB::table('client')
                        ->where('rem8', $request->input('rem8'))
                        ->where('name', $value)
                        ->where('id', '!=', $id)
                        ->exists();

                    if ($exists) {
                        $fail('Masjid dengan nama itu sudah wujud di daerah yang dipilih.');
                    }
                }
            ];
        } else {
            // Create: Ensure name is unique in the rem8 column
            $rules['name'] = 'required|string|max:255|unique:client,name,NULL,id,rem8,' . $request->input('rem8');
        }

        // If the institution status is 0, make certain fields required
        if ($request->sta == '0') {
            $rules['hp'] = 'required|numeric|digits:11|unique:client,hp,' . $id;
            $rules['mel'] = 'required|email|max:255|unique:client,mel,' . $id;
            $rules['con1'] = 'required|string|max:50';
            $rules['ic'] = 'required|string|max:50';
            $rules['pos1'] = 'required|string|max:50';
            $rules['tel1'] = 'required|numeric|digits:11';
        }

        // Return the validation rules along with custom error messages in Malay
        return Validator::make($request->all(), $rules, [
            'hp.required' => 'Nombor telefon diperlukan kerana institusi belum disahkan.',
            'hp.numeric' => 'Nombor telefon mesti dalam format nombor.',
            'hp.digits' => 'Nombor telefon mesti mempunyai 11 digit.',
            'hp.unique' => 'Nombor telefon ini telah digunakan.',
            'mel.required' => 'E-mel diperlukan kerana institusi belum disahkan.',
            'mel.email' => 'Sila masukkan alamat e-mel yang sah.',
            'mel.max' => 'Alamat e-mel tidak boleh melebihi 255 aksara.',
            'mel.unique' => 'E-mel ini telah digunakan.',
            'name.required' => 'Nama institusi diperlukan.',
            'name.unique' => 'Masjid dengan nama itu sudah wujud di daerah yang dipilih.',
            'addr.max' => 'Alamat tidak boleh melebihi 128 aksara.',
            'addr1.max' => 'Alamat 1 tidak boleh melebihi 128 aksara.',
            'pcode.numeric' => 'Kod pos mesti dalam format nombor.',
            'pcode.max' => 'Kod pos tidak boleh melebihi 8 aksara.',
            'fax.numeric' => 'Faksimili mesti dalam format nombor.',
            'fax.digits' => 'Faksimili mesti mempunyai 11 digit.',
            'location.max' => 'Lokasi mesti dalam format koordinat dan tidak boleh melebihi 255 aksara.',
            'tel1.numeric' => 'Telefon 1 mesti dalam format nombor.',
            'tel1.digits' => 'Telefon 1 mesti mempunyai 11 digit.',
        ])->validate();
    }



    public function generateUniqueUid()
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

    public function applyFilters($query, Request $request)
    {

        $districtAccess = $this->districtAccessService->getDistrictAccess();

        if ($districtAccess !== null) {
            $query->where('rem8', $districtAccess);
        }


        foreach ($request->all() as $field => $value) {
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

    public function transformInstituteRelations($institute)
    {
        $institute->TYPE = $this->getParameter($institute->Type);
        $institute->CATEGORY = $this->getParameter($institute->Category);
        $institute->SUBDISTRICT = $this->getParameter($institute->Subdistrict);
        $institute->DISTRICT = $this->getParameter($institute->District);
        $institute->NAME = strtoupper($institute->name ?? '');
        $institute->STATUS = $this->getClientStatus($institute->sta);
        return $institute;
    }

    private function getParameter($relation)
    {
        return isset($relation->prm) ? strtoupper($relation->prm) : null;
    }

    private function getClientStatus($status)
    {
        return Parameter::where('grp', 'clientstatus')
            ->where('val', $status)
            ->pluck('prm', 'val')
            ->map(fn ($prm, $val) => ['val' => $val, 'prm' => $prm])
            ->first();
    }

}
