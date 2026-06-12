<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    protected $fillable = ['student_id', 'birth_date', 'address', 'parent_name'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
