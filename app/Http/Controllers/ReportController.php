<?php

namespace App\Http\Controllers;

use App\Reports\DummyReport;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function showReport(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
    
        $report = new DummyReport(compact('startDate', 'endDate'));
    
        $report->run();
    
        return view('base.dashboard', compact('report'));
    }
    
}
