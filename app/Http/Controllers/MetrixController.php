<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;
use MongoDB\Client as MongoClient;

class MetrixController extends Controller
{
    private $client;
    private $collection;

    public function __construct()
    {
        $this->client = new MongoClient('mongodb+srv://development:XT7GquBxdsk5wMru@ebossdevelopment.ekek02t.mongodb.net/?retryWrites=true&w=majority');
        $this->collection = $this->client->mais->payment_metrix;
    }

    public function compensationList()
    {
        $settings = $this->collection->findOne(['setting_category' => 'kaffarah']);
    
        $payment_metrix = isset($settings['kaffarah']['kaffarah_settings'])
            ? $settings['kaffarah']['kaffarah_settings']
            : [];
    
        $activeSetting = $settings['kaffarah']['active_setting'] ?? null;
    
        return view('metrix.compensation_list', compact('payment_metrix', 'activeSetting'));
    }
    

    public function create()
    {
        return view('metrix.compensation_create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'offense_type.*.parameter' => 'required|string',
            'offense_type.*.value' => 'required|numeric',
            'kaffarah_item.*.name' => 'required|string',
            'kaffarah_item.*.price' => 'required|numeric',
            'rate' => 'required|numeric',
        ]);

        $newSetting = [
            '_id' => new ObjectId(),
            'title' => $validated['title'],
            'code' => $this->generateCode(),
            'offense_type' => array_map(function ($offense, $index) {
                return array_merge($offense, ['index' => $index + 1]);
            }, $validated['offense_type'], array_keys($validated['offense_type'])),
            'kaffarah_item' => array_map(function ($item) use ($validated) {
                $item['price'] = (float) $item['price'];
                return array_merge($item, [
                    'rate_value' => ceil($item['price'] * (float) $validated['rate']),
                ]);
            }, $validated['kaffarah_item']),
            'rate' => (float) $validated['rate'],
            'is_active' => false,
        ];

        $this->collection->updateOne(
            ['setting_category' => 'kaffarah'],
            ['$push' => ['kaffarah.kaffarah_settings' => $newSetting]],
            ['upsert' => true]
        );

        return redirect()->route('compensation.list')->with('success', 'Kaffarah setting added successfully!');
    }

    private function generateCode()
    {
        // Retrieve the settings
        $settings = $this->collection->findOne(['setting_category' => 'kaffarah']);
        
        // Check if 'kaffarah_settings' is set and is a BSONArray, then convert it to a regular array
        $kaffarahSettings = isset($settings['kaffarah']['kaffarah_settings'])
            ? iterator_to_array($settings['kaffarah']['kaffarah_settings'])
            : [];
    
        // Get the count of existing settings
        $count = count($kaffarahSettings);
    
        // Generate the new code based on the count
        $newCode = str_pad($count + 1, 4, '0', STR_PAD_LEFT); // e.g., '0006', '0121'
    
        return $newCode;
    }
    
    public function markAsActive(Request $request, $id)
    {
        $settings = $this->collection->findOne(['setting_category' => 'kaffarah']);

        if (!$settings) {
            return back()->with('error', 'Kaffarah settings not found.');
        }

        $kaffarahSettings = $settings['kaffarah']['kaffarah_settings'] ?? [];

        foreach ($kaffarahSettings as $index => &$setting) {
            $setting['is_active'] = false;

            if ((string) $setting['_id'] === $id) {
                $setting['is_active'] = true;
                $settings['kaffarah']['active_setting'] = [
                    'setting_id' => $setting['_id'],
                    'setting_code' => $setting['code'],
                ];
            }
        }

        $this->collection->updateOne(
            ['setting_category' => 'kaffarah'],
            [
                '$set' => [
                    'kaffarah.kaffarah_settings' => $kaffarahSettings,
                    'kaffarah.active_setting' => $settings['kaffarah']['active_setting'],
                ],
            ]
        );

        return back()->with('success', 'Kaffarah setting marked as active.');
    }
}
