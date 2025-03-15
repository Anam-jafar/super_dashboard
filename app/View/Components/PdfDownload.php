<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Storage;

class PdfDownload extends Component
{
    public $title;
    public $pdfFile;

    public function __construct($title, $pdfFile = null)
    {
        $this->title = $title;
        $this->pdfFile = $pdfFile;
    }

    public function render()
    {
        return view('components.pdf-download');
    }
}
