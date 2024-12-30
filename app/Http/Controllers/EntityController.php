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
        // Generic listing method to handle mosque, branch, and admin listings
        private function getListingData($table, Request $request, $additionalFilters = [])
        {
            $query = DB::table($table);
            
            if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->input('search') . '%');
            }
            
            foreach ($additionalFilters as $filter => $field) {
                if ($request->filled($filter)) {
                    $query->where($field, $request->input($filter));
                }
            }
            
            return $query->paginate($request->get('recordsPerPage', 25));
        }
    public function showEntityList(Request $request)
    {
        $cities = DB::table('client')->distinct()->pluck('city');
        $schs = DB::select('SELECT sname, sid FROM sch');
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
    public function updateAdmin(Request $request, $id) { return $this->handleEntityOperation('usr', $id, $request); }
    public function getBranchDetails($id) { return $this->handleEntityOperation('sch', $id); }
    public function updateBranch(Request $request, $id) { return $this->handleEntityOperation('sch', $id, $request); }


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
