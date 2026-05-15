<?php

namespace App\Imports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class SuppliersImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public $imported = 0;

    public function model(array $row)
    {
        $name = trim($row['name'] ?? '');

        if (empty($name)) {
            return null;
        }

        $phone = trim($row['phone'] ?? '');

        if (Supplier::where('name', $name)->exists()) {
            return null;
        }

        if (!empty($phone) && Supplier::where('phone', $phone)->exists()) {
            return null;
        }

        $this->imported++;

        return new Supplier([
            'name'    => $name,
            'email'   => trim($row['email'] ?? ''),
            'phone'   => trim($row['phone'] ?? ''),
            'address' => trim($row['address'] ?? ''),
        ]);
    }

    public function rules(): array
    {
        return [
            'name'  => 'required|string|max:100',
            'email' => 'nullable|email|unique:suppliers,email',
            'phone' => 'nullable|unique:suppliers,phone',
        ];
    }
}
