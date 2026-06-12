<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = ['student_id', 'classroom_id', 'enrolled_at'];

    protected function casts(): array
    {
        return [
            'enrolled_at' => 'datetime',
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class)->withTrashed();
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function attendanceRecords()
    {
        return $this->hasMany(AttendanceRecord::class);
    }
}
