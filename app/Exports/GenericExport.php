<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class GenericExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $headings;

    /**
     * Constructor to accept data and headings
     */
    public function __construct(array $headings, array $data)
    {
        $this->headings = $headings;
        $this->data = $data;
    }

    /**
     * Return a collection of data rows
     */
    public function collection(): Collection
    {
        return collect($this->data);
    }

    /**
     * Return an array of column headers
     */
    public function headings(): array
    {
        return $this->headings;
    }
}
