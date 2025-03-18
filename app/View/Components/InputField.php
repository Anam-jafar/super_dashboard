<?php

namespace App\View\Components;

use Illuminate\View\View;
use Illuminate\View\Component;

class InputField extends Component
{
    public string $level;
    public string $id;
    public string $type;
    public string $placeholder;
    public string $name;
    public mixed $value;
    public array $valueList;
    public bool $readonly;
    public bool $disabled;
    public bool $rightAlign;
    public bool $required;
    public string $spanText;

    public function __construct(
        string $level,
        string $id,
        string $type,
        string $name,
        string $placeholder = '',
        mixed $value = null, 
        array $valueList = [],
        bool $readonly = false,
        bool $disabled = false, 
        bool $rightAlign = false,
        bool $required = false,
        string $spanText = ''
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
        $this->spanText = $spanText;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|string
    {
        return view('components.input-field');
    }
}
