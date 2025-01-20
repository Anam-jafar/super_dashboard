<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntityController extends Controller
{
    private const FILTER_MAPPINGS = [
        'mosques' => [
            'status' => 'sta',
            'sch' => 'sid',
            'city' => 'city',
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
        'branches' => 'sch'
    ];

    private const ENTITY_TYPES = [
        'mosques' => [
            'table' => 'client',
            'view' => 'institutes',
            'validation' => [] 
        ],
        'admins' => [
            'table' => 'usr',
            'view' => 'admins',
            'validation' => [] 
        ],
        'branches' => [
            'table' => 'sch',
            'view' => 'branches',
            'validation' => [] 
        ]
    ];


    private function getCommonLookupData()
    {
        return [
            'cities' => DB::table('client')
                ->distinct()
                ->pluck('city')
                ->mapWithKeys(fn($city) => [$city => $city])
                ->toArray(),
            'schs' => collect(DB::select('SELECT sname, sid FROM sch'))
                ->mapWithKeys(fn($item) => [$item->sid => $item->sname])
                ->toArray(),
            'statuses' => DB::table('type')->where('grp', 'clientstatus')->get(),
            'categories' => DB::table('type')->where('grp', 'type_CLIENT')->get(),
            'states' => DB::table('type')->where('grp', 'state')->get(),
            'areas' => DB::table('type')->where('grp', 'clientcate1')->get(),
            'syslevels' => DB::table('type')->where('grp', 'syslevel')->get()
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
        
        return view(self::ENTITY_TYPES[$entityType]['view'] . '.index', $viewData);
    }

    public function show(string $entityType, $id)
    {
        $table = self::ENTITY_TYPES[$entityType]['table'];
        $entity = DB::table($table)->where('id', $id)->first();
        
        if (!$entity) {
            return redirect()->route(self::ENTITY_TYPES[$entityType]['view'] . '.index')
                ->with('error', 'Record not found.');
        }
        
        $viewData = array_merge(
            ['entity' => $entity],
            $this->getCommonLookupData()
        );
        
        return view(self::ENTITY_TYPES[$entityType]['view'] . '.show', $viewData);
    }


    public function create(string $entityType)
    {
        return view(
            self::ENTITY_TYPES[$entityType]['view'] . '.create',
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

    $route = self::ENTITY_TYPES[$entityType]['view'] . '.index';
    if ($created) {
        $this->logActivity('Stored new '.$entityType, $entityType.' Store attempt successful');
    } else {
        $this->logActivity('Stored new '.$entityType, $entityType.' Store attempt failed');
    }
    return $created
        ? redirect()->route('showList', ['type' => $entityType])->with('success', ucfirst($entityType) . ' stored successfully.')
        : redirect()->back()->with('error', 'Failed to update ' . $entityType);
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

    $route = self::ENTITY_TYPES[$entityType]['view'] . '.index';
    
    if ($updated) {
        $this->logActivity('Updated '.$entityType, $entityType.' Update attempt successful');
    } else {
        $this->logActivity('Updated '.$entityType, $entityType.' Update attempt failed');
    }
    return $updated
        ? redirect()->route('showList', ['type' => $entityType])->with('success', ucfirst($entityType) . ' updated successfully.')
        : redirect()->back()->with('error', 'Failed to update ' . $entityType);
}


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
    
        return $query->paginate($request->get('per_page', 25))->withQueryString();
    }

    private function getDefaultValues(string $entityType)
    {
        $defaults = [
            'mosques' => [
                'uid' => 'C002020',
                'firebase_id' => '',
                'imgProfile' => '',
                'isustaz' => '',
                'iskariah' => '',
                'sid' => 0
            ]
        ];
        return $defaults[$entityType] ?? [];
    }
}