<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Enrollment::with(['student', 'classroom'])->latest();

        if ($search = $request->get('q')) {
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('fio', 'like', "%{$search}%");
            })->orWhereHas('classroom', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $enrollments = $query->paginate(15);

        return view('enrollments.index', compact('enrollments'));
    }

    public function create()
    {
        $students = Student::all();
        $classrooms = Classroom::all();

        return view('enrollments.form', compact('students', 'classrooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'classroom_id' => ['required', 'exists:classrooms,id'],
        ]);

        $exists = Enrollment::where('student_id', $validated['student_id'])
            ->where('classroom_id', $validated['classroom_id'])
            ->exists();

        if ($exists) {
            return back()->with('error', "Bu o'quvchi allaqachon shu guruhga biriktirilgan.");
        }

        Enrollment::create($validated);

        return redirect('/enrollments')->with('success', "O'quvchi guruhga biriktirildi.");
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return back()->with('success', "Biriktirish o'chirildi.");
    }
}
