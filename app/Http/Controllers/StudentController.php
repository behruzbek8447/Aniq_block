<?php

namespace App\Http\Controllers;

use App\Exports\StudentsExport;
use App\Exports\StudentsImportTemplate;
use App\Imports\StudentsImport;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with('todayAttendance', 'profile', 'enrollments.classroom')->latest();

        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('fio', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $students = $query->paginate(15);

        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'unique:students,phone'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        Student::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'] ?? null,
            'fio' => trim($validated['first_name'] . ' ' . ($validated['last_name'] ?? '')),
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? null,
            'created_by' => Auth::id(),
        ]);

        return redirect('/students')->with('success', "O'quvchi qo'shildi.");
    }

    public function edit(Student $student)
    {
        return view('students.form', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'unique:students,phone,' . $student->id],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $student->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'] ?? null,
            'fio' => trim($validated['first_name'] . ' ' . ($validated['last_name'] ?? '')),
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? null,
        ]);

        return redirect('/students')->with('success', "O'quvchi yangilandi.");
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return back()->with('success', "O'quvchi o'chirildi.");
    }

    public function importForm()
    {
        return view('students.import');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => ['required', 'file', 'mimes:xlsx,xls,csv']]);

        Excel::import(new StudentsImport, $request->file('file'));

        return redirect('/students')->with('success', "Excel'dan o'quvchilar import qilindi.");
    }

    public function export()
    {
        return Excel::download(new StudentsExport, 'oquvchilar.xlsx');
    }

    public function downloadTemplate()
    {
        return Excel::download(new StudentsImportTemplate, 'oquvchilar_shablon.xlsx');
    }
}
