<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parameter;
use Illuminate\Validation\Rule;

class SettingController extends Controller
{
    public $groups = [
        'country'      => 'Negara',
        'state'        => 'Negeri',
        'city'         => 'Bandar',
        'district'     => 'Daerah',
        'subdistrict'  => 'Mukim',
        'clientcate1'  => 'Institusi',
        'type_CLIENT'  => 'Jenis Institusi',
    ];

    public function list(Request $request)
    {
        $per_page = $request->input('per_page', 10);
        $selectedGroup = $request->input('grp', 'country');
        $query = Parameter::where('grp', $selectedGroup);


        $parents = Parameter::where('grp', $selectedGroup)
                    ->whereNotNull('etc')
                    ->where('etc', '!=', '')
                    ->distinct()
                    ->pluck('etc');
        $parentGroup = [];

        $selectedParent = $request->input('etc', '');

        foreach ($parents as $key => $value) {
            $parentGroup[$value] = Parameter::where('code', $value)->value('prm');
        }


        if ($request->has('etc') && trim($request->input('etc')) !== '') {
            $query->where('etc', $request->input('etc'));
        }


        // if ($request->has('search')) {
        //     $query->where(function ($q) use ($request) {
        //         $q->where('prm', 'like', '%' . $request->search . '%')
        //             ->orWhere('val', 'like', '%' . $request->search . '%');
        //     });
        // }

        $items = $query->paginate($per_page);

        // Transform the items
        $items->transform(function ($item) use ($parentGroup) {
            $item->etc = Parameter::where('code', $item->etc)->value('prm') ?? '';
            return $item;
        });


        $levelParameter = $this->groups[$selectedGroup] ?? 'Parameter';

        if (!empty($parents) && isset($parents[0])) {
            $selectedParentGroup = Parameter::where('code', $parents[0])->value('grp');
            $levelParentParameter = $this->groups[$selectedParentGroup] ?? 'DII';
        } else {
            $levelParentParameter = 'DII';
        }
        $groups = $this->groups;



        return view('setting.list', compact(['items', 'groups', 'parentGroup', 'selectedGroup', 'selectedParent', 'levelParameter', 'levelParentParameter']));
    }

    public function create(Request $request)
    {
        $selectedGroup = $request->query('group');
        $selectedParent = $request->query('parent');

        if ($selectedParent == null) {
            // Get distinct, non-null, non-empty 'etc' values for selected group
            $selectedParentList = Parameter::where('grp', $selectedGroup)
                ->whereNotNull('etc')
                ->where('etc', '!=', '')
                ->distinct()
                ->pluck('etc');

            // Initialize parentGroup
            $parentGroup = [];

            // For each etc value, find its prm by its code
            foreach ($selectedParentList as $etc) {
                $param = Parameter::where('code', $etc)->first();

                if ($param) {
                    $parentGroup[$param->code] = $param->prm;
                }
            }
        } else {
            // Get parent group based on selected parent
            $parent = Parameter::where('code', $selectedParent)->value('grp');

            $parentGroup = Parameter::where('grp', $parent)
                ->pluck('prm', 'code')
                ->toArray();

        }

        $levelParameter = $this->groups[$selectedGroup] ?? 'Parameter';

        if (!empty($parentGroup) && array_key_first($parentGroup)) {
            $firstCode = array_key_first($parentGroup);
            $selectedParentGroup = Parameter::where('code', $firstCode)->value('grp');
            $levelParentParameter = $this->groups[$selectedParentGroup] ?? 'DII';
        } else {
            $levelParentParameter = 'DII';
        }

        if (request()->isMethod('post')) {
            $data = request()->validate([
                'prm' => 'required',
                'val' => 'nullable',
                'code' => [
                    'required',
                    Rule::unique('type')->where(function ($query) use ($selectedGroup) {
                        return $query->where('grp', $selectedGroup);
                    }),
                ],
                'des' => 'nullable',
                'sid' => 'nullable',
                'lvl' => 'nullable',
                'etc' => 'nullable',
                'idx' => 'nullable',
            ]);

            $data['grp'] = $selectedGroup;
            $data['sta'] = 1;
            $data['isdel'] = 0;
            $data['sid'] = 1;

            Parameter::create($data);

            return redirect()->route('settingsList')->with('success', 'Parameter created successfully.');
        }

        return view('setting.create', compact(['selectedGroup', 'selectedParent', 'parentGroup', 'levelParameter', 'levelParentParameter']));

    }


    public function edit($id)
    {
        $item = Parameter::findOrFail($id);

        $levelParameter = $this->groups[$item->grp] ?? 'Parameter';
        $selectedParent = $item->etc;
        $parents = Parameter::where('grp', $item->grp)
                    ->whereNotNull('etc')
                    ->where('etc', '!=', '')
                    ->distinct()
                    ->pluck('etc');
        $parentGroup = [];
        foreach ($parents as $key => $value) {
            $parentGroup[$value] = Parameter::where('code', $value)->value('prm');
        }

        if (!empty($parentGroup) && array_key_first($parentGroup)) {
            $firstCode = array_key_first($parentGroup);
            $selectedParentGroup = Parameter::where('code', $firstCode)->value('grp');
            $levelParentParameter = $this->groups[$selectedParentGroup] ?? 'DII';
        } else {
            $levelParentParameter = 'DII';
        }

        if (request()->isMethod('post')) {
            $data = request()->validate([
                'prm' => 'required',
                'val' => 'nullable',
                'code' => 'required',
                'des' => 'nullable',
                'sid' => 'nullable',
                'lvl' => 'nullable',
                'etc' => 'nullable',
                'idx' => 'nullable',
            ]);

            $item->update($data);

            return redirect()->route('settingsList')->with('success', 'Item updated successfully.');
        }

        return view('setting.edit', compact(['item', 'levelParameter', 'selectedParent', 'parentGroup', 'levelParentParameter']));
    }

}
