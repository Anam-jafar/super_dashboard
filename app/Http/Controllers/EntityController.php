<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntityController extends Controller
{
    // Map route/view entity types to actual database tables
    private const TABLE_MAPPING = [
        'mosques' => 'client',
        'admins' => 'usr',
        'branches' => 'sch'
    ];

    private const ENTITY_TYPES = [
        'mosques' => [
            'table' => 'client',
            'view' => 'institutes',
            'validation' => [
                'name' => 'required|string|max:255',
                'hp' => 'nullable|string|max:50',
                'cate' => 'nullable|string|max:50',
                'sta' => 'nullable|string|max:50',
                // ... add other validation rules
            ]
        ],
        'admins' => [
            'table' => 'usr',
            'view' => 'admins',
            'validation' => [
                'name' => 'required|string|max:255',
                'syslevel' => 'required|string',
                'ic' => 'required|string|max:12',
                // ... add other validation rules
            ]
        ],
        'branches' => [
            'table' => 'sch',
            'view' => 'branches',
            'validation' => [
                'name' => 'required|string|max:255',
                'sname' => 'nullable|string|max:255',
                'tel' => 'nullable|string|max:15',
                // ... add other validation rules
            ]
        ]
    ];

    // Centralized method to fetch common lookup data
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

    // Generic listing method for all entity types
    public function index(Request $request, string $entityType)
    {
        $table = self::ENTITY_TYPES[$entityType]['table'];
        $data = $this->getListingData($table, $request, [
            'status' => 'sta',
            'sch' => 'sid',
            'city' => 'city'
        ]);
        
        $viewData = array_merge(
            ['entities' => $data],
            $this->getCommonLookupData()
        );
        
        return view(self::ENTITY_TYPES[$entityType]['view'] . '.index', $viewData);
    }

    // Generic show method for all entity types
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

    // Generic update method for all entity types
    public function update(Request $request, string $entityType, $id)
    {
        $request->validate(self::ENTITY_TYPES[$entityType]['validation']);
        
        $table = self::ENTITY_TYPES[$entityType]['table'];
        $updated = DB::table($table)
            ->where('id', $id)
            ->update($request->except(['_token', '_method']));

        $route = self::ENTITY_TYPES[$entityType]['view'] . '.index';
        
        return $updated
            ? redirect()->route($route)->with('success', ucfirst($entityType) . ' updated successfully.')
            : redirect()->back()->with('error', 'Failed to update ' . $entityType);
    }

    // Generic create method for all entity types
    public function create(string $entityType)
    {
        return view(
            self::ENTITY_TYPES[$entityType]['view'] . '.create',
            $this->getCommonLookupData()
        );
    }

    // Generic store method for all entity types
    public function store(Request $request, string $entityType)
    {
        $request->validate(self::ENTITY_TYPES[$entityType]['validation']);

        try {
            $table = self::ENTITY_TYPES[$entityType]['table'];
            $data = array_merge(
                $request->except(['_token']),
                $this->getDefaultValues($entityType)
            );

            $insertId = DB::table($table)->insertGetId($data);
            $entity = DB::table($table)->where('id', $insertId)->first();

            return response()->json($entity, 201);
        } catch (\Exception $e) {
            \Log::error("Error inserting into {$table} table: " . $e->getMessage());
            return response()->json(['error' => "Failed to insert {$entityType} data."], 500);
        }
    }

    // Helper method for pagination and filtering
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
    
        return $query->paginate($request->get('per_page', 10))->withQueryString();
    }

    // Helper method to get default values for new entities
    private function getDefaultValues(string $entityType)
    {
        $defaults = [
            'mosques' => [
                'uid' => 'c002020',
                'firebase_id' => '',
                'imgProfile' => '',
                'isustaz' => '',
                'iskariah' => '',
                'sid' => 0
            ]
            // Add defaults for other entity types as needed
        ];
        return $defaults[$entityType] ?? [];
    }
}