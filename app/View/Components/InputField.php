<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputField extends Component
{
    public $level;
    public $id;
    public $type;
    public $placeholder;
    public $name;
    public $value;
    public $valueList; 
    public $readonly;
    public $disabled;
    public $rightAlign;
    public $required;

    public function __construct(
        $level,
        $id,
        $type,
        $placeholder = '',
        $name,
        $value = null, 
        $valueList = [],
        $readonly = false,
        $disabled = false, 
        $rightAlign = false,
        $required = false,
    ) {
        $this->level = $level;
        $this->id = $id;
        $this->type = $type;
        $this->placeholder = $placeholder;
        $this->name = $name;
        $this->value = $value;
        $this->valueList = $valueList;
        $this->readonly = $readonly;
        $this->disabled = $disabled;
        $this->rightAlign = $rightAlign;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input-field');
    }
}
