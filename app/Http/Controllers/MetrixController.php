<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MetrixController extends Controller
{
    public function compensationList()
    {
        return view('metrix.compensation_list');

    }
}
