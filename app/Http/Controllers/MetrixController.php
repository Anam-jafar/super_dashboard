<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;
use MongoDB\Client as MongoClient;

class MetrixController extends Controller
{
    private $client;
    private $collection;
    private const CATEGORIES = [
        'kaffarah' => [
            'settings_key' => 'kaffarah_settings',
            'route' => 'metrix.compensation.list',
            'view_prefix' => 'compensation',
            'validation_rules' => [
                'title' => 'required|string|max:255',
                'offense_type.*.parameter' => 'required|string',
                'offense_type.*.value' => 'required|numeric',
                'kaffarah_item.*.name' => 'required|string',
                'kaffarah_item.*.price' => 'required|numeric',
                'rate' => 'required|numeric',
            ]
        ],
        'fidyah' => [
            'settings_key' => 'fidyah_settings',
            'route' => 'metrix.settings.list',
            'view_prefix' => 'settings',
            'validation_rules' => [
                'title' => 'required|string|max:255',
                'individual_status.*.parameter' => 'required|string',
                'individual_status.*.categories.*.parameter' => 'required|string',
                'fidyah_item.*.name' => 'required|string',
                'fidyah_item.*.price' => 'required|numeric',
                'rate' => 'required|numeric',
            ]
        ]
    ];

    public function __construct()
    {
        $this->client = new MongoClient('mongodb+srv://development:XT7GquBxdsk5wMru@ebossdevelopment.ekek02t.mongodb.net/?retryWrites=true&w=majority');
        $this->collection = $this->client->mais->payment_metrix;
    }


    private function getSettings(string $category)
    {
        if (!isset(self::CATEGORIES[$category])) {
            throw new \InvalidArgumentException("Invalid category: {$category}");
        }

        $settings = $this->collection->findOne(['setting_category' => $category]);
        $settingsKey = self::CATEGORIES[$category]['settings_key'];
        
        $payment_metrix = isset($settings[$category][$settingsKey])
            ? $settings[$category][$settingsKey]
            : [];
        
        $activeSetting = $settings[$category]['active_setting'] ?? null;
        
        return [$payment_metrix, $activeSetting];
    }

    public function index(string $category)
    {
        [$payment_metrix, $activeSetting] = $this->getSettings($category);
        $payment_metrix = collect($payment_metrix)->sortByDesc('is_active');
        $viewPrefix = self::CATEGORIES[$category]['view_prefix'];
        
        return view("metrix.{$viewPrefix}_list", compact('payment_metrix', 'activeSetting'));
    }

    public function create(string $category)
    {
        $viewPrefix = self::CATEGORIES[$category]['view_prefix'];
        return view("metrix.{$viewPrefix}_create");
    }

    public function store(Request $request, string $category)
    {
        $validated = $request->validate(self::CATEGORIES[$category]['validation_rules']);
        $settingsKey = self::CATEGORIES[$category]['settings_key'];
        
        $newSetting = $this->prepareSettingData($category, $validated);
        
        $this->collection->updateOne(
            ['setting_category' => $category],
            ['$push' => [$category . '.' . $settingsKey => $newSetting]],
            ['upsert' => true]
        );

        return redirect()->route(self::CATEGORIES[$category]['route'])
            ->with('success', ucfirst($category) . ' setting added successfully!');
    }

    public function edit(string $category, string $id)
    {
        $setting = $this->collection->findOne(
            [
                'setting_category' => $category,
                $category . '.' . self::CATEGORIES[$category]['settings_key'] . '._id' => new ObjectId($id)
            ],
            ['projection' => [$category . '.' . self::CATEGORIES[$category]['settings_key'] . '.$' => 1]]
        );

        if (!$setting || empty($setting[$category][self::CATEGORIES[$category]['settings_key']])) {
            return redirect()->route(self::CATEGORIES[$category]['route'])
                ->with('error', ucfirst($category) . ' setting not found.');
        }

        $setting = $setting[$category][self::CATEGORIES[$category]['settings_key']][0];
        $viewPrefix = self::CATEGORIES[$category]['view_prefix'];

        return view("metrix.{$viewPrefix}_edit", compact('setting'));
    }

    public function update(Request $request, string $category, string $id)
    {
        $markAsActive = $request->route('markAsActive', false);
        $validated = $request->validate(self::CATEGORIES[$category]['validation_rules']);
        $settingsKey = self::CATEGORIES[$category]['settings_key'];

        $existingSetting = $this->collection->findOne([
            'setting_category' => $category,
            $category . '.' . $settingsKey . '._id' => new ObjectId($id)
        ]);

        $currentSetting = collect($existingSetting[$category][$settingsKey])
            ->firstWhere('_id', new ObjectId($id));

        $updatedSetting = $this->prepareUpdateData($category, $validated, $id, $currentSetting, $markAsActive);

        $this->collection->updateOne(
            [
                'setting_category' => $category,
                $category . '.' . $settingsKey . '._id' => new ObjectId($id)
            ],
            ['$set' => [$category . '.' . $settingsKey . '.$' => $updatedSetting]]
        );

        if ($markAsActive) {
            $this->markAsActive($request, $category, $id);
        }

        return redirect()->route(self::CATEGORIES[$category]['route'])
            ->with('success', ucfirst($category) . ' setting ' . ($markAsActive ? 'updated and marked as active' : 'updated') . ' successfully!');
    }

    public function markAsActive(Request $request, string $category, string $id)
    {
        $settings = $this->collection->findOne(['setting_category' => $category]);
        if (!$settings) {
            return back()->with('error', ucfirst($category) . ' settings not found.');
        }

        $settingsKey = self::CATEGORIES[$category]['settings_key'];
        $categorySettings = $settings[$category][$settingsKey] ?? [];

        foreach ($categorySettings as &$setting) {
            $setting['is_active'] = (string)$setting['_id'] === $id;
            if ($setting['is_active']) {
                $settings[$category]['active_setting'] = [
                    'setting_id' => $setting['_id'],
                    'setting_code' => $setting['code'],
                ];
            }
        }

        $this->collection->updateOne(
            ['setting_category' => $category],
            [
                '$set' => [
                    $category . '.' . $settingsKey => $categorySettings,
                    $category . '.active_setting' => $settings[$category]['active_setting'],
                ],
            ]
        );

        return back()->with('success', ucfirst($category) . ' setting marked as active.');
    }
}