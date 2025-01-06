<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Pagination\LengthAwarePaginator;

class Pagination extends Component
{
    public $items;  // General items being paginated
    public $label;  // Optional label for the type of items

    /**
     * Create a new component instance.
     *
     * @param  LengthAwarePaginator  $items
     * @param  string  $label
     * @return void
     */
    public function __construct(LengthAwarePaginator $items, $label = 'items')
    {
        $this->items = $items;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('components.pagination');
    }
}
