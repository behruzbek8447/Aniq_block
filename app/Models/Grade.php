<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['enrollment_id', 'subject_id', 'grade', 'graded_at', 'notes'];

    protected function casts(): array
    {
        return [
            'graded_at' => 'date',
        ];
    }

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function student()
    {
        return $this->hasOneThrough(Student::class, Enrollment::class, 'id', 'id', 'enrollment_id', 'student_id');
    }
}
