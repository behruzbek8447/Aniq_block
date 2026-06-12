<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $query = Grade::with(['enrollment.student', 'enrollment.classroom', 'subject'])->latest();

        if ($search = $request->get('q')) {
            $query->whereHas('enrollment.student', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        if ($subjectId = $request->get('subject_id')) {
            $query->where('subject_id', $subjectId);
        }

        $grades = $query->paginate(20);
        $subjects = Subject::all();

        return view('grades.index', compact('grades', 'subjects'));
    }

    public function create()
    {
        $enrollments = Enrollment::with(['student', 'classroom'])->latest()->get();
        $subjects = Subject::all();

        return view('grades.form', compact('enrollments', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'enrollment_id' => ['required', 'exists:enrollments,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'grade' => ['required', 'integer', 'between:1,5'],
            'graded_at' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        Grade::create($validated);

        return redirect('/grades')->with('success', "Baho qo'shildi.");
    }

    public function edit(Grade $grade)
    {
        $enrollments = Enrollment::with(['student', 'classroom'])->latest()->get();
        $subjects = Subject::all();

        return view('grades.form', compact('grade', 'enrollments', 'subjects'));
    }

    public function update(Request $request, Grade $grade)
    {
        $validated = $request->validate([
            'enrollment_id' => ['required', 'exists:enrollments,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'grade' => ['required', 'integer', 'between:1,5'],
            'graded_at' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $grade->update($validated);

        return redirect('/grades')->with('success', "Baho yangilandi.");
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();

        return back()->with('success', "Baho o'chirildi.");
    }
}
