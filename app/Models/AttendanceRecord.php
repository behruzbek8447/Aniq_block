<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    protected $fillable = ['enrollment_id', 'attendance_date', 'status'];

    protected function casts(): array
    {
        return [
            'attendance_date' => 'date',
        ];
    }

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}
