<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['classroom_id', 'day_of_week', 'start_time', 'end_time', 'subject_name', 'teacher_name'];

    protected function casts(): array
    {
        return [
            'start_time' => 'string',
            'end_time' => 'string',
        ];
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
