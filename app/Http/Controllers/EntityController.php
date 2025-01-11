<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntityController extends Controller
{

    private const CLIENT_BASE_QUERY = [
        'app' => 'CLIENT',
        'isdel' => 0
    ];

    // Generic database query method to reduce redundancy
    private function executeQuery($table, $constraints = [], $aggregation = null, $groupBy = null)
    {
        $query = DB::table($table);
        
        foreach ($constraints as $field => $value) {
            $query->where($field, $value);
        }
        
        if ($aggregation) {
            $query->select(DB::raw($aggregation));
        }
        
        if ($groupBy) {
            $query->groupBy($groupBy);
        }
        
        return $query;
    }
    private function getListingData($table, Request $request, $additionalFilters = [])
    {
        $query = DB::table($table);
    
        // Handle search filter
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }
    
        // Handle additional filters
        foreach ($additionalFilters as $filter => $field) {
            if ($request->filled($filter)) {
                $query->where($field, $request->input($filter));
            }
        }
    
        // Get the pagination limit per page from request
        $recordsPerPage = $request->get('per_page', 10);
    
        // Paginate the results
        $paginatedData = $query->paginate($recordsPerPage);
    
        // Add the query parameters to pagination links to maintain the filters
        $paginatedData->withQueryString(); // Retains all query parameters like search, perPage, etc.
    
        return $paginatedData;
    }
    
    public function showEntityList(Request $request)
    {
        $cities = DB::table('client')
            ->distinct()
            ->pluck('city')
            ->mapWithKeys(fn($city) => [$city => $city])
            ->toArray();

        $schs = DB::select('SELECT sname, sid FROM sch');
        $schs = collect($schs)->mapWithKeys(function ($item) {
            return [$item->sid => $item->sname];
        })->toArray();
        $clients = $this->getListingData('client', $request, [
            'status' => 'sta',
            'sch' => 'sid',
            'city' => 'city'
        ]);

        $statuses = DB::table('type')->where('grp', 'clientstatus')->get();
        $categories = DB::table('type')->where('grp', 'type_CLIENT')->get();
        $states = DB::table('type')->where('grp', 'state')->get();
        
        $areas = DB::table('type')->where('grp', 'clientcate1')->get();




        return view('base.mosques', compact('clients', 'cities', 'schs', 'statuses', 'categories', 'states', 'areas'));
    }

    public function showBranchList(Request $request)
    {
        $branches = $this->getListingData('sch', $request);
        return view('base.branches', compact('branches'));
    }

    public function showAdminList(Request $request)
    {
        $formFields = [
            ['id' => 'name', 'label' => 'Nama'],
            ['id' => 'syslevel', 'label' => 'Level Sistem'],
            ['id' => 'ic', 'label' => 'Nombor KP'],
            ['id' => 'sysaccess', 'label' => 'Capaian Sistem'],
            ['id' => 'hp', 'label' => 'Tel. Bimbit'],
            ['id' => 'jobstart', 'label' => 'Tarikh Mula'],
            ['id' => 'mel', 'label' => 'Emel'],
            ['id' => 'status', 'label' => 'Status']
        ];
        $schs = DB::select('SELECT sname, sid FROM sch');
        $schs = collect($schs)->mapWithKeys(function ($item) {
            return [$item->sid => $item->sname];
        })->toArray();
        $admins = $this->getListingData('usr', $request, ['sch' => 'sch_id']);

        $statuses = DB::table('type')->where('grp', 'clientstatus')->get();
        $syslevels = DB::table('type')->where('grp', 'syslevel')->get();

        return view('base.admins', compact('admins', 'schs', 'formFields', 'statuses', 'syslevels'));
    }

    // Generic CRUD operations
    private function handleEntityOperation($table, $id, $request = null)
    {
        if (!$request) {
            $entity = DB::table($table)->where('id', $id)->first();
            return $entity 
                ? response()->json($entity)
                : response()->json(['error' => ucfirst($table) . ' not found'], 404);
        }

        $entity = DB::table($table)->where('id', $id)->first();
        if (!$entity) {
            return response()->json(['error' => ucfirst($table) . ' not found'], 404);
        }

        DB::table($table)->where('id', $id)->update($request->all());
        return response()->json(DB::table($table)->where('id', $id)->first());
    }

    // CRUD route handlers
    public function getMosqueDetails($id) { return $this->handleEntityOperation('client', $id); }
    public function update(Request $request, $id) { return $this->handleEntityOperation('client', $id, $request); }
    public function getDetails($id) { return $this->handleEntityOperation('usr', $id); }
    // public function updateAdmin(Request $request, $id) { return $this->handleEntityOperation('usr', $id, $request); }
    public function getBranchDetails($id) { return $this->handleEntityOperation('sch', $id); }
    // public function updateBranch(Request $request, $id) { return $this->handleEntityOperation('sch', $id, $request); }

public function showEntity($id)
{
            $cities = DB::table('client')
            ->distinct()
            ->pluck('city')
            ->mapWithKeys(fn($city) => [$city => $city])
            ->toArray();

        $schs = DB::select('SELECT sname, sid FROM sch');
        $schs = collect($schs)->mapWithKeys(function ($item) {
            return [$item->sid => $item->sname];
        })->toArray();


        $statuses = DB::table('type')->where('grp', 'clientstatus')->get();
        $categories = DB::table('type')->where('grp', 'type_CLIENT')->get();
        $states = DB::table('type')->where('grp', 'state')->get();
        
        $areas = DB::table('type')->where('grp', 'clientcate1')->get();
    // Fetch the client record with the specified ID
    $mosque = DB::table('client')->where('id', $id)->first();

    // Check if the record exists
    if (!$mosque) {
        return redirect()->route('institutes.index')->with('error', 'Record not found.');
    }

    // Pass the fetched data to the 'institutes.show' view
    return view('institutes.show', compact('mosque', 'statuses', 'categories', 'areas', 'states'));
}

public function updateEntity(Request $request, $id)
{
    // Validate the incoming request
    // $validatedData = $request->validate([
    //     'name' => 'required|string|max:255',
    //     'hp' => 'nullable|string|max:50',
    //     'cate' => 'nullable|string|max:50',
    //     'sta' => 'nullable|string|max:50',
    //     'cate1' => 'nullable|string|max:50',
    //     'mel' => 'nullable|email|max:255',
    //     'tel' => 'nullable|string|max:50',
    //     'addr' => 'nullable|string|max:255',
    //     'addr1' => 'nullable|string|max:255',
    //     'city' => 'nullable|string|max:100',
    //     'pcode' => 'nullable|string|max:20',
    //     'state' => 'nullable|string|max:100',
    //     'country' => 'nullable|string|max:100',
    //     'rem1' => 'nullable|string|max:255',
    //     'rem2' => 'nullable|string|max:255',
    //     'rem3' => 'nullable|string|max:255',
    // ]);

    $validatedData = $request->all();

    // Update the mosque record
    $updated = DB::table('client')->where('id', $id)->update([
        'name' => $validatedData['name'],
        'hp' => $validatedData['hp'] ?? null,
        'cate' => $validatedData['cate'] ?? null,
        'sta' => $validatedData['sta'] ?? null,
        'cate1' => $validatedData['cate1'] ?? null,
        'mel' => $validatedData['mel'] ?? null,
        'tel' => $validatedData['tel'] ?? null,
        'addr' => $validatedData['addr'] ?? null,
        'addr1' => $validatedData['addr1'] ?? null,
        'city' => $validatedData['city'] ?? null,
        'pcode' => $validatedData['pcode'] ?? null,
        'state' => $validatedData['state'] ?? null,
        'country' => $validatedData['country'] ?? null,
        'rem1' => $validatedData['rem1'] ?? null,
        'rem2' => $validatedData['rem2'] ?? null,
        'rem3' => $validatedData['rem3'] ?? null,
    ]);

    if ($updated) {
        return redirect()->route('showEntityList')->with('success', 'Mosque updated successfully.');
    }

    return redirect()->back()->with('error', 'Failed to update the mosque.');
}

public function showAdmin($id)
{
            $cities = DB::table('client')
            ->distinct()
            ->pluck('city')
            ->mapWithKeys(fn($city) => [$city => $city])
            ->toArray();

        $schs = DB::select('SELECT sname, sid FROM sch');
        $schs = collect($schs)->mapWithKeys(function ($item) {
            return [$item->sid => $item->sname];
        })->toArray();


        $statuses = DB::table('type')->where('grp', 'clientstatus')->get();
        $categories = DB::table('type')->where('grp', 'type_CLIENT')->get();
        $states = DB::table('type')->where('grp', 'state')->get();
        
        $areas = DB::table('type')->where('grp', 'clientcate1')->get();
                $syslevels = DB::table('type')->where('grp', 'syslevel')->get();

    // Fetch the client record with the specified ID
    $admin = DB::table('usr')->where('id', $id)->first();

    // Check if the record exists
    if (!$admin) {
        return redirect()->route('showAdminList')->with('error', 'Record not found.');
    }

    // Pass the fetched data to the 'institutes.show' view
    return view('admins.show', compact('admin', 'statuses', 'categories', 'areas', 'states', 'syslevels'));
}

public function updateAdmin(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'syslevel' => 'required|string',
        'ic' => 'required|string|max:12',
        'sysaccess' => 'required|string',
        'hp' => 'required|string|max:15',
        'jobstart' => 'required|date',
        'mel' => 'required|email',
        'status' => 'required|string',
    ]);

    DB::table('usr')->where('id', $id)->update([
        'name' => $request->name,
        'syslevel' => $request->syslevel,
        'ic' => $request->ic,
        'sysaccess' => $request->sysaccess,
        'hp' => $request->hp,
        'jobstart' => $request->jobstart,
        'mel' => $request->mel,
        'status' => $request->status,
    ]);

    return redirect()->route('showAdminList')->with('success', 'Pentadbir berjaya dikemaskini.');
}

public function showBranch($id)
{
            $cities = DB::table('client')
            ->distinct()
            ->pluck('city')
            ->mapWithKeys(fn($city) => [$city => $city])
            ->toArray();

        $schs = DB::select('SELECT sname, sid FROM sch');
        $schs = collect($schs)->mapWithKeys(function ($item) {
            return [$item->sid => $item->sname];
        })->toArray();


        $statuses = DB::table('type')->where('grp', 'clientstatus')->get();
        $categories = DB::table('type')->where('grp', 'type_CLIENT')->get();
        $states = DB::table('type')->where('grp', 'state')->get();
        
        $areas = DB::table('type')->where('grp', 'clientcate1')->get();
                $syslevels = DB::table('type')->where('grp', 'syslevel')->get();

    // Fetch the client record with the specified ID
    $branch = DB::table('sch')->where('id', $id)->first();

    // Check if the record exists
    if (!$branch) {
        return redirect()->route('showBranchList')->with('error', 'Record not found.');
    }

    // Pass the fetched data to the 'institutes.show' view
    return view('branches.show', compact('branch', 'statuses', 'categories', 'areas', 'states', 'syslevels'));
}

public function updateBranch(Request $request, $id)
{
    // Validate the incoming data
    // $validatedData = $request->validate([
    //     'name' => 'required|string|max:255',
    //     'sname' => 'nullable|string|max:255',
    //     'tel' => 'nullable|string|max:15',
    //     'mel' => 'nullable|email|max:255',
    //     'url' => 'nullable|url|max:255',
    //     'addr' => 'required|string|max:255',
    //     'addr1' => 'nullable|string|max:255',
    //     'addr2' => 'nullable|string|max:255',
    //     'daerah' => 'required|string|max:255',
    //     'poskod' => 'required|string|max:10',
    //     'state' => 'required|string|max:255',
    //     'country' => 'required|string|max:255',
    // ]);

    $validatedData = $request->all();

    // Find the branch by ID
    $branch = DB::table('sch')->where('id', $id)->first();

    if (!$branch) {
        return redirect()->route('showBranchList')->with('error', 'Branch not found.');
    }

    // Update the branch data
    // Update the branch data in the 'sch' table
    DB::table('sch')->where('id', $id)->update([
        'name' => $request->name,
        'sname' => $request->sname,
        'tel' => $request->tel,
        'mel' => $request->mel,
        'url' => $request->url,
        'addr' => $request->addr,
        'addr1' => $request->addr1,
        'addr2' => $request->addr2,
        'daerah' => $request->daerah,
        'poskod' => $request->poskod,
        'state' => $request->state,
        'country' => $request->country,
    ]);

    // Redirect back to the show page with a success message
    return redirect()->route('showBranchList', $branch->id)->with('success', 'Branch updated successfully.');
}




    public function createInstitute(){

                $cities = DB::table('client')
            ->distinct()
            ->pluck('city')
            ->mapWithKeys(fn($city) => [$city => $city])
            ->toArray();

        $schs = DB::select('SELECT sname, sid FROM sch');
        $schs = collect($schs)->mapWithKeys(function ($item) {
            return [$item->sid => $item->sname];
        })->toArray();

        $statuses = DB::table('type')->where('grp', 'clientstatus')->get();
        $categories = DB::table('type')->where('grp', 'type_CLIENT')->get();
        $states = DB::table('type')->where('grp', 'state')->get();
        
        $areas = DB::table('type')->where('grp', 'clientcate1')->get();

        return view('institutes.create', compact('cities', 'schs', 'statuses', 'categories', 'states', 'areas'));
    }

    public function createAdmin(){
                    $cities = DB::table('client')
            ->distinct()
            ->pluck('city')
            ->mapWithKeys(fn($city) => [$city => $city])
            ->toArray();

        $schs = DB::select('SELECT sname, sid FROM sch');
        $schs = collect($schs)->mapWithKeys(function ($item) {
            return [$item->sid => $item->sname];
        })->toArray();

        $statuses = DB::table('type')->where('grp', 'clientstatus')->get();
        $categories = DB::table('type')->where('grp', 'type_CLIENT')->get();
        $states = DB::table('type')->where('grp', 'state')->get();
        
        $areas = DB::table('type')->where('grp', 'clientcate1')->get();
        $syslevels = DB::table('type')->where('grp', 'syslevel')->get();
        
    return view('admins.create', compact('cities', 'schs', 'statuses', 'categories', 'states', 'areas', 'syslevels'));

    }

    public function createBranch(){

                            $cities = DB::table('client')
            ->distinct()
            ->pluck('city')
            ->mapWithKeys(fn($city) => [$city => $city])
            ->toArray();

        $schs = DB::select('SELECT sname, sid FROM sch');
        $schs = collect($schs)->mapWithKeys(function ($item) {
            return [$item->sid => $item->sname];
        })->toArray();

        $statuses = DB::table('type')->where('grp', 'clientstatus')->get();
        $categories = DB::table('type')->where('grp', 'type_CLIENT')->get();
        $states = DB::table('type')->where('grp', 'state')->get();
        
        $areas = DB::table('type')->where('grp', 'clientcate1')->get();
        
    return view('branches.create', compact('cities', 'schs', 'statuses', 'categories', 'states', 'areas'));
    }


public function store(Request $request)
{
    // Optional validation (uncomment if needed)
    // $validator = Validator::make($request->all(), [
    //     'name' => 'required|string|max:255',
    //     'con1' => 'nullable|string|max:255',
    //     'cate' => 'nullable|string|max:255',
    //     'cate1' => 'nullable|string|max:255',
    //     'sta' => 'nullable|integer',
    //     'mel' => 'nullable|email|max:255',
    //     'hp' => 'nullable|string|max:255',
    //     'addr' => 'nullable|string|max:255',
    //     'addr1' => 'nullable|string|max:255',
    //     'addr2' => 'nullable|string|max:255',
    //     'pcode' => 'nullable|string|max:20',
    //     'city' => 'nullable|string|max:255',
    //     'state' => 'nullable|string|max:255',
    //     'country' => 'nullable|string|max:255',
    //     'rem1' => 'nullable|string|max:255',
    //     'rem2' => 'nullable|string|max:255',
    //     'rem3' => 'nullable|string|max:255',
    // ]);

    // if ($validator->fails()) {
    //     return response()->json(['errors' => $validator->errors()], 422);
    // }
 
    try {
        $insertId = DB::table('client')->insertGetId([
            'name' => $request->input('name'),
            'con1' => $request->input('con1'),
            'cate' => $request->input('cate'),
            'cate1' => $request->input('cate1'),
            'sta' => (int) $request->input('sta'), // Explicitly cast to int
            'mel' => $request->input('mel'),
            'hp' => $request->input('hp'),
            'addr' => $request->input('addr'),
            'addr1' => $request->input('addr1'),
            'addr2' => $request->input('addr2'),
            'pcode' => $request->input('pcode'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'country' => $request->input('country'),
            'rem1' => $request->input('rem1'),
            'rem2' => $request->input('rem2'),
            'rem3' => $request->input('rem3'),
            'uid' => 'c002020',
            'firebase_id' => '',
            'imgProfile' => '',
            'isustaz' => '',
            'iskariah' => '',
            'sid' => 0,
        ]);

        // Fetch the inserted row to return as a response
        $mosque = DB::table('client')->where('id', $insertId)->first();

        return response()->json($mosque, 201);

    } catch (\Exception $e) {
        // Log the error for debugging and return a 500 response
        \Log::error('Error inserting into client table: ' . $e->getMessage());

        return response()->json(['error' => 'Failed to insert client data.'], 500);
    }
}
}
