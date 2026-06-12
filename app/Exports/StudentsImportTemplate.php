<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsImportTemplate implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            ['Ali', 'Valiyev', '+998901234567', 'Toshkent sh.'],
        ];
    }

    public function headings(): array
    {
        return ["Ism", "Familiya", "Telefon", "Manzil"];
    }
}
