<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MetrixModal extends Component
{
    public $id;
    public $title;
    public $content;
    public $footer;

    public function __construct($id, $title, $content, $footer = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->footer = $footer;
    }

    public function render()
    {
        return view('components.metrix-modal');
    }
}

