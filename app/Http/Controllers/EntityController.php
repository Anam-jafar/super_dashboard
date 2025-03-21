<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\RegistrationApproveConfirmation;
use Illuminate\Support\Facades\Mail;

class EntityController extends Controller
{

    /*
     mosque types
     SELECT * FROM `type` WHERE grp="type_CLIENT";

     user status
     SELECT * FROM `type` WHERE grp="clientstatus";

     States
     SELECT * FROM `type` WHERE grp="state";

     Areas
     SELECT * FROM `type` WHERE grp="clientcate1";

     Syslevels
     SELECT * FROM `type` WHERE grp="syslevel";

    */


    private const FILTER_MAPPINGS = [
        'mosques' => [
            'status' => 'sta',
            'sch' => 'sid',
            'city' => 'city',
            'type' => 'type',
            'cate' => 'cate',
            'district' => 'district',
        ],
        'admins' => [
            'status' => 'status',
            'sch' => 'sch_id',
        ],
        'branches' => [
            'status' => 'status',
        ],
    ];

    private const TABLE_MAPPING = [
        'mosques' => 'client',
        'admins' => 'usr',
        'branches' => 'sch',
    ];

    private const ENTITY_TYPES = [
        'mosques' => [
            'table' => 'client',
            'view' => 'institutes',
            'validation' => [],
        ],
        'admins' => [
            'table' => 'usr',
            'view' => 'admins',
            'validation' => [],
        ],
        'branches' => [
            'table' => 'sch',
            'view' => 'branches',
            'validation' => [],
        ],
    ];

    private function getCommonLookupData()
    {
        return [
            'cities' => DB::table('client')
                ->distinct()
                ->pluck('city')
                ->mapWithKeys(fn ($city) => [$city => $city])
                ->toArray(),
            'schs' => collect(DB::select('SELECT sname, sid FROM sch'))
                ->mapWithKeys(fn ($item) => [$item->sid => $item->sname])
                ->toArray(),
            'states' => DB::table('type')->where('grp', 'state')->get(),
            'syslevels' => DB::table('type')
                ->where('grp', 'syslevel')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),
            
            'statuses' => DB::table('type')
                ->where('grp', 'clientstatus')
                ->distinct()
                ->pluck('prm', 'val')
                ->toArray(),
            'areas' => DB::table('type')
                ->where('grp', 'clientcate1')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),
            'categories' => DB::table('type')
                ->where('grp', 'type_CLIENT')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),
            'institute_types' => DB::table('type')
                ->where('grp', 'clientcate1')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),  
            'institute_categories' => DB::table('type')
                ->where('grp', 'type_CLIENT')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),              
            'districts' => DB::table('type')
                ->where('grp', 'district')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),
            'sub_districts' => DB::table('type')
                ->where('grp', 'sub_district')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),
            'departments' => DB::table('type')
                ->where('grp', 'jobdiv')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),
            'admin_positions' => DB::table('type')
                ->where('grp', 'job')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),
            'user_positions' => DB::table('type')
                ->where('grp', 'externalposition')
                ->distinct()
                ->pluck('prm')
                ->mapWithKeys(fn ($prm) => [$prm => $prm])
                ->toArray(),
        ];
    }

    public function index(Request $request, string $entityType)
    {
        $table = self::ENTITY_TYPES[$entityType]['table'];

        $filterMappings = self::FILTER_MAPPINGS[$entityType] ?? [];

        $data = $this->getListingData($table, $request, $filterMappings);

        $viewData = array_merge(
            ['entities' => $data],
            $this->getCommonLookupData()
        );

        return view(self::ENTITY_TYPES[$entityType]['view'].'.index', $viewData);
    }

    public function show(string $entityType, $id)
    {
        $table = self::ENTITY_TYPES[$entityType]['table'];
        $entity = DB::table($table)->where('id', $id)->first();

        if (!$entity) {
            return redirect()->route(self::ENTITY_TYPES[$entityType]['view'].'.index')
                ->with('error', 'Record not found.');
        }

        $viewData = array_merge(
            ['entity' => $entity],
            $this->getCommonLookupData()
        );

        return view(self::ENTITY_TYPES[$entityType]['view'].'.show', $viewData);
    }

    public function detailList(Request $request, string $entityType)
    {
        $table = self::ENTITY_TYPES[$entityType]['table'];

        $filterMappings = self::FILTER_MAPPINGS[$entityType] ?? [];

        $data = $this->getListingData($table, $request, $filterMappings);

        $viewData = array_merge(
            ['entities' => $data],
            $this->getCommonLookupData()
        );

        return view(self::ENTITY_TYPES[$entityType]['view'].'.detail_list', $viewData);
    }
    
    public function detail(string $entityType, $id)
    {
        $table = self::ENTITY_TYPES[$entityType]['table'];
        $entity = DB::table($table)->where('id', $id)->first();

        if (!$entity) {
            return redirect()->route(self::ENTITY_TYPES[$entityType]['view'].'.detail_list')
                ->with('error', 'Record not found.');
        }

        $viewData = array_merge(
            ['entity' => $entity],
            $this->getCommonLookupData()
        );

        return view(self::ENTITY_TYPES[$entityType]['view'].'.detail', $viewData);
    }

    public function create(string $entityType)
    {
        return view(
            self::ENTITY_TYPES[$entityType]['view'].'.create',
            $this->getCommonLookupData()
        );
    }

    public function store(Request $request, string $entityType)
    {
        $validationRules = self::ENTITY_TYPES[$entityType]['validation'] ?? [];

        if (!empty($validationRules)) {
            $request->validate($validationRules);
        }

        $table = self::ENTITY_TYPES[$entityType]['table'];

        $data = array_merge(
            $request->except(['_token']),
            $this->getDefaultValues($entityType)
        );

        $created = DB::table($table)->insert($data);
        $route = self::ENTITY_TYPES[$entityType]['view'].'.index';
        if ($created) {
            $this->logActivity('Stored '.$entityType, $entityType.' Store attempt successful');
        } else {
            $this->logActivity('Stored '.$entityType, $entityType.' Store attempt failed');
        }

        return $created
            ? redirect()->route('showList', ['type' => $entityType])->with('success', ucfirst($entityType).' stored successfully.')
            : redirect()->back()->with('error', 'Failed to update '.$entityType);
    }

    public function update(Request $request, string $entityType, $id)
    {
        $validationRules = self::ENTITY_TYPES[$entityType]['validation'] ?? [];

        if (!empty($validationRules)) {
            $request->validate($validationRules);
        }

        $table = self::ENTITY_TYPES[$entityType]['table'];

        $updated = DB::table($table)
            ->where('id', $id)
            ->update($request->except(['_token', '_method']));

        $route = self::ENTITY_TYPES[$entityType]['view'].'.index';

        if ($updated) {
            $this->logActivity('Updated '.$entityType, $entityType.' Update attempt successful');
        } else {
            $this->logActivity('Updated '.$entityType, $entityType.' Update attempt failed');
        }

        return $updated
            ? redirect()->route('showList', ['type' => $entityType])->with('success', ucfirst($entityType).' updated successfully.')
            : redirect()->back()->with('error', 'Failed to update '.$entityType);
    }

    private function getListingData($table, Request $request, $additionalFilters = [])
    {
        $query = DB::table($table)->orderBy('id', 'desc');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->input('search').'%');
        }

        foreach ($additionalFilters as $filter => $field) {
            if ($request->filled($filter)) {
                $query->where($field, $request->input($filter));
            }
        }

        return $query->paginate($request->get('per_page', 10))->withQueryString();
    }


    private function getDefaultValues(string $entityType)
    {
        $defaults = [
            'mosques' => [
                'uid' => $this->generateUniqueUid(),
                'firebase_id' => '',
                'imgProfile' => '',
                'isustaz' => '',
                'iskariah' => '',
                'sid' => 1,
            ],
        ];

        return $defaults[$entityType] ?? [];
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
        public function outstandingSubscriptions(Request $request)
    {
        $per_page = $request->per_page ?? 10;

        // Query builder for subscriptions with joinSub
        $query = DB::table('client as y')
            ->joinSub(
                DB::table('type')
                    ->select('prm', 'etc')
                    ->where('grp', 'type_CLIENT'),
                'x',
                'x.prm',
                '=',
                'y.cate'
            )
            ->where('y.subscription_status', 2);

        // Apply search filter (searching by name)
        if ($request->filled('search')) {
            $query->where('y.name', 'like', '%' . $request->search . '%');
        }

        // Apply institute type filter
        if ($request->filled('institute_type')) {
            $query->where('x.etc', $request->institute_type);
        }

        // Apply area filter
        if ($request->filled('area')) {
            $query->where('y.cate1', $request->area);
        }

        // Select necessary columns
        // $query->select('y.*', 'x.prm', 'x.etc');

        // Paginate results
        $subscriptions = $query->paginate($per_page)->withQueryString();

        $statuses = DB::table('type')->where('grp', 'clientstatus')->get();
                // Fetch dropdown data
        
        $daerah = DB::table('type')
            ->where('grp', 'clientcate1')
            ->distinct()
            ->pluck('prm')
            ->mapWithKeys(fn ($prm) => [$prm => $prm])
            ->toArray();

        // $instituteType = DB::table('type')
        //     ->where('grp', 'type_CLIENT')
        //     ->pluck('prm')
        //     ->mapWithKeys(fn ($prm) => [$prm => $prm])
        //     ->toArray();
        $instituteType = DB::table('type')
            ->where('grp', 'type_CLIENT')
            ->groupBy('etc')
            ->pluck('etc')
            ->mapWithKeys(fn ($etc) => [$etc => $etc])
            ->toArray();

        
        return view('subscription.outstanding_list', compact(['subscriptions', 'statuses', 'daerah', 'instituteType']));
    }

    public function instituteActivateRequestList(Request $request)
    {
        $per_page = $request->per_page ?? 10;

        $query = DB::table('client')
            ->where('sta', 1)
            ->where('registration_request_date', '!=', null)
            ->where('regdt', null)
            ->orderBy('id', 'desc');
        
        // Apply search filter (searching by name)
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Apply institute type filter
        if ($request->filled('institute_type')) {
            $query->where('type', $request->institute_type);
        }

        // Apply area filter
        if ($request->filled('institute_category')) {
            $query->where('cate', $request->area);
        }
        $requests = $query->paginate($per_page)->withQueryString();
                $statuses = DB::table('type')->where('grp', 'clientstatus')->get();
                // Fetch dropdown data

        return view('institutes.detail_list', compact(['requests', 'statuses']));
            
    }

    public function approve(Request $request, string $entityType, $id)
    {
        // $validationRules = self::ENTITY_TYPES[$entityType]['validation'] ?? [];

        $updated= DB::table('client')
            ->where('id', $id)
            ->update(['sta' => 0, 
                      'mel' => $request->mel,
                      'regdt' => now()->toDateString(),
                    ]);


        // $route = self::ENTITY_TYPES[$entityType]['view'].'.index';

        if ($updated) {
            $this->logActivity('Approve '.$entityType, $entityType.' Approve attempt successful');
                Mail::to($request->mel)->send(new RegistrationApproveConfirmation($request->mel));

        } else {
            $this->logActivity('Approve '.$entityType, $entityType.' Approve attempt failed');
        }

        return $updated
            ? redirect()->route('instituteActivateRequestList')->with('success', ucfirst($entityType).' Approved successfully.')
            : redirect()->back()->with('error', 'Failed to update '.$entityType);
    }

}
