<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['fio', 'first_name', 'last_name', 'phone', 'address', 'created_by'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function profile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'enrollments');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function todayAttendance()
    {
        return $this->hasOne(Attendance::class)->whereDate('date', today());
    }

    public function attendanceRecords()
    {
        return $this->hasManyThrough(AttendanceRecord::class, Enrollment::class);
    }
}
