<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ReporteExport implements FromCollection
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }
}
