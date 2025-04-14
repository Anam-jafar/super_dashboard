<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parameter;

class SettingController extends Controller
{
    public function country()
    {
        $countries = Parameter::where('grp', 'country')
                    // ->orderBy('idx')
                    ->paginate(10);

        return view('setting.country', compact(['countries']));
    }

    public function countryCreate()
    {
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

            $data['grp'] = 'country';
            $data['sta'] = 1;
            $data['isdel'] = 0;
            $data['sid'] = 1;

            Parameter::create($data);

            return redirect()->route('settingsCountry')->with('success', 'Country created successfully.');
        }
        return view('setting.country-create');
    }

    public function countryEdit($id)
    {
        $country = Parameter::findOrFail($id);

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

            $country->update($data);

            return redirect()->route('settingsCountry')->with('success', 'Country updated successfully.');
        }

        return view('setting.country-edit', compact(['country']));
    }

    public function institute()
    {
        $institutes = Parameter::where('grp', 'clientcate1')
                    // ->orderBy('idx')
                    ->paginate(10);

        return view('setting.institute', compact(['institutes']));
    }
    public function instituteCreate()
    {
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

            $data['grp'] = 'clientcate1';
            $data['sta'] = 1;
            $data['isdel'] = 0;
            $data['sid'] = 1;

            Parameter::create($data);

            return redirect()->route('settingsInstitute')->with('success', 'Institute created successfully.');
        }
        return view('setting.institute-create');
    }
    public function instituteEdit($id)
    {
        $institute = Parameter::findOrFail($id);

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

            $institute->update($data);

            return redirect()->route('settingsInstitute')->with('success', 'Institute updated successfully.');
        }

        return view('setting.institute-edit', compact(['institute']));
    }

    public function list(Request $request)
    {
        $selectedGroup = $request->input('grp', 'clientcate1');
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

        $items = $query->paginate(10);

        $groups = [
            'country'      => 'Country',
            'state'        => 'State',
            'city'         => 'City',
            'district'     => 'District',
            'subdistrict'  => 'Sub District',
            'clientcate1'  => 'Institute',
            'type_CLIENT'  => 'Jenis Institusi',
        ];



        return view('setting.list', compact(['items', 'groups', 'parentGroup', 'selectedGroup', 'selectedParent']));
    }

    public function create(Request $request)
    {


        $selectedGroup = $request->query('group');   // e.g. ?group=country
        $selectedParent = $request->query('parent'); // e.g. ?parent=Malaysia

        $parent = Parameter::where('code', $selectedParent)
                    ->value('grp'); // Get the 'grp' value directly

        $parentGroup = Parameter::where('grp', $parent)
                    ->pluck('prm', 'code')
                    ->toArray();


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


            $data['grp'] = $selectedGroup;
            $data['sta'] = 1;
            $data['isdel'] = 0;
            $data['sid'] = 1;

            Parameter::create($data);

            return redirect()->route('settingsList')->with('success', 'Parameter created successfully.');
        }
        return view('setting.create', compact(['selectedGroup', 'selectedParent', 'parentGroup']));

    }


    public function edit($id)
    {
        $item = Parameter::findOrFail($id);

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

        return view('setting.edit', compact(['item']));
    }

}
