<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = ['name', 'room_number'];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()
    {
        return $this->hasManyThrough(Student::class, Enrollment::class, 'classroom_id', 'id', 'id', 'student_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
