<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Table extends Component
{
    public $headers;
    public $rows;
    public $statuses;
    public $columns;
    public $route;

    /**
     * Create a new component instance.
     *
     * @param  array  $headers
     * @param  array  $rows
     * @param  array|null  $statuses
     * @param  string|null $route
     * @return void
     */
    public function __construct($headers, $rows, $columns, $statuses = null, $route = null)
    {
        $this->headers = $headers;
        $this->rows = $rows;
        $this->statuses = $statuses;
        $this->columns = $columns;
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('components.table');
    }
}
