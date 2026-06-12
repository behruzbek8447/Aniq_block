<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherCertificate extends Model
{
    protected $fillable = ['teacher_id', 'name', 'issued_by', 'issued_date'];

    protected function casts(): array
    {
        return [
            'issued_date' => 'date',
        ];
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
