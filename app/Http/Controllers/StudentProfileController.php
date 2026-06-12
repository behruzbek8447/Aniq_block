<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentProfile;
use Illuminate\Http\Request;

class StudentProfileController extends Controller
{
    public function edit(Student $student)
    {
        $profile = $student->profile ?? new StudentProfile();

        return view('student_profiles.form', compact('student', 'profile'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'birth_date' => ['nullable', 'date'],
            'address' => ['nullable', 'string', 'max:500'],
            'parent_name' => ['nullable', 'string', 'max:255'],
        ]);

        $student->profile()->updateOrCreate(
            ['student_id' => $student->id],
            $validated
        );

        return redirect('/students')->with('success', "Profil yangilandi.");
    }
}
