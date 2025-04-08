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
            ],
        ],
        'fidyah' => [
            'settings_key' => 'fidyah_settings',
            'route' => 'metrix.settings.list',
            'view_prefix' => 'settings',
            'validation_rules' => [
                'title' => 'required|string|max:255',
                'individual_status.*.parameter' => 'required|string',
                'individual_status.*.code' => 'string',
                'individual_status.*.categories.*.parameter' => 'required|string',
                'individual_status.*.categories.*.code' => 'string',
                'fidyah_item.*.name' => 'required|string',
                'fidyah_item.*.price' => 'required|numeric',
                'rate' => 'required|numeric',
            ],
        ],
    ];

    public function __construct()
    {
        $this->client = new MongoClient('mongodb+srv://development:XT7GquBxdsk5wMru@ebossdevelopment.ekek02t.mongodb.net/?retryWrites=true&w=majority');
        $this->collection = $this->client->mais->payment_metrix;
    }

    private function getSettings(string $type)
    {
        if (!isset(self::CATEGORIES[$type])) {
            throw new \InvalidArgumentException("Invalid category: {$type}");
        }

        $settings = $this->collection->findOne(['setting_category' => $type]);
        $settingsKey = self::CATEGORIES[$type]['settings_key'];

        $payment_metrix = isset($settings[$type][$settingsKey])
            ? $settings[$type][$settingsKey]
            : [];

        $activeSetting = $settings[$type]['active_setting'] ?? null;

        return [$payment_metrix, $activeSetting];
    }

    private function generateCode(string $type): string
    {
        $settings = $this->collection->findOne(['setting_category' => $type]);

        $settingsKey = "{$type}_settings";
        $categorySettings = isset($settings[$type][$settingsKey])
            ? iterator_to_array($settings[$type][$settingsKey])
            : [];

        $count = count($categorySettings);
        $newCode = str_pad($count + 1, 4, '0', STR_PAD_LEFT);

        return $newCode;
    }

    private function prepareData(string $type, array $validated, ?string $id = null, $currentSetting = null, bool $markAsActive = false): array
    {
        $currentSetting = $currentSetting instanceof \MongoDB\Model\BSONDocument
            ? $currentSetting->getArrayCopy()
            : (array) $currentSetting;

        $isUpdate = !is_null($id);

        $code = $isUpdate
        ? ($currentSetting['code'] ?? $this->generateCode($type))
        : $this->generateCode($type);

        $preparedData = [
            '_id' => $isUpdate ? new ObjectId($id) : new ObjectId(),
            'title' => $validated['title'],
            'code' => $code,
            'is_active' => $markAsActive ? true : ($currentSetting['is_active'] ?? false),
            'rate' => $validated['rate'],
        ];

        // Add category-specific fields
        if ($type === 'kaffarah') {
            $preparedData['offense_type'] = $validated['offense_type'];
            $preparedData['kaffarah_item'] = array_map(function ($item) use ($validated) {
                $item['rate_value'] = ceil($item['price'] * (float) $validated['rate']);

                return $item;
            }, $validated['kaffarah_item']);
        } elseif ($type === 'fidyah') {
            $preparedData['individual_status'] = $validated['individual_status'];
            $preparedData['fidyah_item'] = array_map(function ($item) use ($validated) {
                $item['rate_value'] = ceil($item['price'] * (float) $validated['rate']);

                return $item;
            }, $validated['fidyah_item']);
        }

        return $preparedData;
    }

    public function index(Request $request)
    {
        $type = $request->route('type');
        [$payment_metrix, $activeSetting] = $this->getSettings($type);

        $payment_metrix = collect($payment_metrix)
            ->sortByDesc('is_active')
            ->values();

        $perPage = 25;
        $currentPage = $request->input('page', 1);
        $payment_metrix = new \Illuminate\Pagination\LengthAwarePaginator(
            $payment_metrix->forPage($currentPage, $perPage),
            $payment_metrix->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $viewPrefix = self::CATEGORIES[$type]['view_prefix'];

        return view("metrix.{$viewPrefix}_list", compact('payment_metrix', 'activeSetting'));
    }

    public function create(Request $request)
    {
        $type = $request->route('type');
        $viewPrefix = self::CATEGORIES[$type]['view_prefix'];

        return view("metrix.{$viewPrefix}_create");
    }

    public function store(Request $request)
    {
        $type = $request->route('type');
        $validated = $request->validate(self::CATEGORIES[$type]['validation_rules']);
        $settingsKey = self::CATEGORIES[$type]['settings_key'];

        $newSetting = $this->prepareData($type, $validated);

        $this->collection->updateOne(
            ['setting_category' => $type],
            ['$push' => [$type.'.'.$settingsKey => $newSetting]],
            ['upsert' => true]
        );
        $this->logActivity('Add '.$type, $type.' store  attempt successful');

        return redirect()->route(self::CATEGORIES[$type]['route'], ['type' => $type])
            ->with('success', ucfirst($type).' setting added successfully!');
    }

    public function edit(Request $request, string $type, string $id)
    {
        // $category = $request->route('category');
        $setting = $this->collection->findOne(
            [
                'setting_category' => $type,
                $type.'.'.self::CATEGORIES[$type]['settings_key'].'._id' => new ObjectId($id),
            ],
            ['projection' => [$type.'.'.self::CATEGORIES[$type]['settings_key'].'.$' => 1]]
        );

        if (!$setting || empty($setting[$type][self::CATEGORIES[$type]['settings_key']])) {
            return redirect()->route(self::CATEGORIES[$type]['route'])
                ->with('error', ucfirst($type).' setting not found.');
        }

        $setting = $setting[$type][self::CATEGORIES[$type]['settings_key']][0];
        $viewPrefix = self::CATEGORIES[$type]['view_prefix'];

        return view("metrix.{$viewPrefix}_edit", compact('setting'));
    }

    public function update(Request $request, string $type, string $id)
    {
        $markAsActive = $request->route('markAsActive', false);
        $validated = $request->validate(self::CATEGORIES[$type]['validation_rules']);
        $settingsKey = self::CATEGORIES[$type]['settings_key'];

        $existingSetting = $this->collection->findOne([
            'setting_category' => $type,
            $type.'.'.$settingsKey.'._id' => new ObjectId($id),
        ]);

        $currentSetting = collect($existingSetting[$type][$settingsKey])
            ->firstWhere('_id', new ObjectId($id));

        $updatedSetting = $this->prepareData($type, $validated, $id, $currentSetting, $markAsActive);

        $this->collection->updateOne(
            [
                'setting_category' => $type,
                $type.'.'.self::CATEGORIES[$type]['settings_key'].'._id' => new ObjectId($id),
            ],
            ['$set' => [$type.'.'.$settingsKey.'.$' => $updatedSetting]]
        );

        if ($markAsActive) {
            $this->markAsActive($request, $type, $id);
            $this->logActivity('Update '.$type, $type.' update and mark as active  attempt successful.Code : '.$updatedSetting['code']);
        }
        $this->logActivity('Update '.$type, $type.' update attempt successful. Code : '.$updatedSetting['code']);

        return redirect()->route(self::CATEGORIES[$type]['route'], ['type' => $type])
            ->with('success', ucfirst($type).' setting '.($markAsActive ? 'updated and marked as active' : 'updated').' successfully!');
    }

    public function markAsActive(Request $request, string $type, string $id)
    {
        $settings = $this->collection->findOne(['setting_category' => $type]);
        if (!$settings) {
            return back()->with('error', ucfirst($type).' settings not found.');
        }

        $settingsKey = self::CATEGORIES[$type]['settings_key'];
        $categorySettings = $settings[$type][$settingsKey] ?? [];

        $active_code = null;
        foreach ($categorySettings as &$setting) {
            $setting['is_active'] = (string) $setting['_id'] === $id;
            if ($setting['is_active']) {
                $settings[$type]['active_setting'] = [
                    'setting_id' => $setting['_id'],
                    'setting_code' => $setting['code'],
                ];
                $active_code = $setting['code'];
            }
        }

        $this->collection->updateOne(
            ['setting_category' => $type],
            [
                '$set' => [
                    $type.'.'.$settingsKey => $categorySettings,
                    $type.'.active_setting' => $settings[$type]['active_setting'],
                ],
            ]
        );
        $this->logActivity($type.' actived', $type.' activation attempt successful. Code : '.$active_code);

        return back()->with('success', ucfirst($type).' setting marked as active.');
    }
}
