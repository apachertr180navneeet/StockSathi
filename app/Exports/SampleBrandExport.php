<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SampleBrandExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            ['Sample Brand A'],
            ['Sample Brand B'],
            ['Sample Brand C'],
        ];
    }

    public function headings(): array
    {
        return ['name'];
    }
}
