<?php

namespace App\Http\Controllers;

use App\Reports\DummyReport;
use App\Reports\GenderDashboardReport;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function showReport()
    {
        // Create an instance of the DummyReport class
        $report = new GenderDashboardReport();

        // Run the report to process data
        $report->run();
        
        // Return a view with the report data
        return view('base.dashboard', compact('report'));
    }
    
}
