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

    public function expiationList()
    {
        $settings = $this->collection->findOne(['setting_category' => 'kaffarah']);
    
        $payment_metrix = isset($settings['kaffarah']['kaffarah_settings'])
            ? $settings['kaffarah']['kaffarah_settings']
            : [];
    
        $activeSetting = $settings['kaffarah']['active_setting'] ?? null;

        $payment_metrix = collect($payment_metrix)->sortByDesc('is_active');

    
        return view('metrix.compensation_list', compact('payment_metrix', 'activeSetting'));
    }

    public function compensationList()
    {
        $settings = $this->collection->findOne(['setting_category' => 'fidyah']);
    
        $payment_metrix = isset($settings['fidyah']['fidyah_settings'])
            ? $settings['fidyah']['fidyah_settings']
            : [];
    
        $activeSetting = $settings['fidyah']['active_setting'] ?? null;
    
        return view('metrix.settings_list', compact('payment_metrix', 'activeSetting'));
    }
    

    public function expiationCreate()
    {
        return view('metrix.compensation_create');
    }

    public function compensationCreate()
    {
        return view('metrix.settings_create');
    }

    public function expiationStore(Request $request)
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
            'code' => $this->generateCode('kaffarah'),
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

        public function compensationStore(Request $request)
{
        $validated = $request->validate([
        'title' => 'required|string|max:255',
        'individual_status.*.parameter' => 'required|string',
        'individual_status.*.categories.*.parameter' => 'required|string',
        'fidyah_item.*.name' => 'required|string',
        'fidyah_item.*.price' => 'required|numeric',
        'rate' => 'required|numeric',
    ]);

    $newSetting = [
        '_id' => new ObjectId(),
        'title' => $validated['title'],
        'code' => $this->generateCode('fidyah'),
        'individual_status' => array_map(function ($status, $statusIndex) {
            $status['categories'] = array_map(function ($category, $categoryIndex) {
                $category['code'] = 'cat' . str_pad($categoryIndex + 1, 2, '0', STR_PAD_LEFT);
                return $category;
            }, $status['categories'], array_keys($status['categories']));
            $status['code'] = 'st' . str_pad($statusIndex + 1, 2, '0', STR_PAD_LEFT);
            return $status;
        }, $validated['individual_status'], array_keys($validated['individual_status'])),
        'fidyah_item' => array_map(function ($item) use ($validated) {
            $item['rate_value'] = ceil($item['price'] * $validated['rate']);
            return $item;
        }, $validated['fidyah_item']),
        'rate' => (float) $validated['rate'],
        'is_active' => false,
    ];

    $this->collection->updateOne(
        ['setting_category' => 'fidyah'],
        ['$push' => ['fidyah.fidyah_settings' => $newSetting]],
        ['upsert' => true]
    );

    return redirect()->route('compensation_.list')->with('success', 'Fidyah setting added successfully!');
}




private function generateCode(string $settingCategory)
{
    // Retrieve the settings based on the category
    $settings = $this->collection->findOne(['setting_category' => $settingCategory]);

    // Ensure the structure is correct and retrieve the settings array
    $settingsKey = "{$settingCategory}_settings"; // e.g., "kaffarah_settings" or "fidyah_settings"
    $categorySettings = $settings[$settingCategory][$settingsKey] ?? [];

    // If the settings array is a BSONArray, convert it to a regular array
    if ($categorySettings instanceof \MongoDB\Model\BSONArray) {
        $categorySettings = $categorySettings->getArrayCopy();
    }

    // Get the count of existing settings
    $count = count($categorySettings);

    // Generate the new code based on the count
    $newCode = str_pad($count + 1, 4, '0', STR_PAD_LEFT); // e.g., '0006', '0121'

    return $newCode;
}

    
    public function compensationMarkAsActive(Request $request, $id)
    {
        $settings = $this->collection->findOne(['setting_category' => 'fidyah']);

        if (!$settings) {
            return back()->with('error', 'Fidyah settings not found.');
        }

        $kaffarahSettings = $settings['fidyah']['fidyah_settings'] ?? [];

        foreach ($kaffarahSettings as $index => &$setting) {
            $setting['is_active'] = false;

            if ((string) $setting['_id'] === $id) {
                $setting['is_active'] = true;
                $settings['fidyah']['active_setting'] = [
                    'setting_id' => $setting['_id'],
                    'setting_code' => $setting['code'],
                ];
            }
        }

        $this->collection->updateOne(
            ['setting_category' => 'fidyah'],
            [
                '$set' => [
                    'fidyah.fidyah_settings' => $kaffarahSettings,
                    'fidyah.active_setting' => $settings['fidyah']['active_setting'],
                ],
            ]
        );

        return back()->with('success', 'Fidya setting marked as active.');
    }
        
    public function expiationMarkAsActive(Request $request, $id)
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

    public function expiationEdit($id)
{
    $setting = $this->collection->findOne(
        ['setting_category' => 'kaffarah', 'kaffarah.kaffarah_settings._id' => new ObjectId($id)],
        ['projection' => ['kaffarah.kaffarah_settings.$' => 1]]
    );

    if (!$setting || empty($setting['kaffarah']['kaffarah_settings'])) {
        return redirect()->route('compensation.list')->with('error', 'Kaffarah setting not found.');
    }

    $setting = $setting['kaffarah']['kaffarah_settings'][0];

    return view('metrix.compensation_edit', compact('setting'));
}

public function expiationUpdate(Request $request, $id)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'offense_type.*.parameter' => 'required|string',
        'offense_type.*.value' => 'required|numeric',
        'kaffarah_item.*.name' => 'required|string',
        'kaffarah_item.*.price' => 'required|numeric',
        'rate' => 'required|numeric',
    ]);

    // Retrieve the existing Kaffarah setting based on the provided $id
    $existingSetting = $this->collection->findOne(
        ['setting_category' => 'kaffarah', 'kaffarah.kaffarah_settings._id' => new ObjectId($id)]
    );

    // Find the specific Kaffarah setting we are updating, based on the _id
    $kaffarahSetting = collect($existingSetting['kaffarah']['kaffarah_settings'])
        ->firstWhere('_id', new ObjectId($id));

    // Prepare updated setting data with preserved code
    $updatedSetting = [
        'title' => $validated['title'],
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
    ];

    // Preserve the code from the existing setting and the _id
    $updatedSettingWithCode = array_merge([
        '_id' => new ObjectId($id),
        'code' => $kaffarahSetting['code'], // Preserve the existing code
        'is_active' => $kaffarahSetting['is_active'],
    ], $updatedSetting);

    // Perform the update operation
    $this->collection->updateOne(
        [
            'setting_category' => 'kaffarah',
            'kaffarah.kaffarah_settings._id' => new ObjectId($id),
        ],
        [
            '$set' => [
                'kaffarah.kaffarah_settings.$' => $updatedSettingWithCode,
            ],
        ]
    );

    return redirect()->route('compensation.list')->with('success', 'Kaffarah setting updated successfully!');
}

public function expiationUpdateAndMarkAsActive(Request $request, $id)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'offense_type.*.parameter' => 'required|string',
        'offense_type.*.value' => 'required|numeric',
        'kaffarah_item.*.name' => 'required|string',
        'kaffarah_item.*.price' => 'required|numeric',
        'rate' => 'required|numeric',
    ]);

    // Retrieve the existing Kaffarah setting based on the provided $id
    $existingSetting = $this->collection->findOne(
        ['setting_category' => 'kaffarah', 'kaffarah.kaffarah_settings._id' => new ObjectId($id)]
    );

    // Find the specific Kaffarah setting we are updating, based on the _id
    $kaffarahSetting = collect($existingSetting['kaffarah']['kaffarah_settings'])
        ->firstWhere('_id', new ObjectId($id));

    // Prepare updated setting data with preserved code
    $updatedSetting = [
        'title' => $validated['title'],
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
    ];

    // Preserve the code from the existing setting and the _id
    $updatedSettingWithCode = array_merge([
        '_id' => new ObjectId($id),
        'code' => $kaffarahSetting['code'], // Preserve the existing code
        'is_active' => true, // Mark as active immediately
    ], $updatedSetting);

    // Perform the update operation
    $this->collection->updateOne(
        [
            'setting_category' => 'kaffarah',
            'kaffarah.kaffarah_settings._id' => new ObjectId($id),
        ],
        [
            '$set' => [
                'kaffarah.kaffarah_settings.$' => $updatedSettingWithCode,
            ],
        ]
    );

    // Mark the updated setting as active by setting 'is_active' to true for this setting
    $settings = $this->collection->findOne(['setting_category' => 'kaffarah']);
    $kaffarahSettings = $settings['kaffarah']['kaffarah_settings'] ?? [];

    foreach ($kaffarahSettings as $index => &$setting) {
        // Deactivate all settings
        $setting['is_active'] = false;

        // Activate the updated setting
        if ((string) $setting['_id'] === $id) {
            $setting['is_active'] = true;
            $settings['kaffarah']['active_setting'] = [
                'setting_id' => $setting['_id'],
                'setting_code' => $setting['code'],
            ];
        }
    }

    // Update the active setting in the database
    $this->collection->updateOne(
        ['setting_category' => 'kaffarah'],
        [
            '$set' => [
                'kaffarah.kaffarah_settings' => $kaffarahSettings,
                'kaffarah.active_setting' => $settings['kaffarah']['active_setting'],
            ],
        ]
    );

    return redirect()->route('compensation.list')->with('success', 'Kaffarah setting updated and marked as active.');
}



}
