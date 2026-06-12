<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    protected $fillable = ['exam_id', 'enrollment_id', 'score'];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function student()
    {
        return $this->hasOneThrough(Student::class, Enrollment::class, 'id', 'id', 'enrollment_id', 'student_id');
    }
}
