<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\Client as MongoClient;
use App\Reports\DashboardReport;


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

    public function dashboard(Request $request)
    {        
        $report = new DashboardReport();

        $report->run();

        return view('welcome', compact('report'));
    }

    public function index(Request $request)
    {
        // Connect to MongoDB
        $client = new MongoClient('mongodb+srv://development:XT7GquBxdsk5wMru@ebossdevelopment.ekek02t.mongodb.net/?retryWrites=true&w=majority');
        $collection = $client->super_dashboard->dashboard;
    
        // Fetch all documents from the dashboard collection
        $dashboardData = $collection->find(); // Retrieves all documents
    
        // Initialize arrays to store cards, pie charts, and tables data
        $data = [];
        $pieCharts = [];
        $tables = [];
    
        // Loop through each document to extract cards, pie charts, and tables
        foreach ($dashboardData as $document) {
            // Extract cards
            if (isset($document['cards'])) {
                foreach ($document['cards'] as $card) {
                    $data[$card['name']] = [
                        $card['title'],
                        $card['value']
                    ];
                }
            }
    
            // Extract pie charts
            if (isset($document['pie_charts'])) {
                foreach ($document['pie_charts'] as $chart) {
                    $pieCharts[$chart['name']] = $chart['data'];
                }
            }
    
            // Extract tables
            if (isset($document['tables'])) {
                foreach ($document['tables'] as $table) {
                    // Add table name and relevant data
                    $tables[$table['name']] = [
                        'categories' => $table['categories'],
                        'districts' => $table['districts'],
                        'totals' => $table['totals']
                    ];
                }
            }
        }
    
        // Return the view with cards, pie charts, and tables data
        return view('base.index', compact('data', 'pieCharts', 'tables'));
    }
    
    
    
}
