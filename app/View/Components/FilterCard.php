<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FilterCard extends Component
{
    public $filters;
    public $route;
    public $buttonLabel;
    public $buttonRoute; // New property
    public $download;

    /**
     * Create a new component instance.
     */
    public function __construct($filters, $route, $buttonLabel = 'Apply Filters', $buttonRoute = null, $download = false)
    {
        $this->download = $download;
        $this->filters = $filters;
        $this->route = $route;
        $this->buttonLabel = $buttonLabel;
        $this->buttonRoute = $buttonRoute;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.filter-card');
    }
}
