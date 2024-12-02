<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\Client as MongoClient;

class DashboardController extends Controller
{
    // Function to display the dashboard creation form
    public function create()
    {
        return view('base.create');
    }

    // Function to store the new dashboard data in MongoDB
    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'dashboard_name' => 'required|string|max:255',
            'elements' => 'required|array',
            'elements.*.element_name' => 'required|string|max:255',
            'elements.*.chart_type' => 'required|string|in:pie,bar',
            'elements.*.width' => 'required|string|in:half,full',
            'elements.*.prms' => 'required|array',
        ]);

        // Connect to MongoDB
        $client = new MongoClient('mongodb+srv://development:XT7GquBxdsk5wMru@ebossdevelopment.ekek02t.mongodb.net/?retryWrites=true&w=majority');
        $collection = $client->super_dashboard->dashboards;

        // Prepare the dashboard data
        $dashboardData = [
            'dashboard_name' => $request->dashboard_name,
            'elements' => $request->elements,
            'system_info' => [
                'created_at' => now(),
                'created_by' => 'Admin',
                'updated_at' => null,
                'updated_by' => null,
                'deleted_at' => null,
                'deleted_by' => null,
            ]
        ];

        // Insert the new dashboard into MongoDB
        $result = $collection->insertOne($dashboardData);

        // Redirect or return response
        return redirect()->route('dashboard.create')->with('success', 'Dashboard created successfully!');
    }
}
