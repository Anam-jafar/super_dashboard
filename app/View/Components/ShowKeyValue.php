<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ShowKeyValue extends Component
{
    public $key;
    public $value = null;


    public function __construct($key, $value = null)
    {
        $this->key = $key;
        $this->value = $value;
    }
    
    public function render(): View|Closure|string
    {
        return view('components.show-key-value');
    }
}
