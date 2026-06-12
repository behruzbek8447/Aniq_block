<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Subject;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $query = Exam::with(['classroom', 'subject'])->latest();

        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('classroom', fn($sq) => $sq->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('subject', fn($sq) => $sq->where('name', 'like', "%{$search}%"));
            });
        }

        $exams = $query->paginate(15);

        return view('exams.index', compact('exams'));
    }

    public function create()
    {
        $classrooms = Classroom::all();
        $subjects = Subject::all();

        return view('exams.form', compact('classrooms', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'classroom_id' => ['required', 'exists:classrooms,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'name' => ['required', 'string', 'max:255'],
            'exam_date' => ['required', 'date'],
            'max_score' => ['required', 'integer', 'min:1', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        Exam::create($validated);

        return redirect('/exams')->with('success', "Imtihon qo'shildi.");
    }

    public function edit(Exam $exam)
    {
        $classrooms = Classroom::all();
        $subjects = Subject::all();

        return view('exams.form', compact('exam', 'classrooms', 'subjects'));
    }

    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'classroom_id' => ['required', 'exists:classrooms,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'name' => ['required', 'string', 'max:255'],
            'exam_date' => ['required', 'date'],
            'max_score' => ['required', 'integer', 'min:1', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $exam->update($validated);

        return redirect('/exams')->with('success', "Imtihon yangilandi.");
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();

        return back()->with('success', "Imtihon o'chirildi.");
    }

    public function results(Exam $exam)
    {
        $exam->load(['classroom', 'subject', 'results.enrollment.student']);

        $enrollments = Enrollment::with('student')
            ->where('classroom_id', $exam->classroom_id)
            ->get();

        return view('exams.results', compact('exam', 'enrollments'));
    }

    public function storeResults(Request $request, Exam $exam)
    {
        $request->validate([
            'scores' => ['required', 'array'],
            'scores.*' => ['nullable', 'integer', 'min:0', 'max:' . $exam->max_score],
        ]);

        foreach ($request->scores as $enrollmentId => $score) {
            if ($score === null || $score === '') continue;

            ExamResult::updateOrCreate(
                ['exam_id' => $exam->id, 'enrollment_id' => $enrollmentId],
                ['score' => $score]
            );
        }

        return redirect('/exams/' . $exam->id . '/results')->with('success', "Natijalar saqlandi.");
    }
}
