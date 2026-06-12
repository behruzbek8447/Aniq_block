<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\TeacherCertificate;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::withCount('certificates')->latest();

        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('subject_name', 'like', "%{$search}%");
            });
        }

        $teachers = $query->paginate(15);

        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('teachers.form', ['teacher' => new Teacher()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'numeric', 'digits_between:9,15', 'regex:/^[0-9]+$/'],
            'subject_name' => ['nullable', 'string', 'max:255'],
        ]);

        Teacher::create($validated);

        return redirect('/teachers')->with('success', "O'qituvchi qo'shildi.");
    }

    public function edit(Teacher $teacher)
    {
        $teacher->load('certificates');
        return view('teachers.form', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'numeric', 'digits_between:9,15', 'regex:/^[0-9]+$/'],
            'subject_name' => ['nullable', 'string', 'max:255'],
        ]);

        $teacher->update($validated);

        return redirect('/teachers')->with('success', "O'qituvchi yangilandi.");
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->certificates()->delete();
        $teacher->delete();

        return back()->with('success', "O'qituvchi o'chirildi.");
    }

    public function storeCertificate(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'issued_by' => ['nullable', 'string', 'max:255'],
            'issued_date' => ['nullable', 'date'],
        ]);

        $teacher->certificates()->create($validated);

        return back()->with('success', 'Sertifikat qo\'shildi.');
    }

    public function destroyCertificate(Teacher $teacher, TeacherCertificate $certificate)
    {
        $certificate->delete();

        return back()->with('success', 'Sertifikat o\'chirildi.');
    }
}
