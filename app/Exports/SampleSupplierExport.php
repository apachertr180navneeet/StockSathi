<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SampleSupplierExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            ['Sample Supplier A', 'supplierA@example.com', '1234567890', '123 Street, City'],
            ['Sample Supplier B', 'supplierB@example.com', '0987654321', '456 Avenue, Town'],
        ];
    }

    public function headings(): array
    {
        return ['name', 'email', 'phone', 'address'];
    }
}
