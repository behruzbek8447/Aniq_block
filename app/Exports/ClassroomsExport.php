<?php

namespace App\Exports;

use App\Models\Classroom;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClassroomsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Classroom::withCount('enrollments')->latest()->get(['name', 'room_number', 'created_at']);
    }

    public function headings(): array
    {
        return ["Guruh nomi", "Xona raqami", "O'quvchilar soni", "Qo'shilgan sana"];
    }
}
