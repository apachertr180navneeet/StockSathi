<?php

namespace App\Imports;

use App\Models\WareHouse;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class WarehousesImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public $imported = 0;

    public function model(array $row)
    {
        $name  = trim($row['name'] ?? '');
        $email = trim($row['email'] ?? '');

        if (empty($name) || empty($email)) {
            return null;
        }

        if (WareHouse::where('email', $email)->exists()) {
            return null;
        }

        $this->imported++;

        return new WareHouse([
            'name'  => $name,
            'email' => $email,
            'phone' => $row['phone'] ?? null,
            'city'  => $row['city'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|max:20',
        ];
    }
}
