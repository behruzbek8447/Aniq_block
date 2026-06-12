<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class StudentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $name = $row['f_i_sh'] ?? $row['ism'] ?? '';
        if (empty(trim($name))) {
            return null;
        }

        $phone = $row['telefon'] ?? $row['phone'] ?? '';

        $existing = Student::where('phone', $phone)->first();
        if ($existing) {
            return null;
        }

        $parts = explode(' ', trim($name), 2);
        $firstName = $parts[0];
        $lastName = $parts[1] ?? null;

        return new Student([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'fio' => trim($name),
            'phone' => trim($phone),
            'address' => trim($row['manzil'] ?? $row['address'] ?? ''),
            'created_by' => Auth::id(),
        ]);
    }
}
