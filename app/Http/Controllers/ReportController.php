<?php

namespace App\Http\Controllers;

use MongoDB\Client as MongoClient;
use Illuminate\Http\Request;
use App\Reports\GenderDashboardReport;

class ReportController extends Controller
{
    public function showReport(Request $request)
    {
        // MongoDB connection and fetching dashboard names
        $client = new MongoClient('mongodb+srv://development:XT7GquBxdsk5wMru@ebossdevelopment.ekek02t.mongodb.net/?retryWrites=true&w=majority');
        $collection = $client->super_dashboard->dashboards;

        // Retrieve all dashboards
        $dashboards = $collection->find([], ['projection' => ['dashboard_name' => 1, '_id' => 0]]);
        
        // Convert MongoDB cursor to an array
        $dashboardNames = iterator_to_array($dashboards);

        // Get the dashboard name from the request or default to 'Admin Dashboard'
        $dashboardName = $request->get('dashboard_name', 'Admin Dashboard');
        
        // Create an instance of the report class with the selected dashboard name
        $report = new GenderDashboardReport([
            'dashboardName' => $dashboardName,
        ]);

        // Run the report to process data
        $report->run();

        // Return the view with the report data and dashboard names
        return view('base.dashboard', compact('report', 'dashboardNames'));
    }
}
