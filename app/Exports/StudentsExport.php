<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Student::latest()->get(['first_name', 'last_name', 'phone', 'address', 'created_at']);
    }

    public function headings(): array
    {
        return ["Ism", "Familiya", "Telefon", "Manzil", "Qo'shilgan sana"];
    }
}
