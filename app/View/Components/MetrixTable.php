<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MetrixTable extends Component
{
    public $headers;
    public $rows;

    public function __construct($headers = [], $rows = [])
    {
        $this->headers = $headers;
        $this->rows = $rows;
    }

    public function render()
    {
        return view('components.metrix-table');
    }
}
