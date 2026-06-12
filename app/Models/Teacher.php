<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['first_name', 'last_name', 'phone', 'subject_name'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function certificates()
    {
        return $this->hasMany(TeacherCertificate::class);
    }
}
