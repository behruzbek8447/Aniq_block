<?php

namespace App\Http\Controllers;

use App\Exports\ClassroomsExport;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ClassroomController extends Controller
{
    public function index(Request $request)
    {
        $query = Classroom::withCount('enrollments')->latest();

        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('room_number', 'like', "%{$search}%");
            });
        }

        $classrooms = $query->paginate(15);

        return view('classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        return view('classrooms.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'room_number' => ['nullable', 'string', 'max:50'],
        ]);

        Classroom::create($validated);

        return redirect('/classrooms')->with('success', "Guruh qo'shildi.");
    }

    public function edit(Classroom $classroom)
    {
        return view('classrooms.form', compact('classroom'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'room_number' => ['nullable', 'string', 'max:50'],
        ]);

        $classroom->update($validated);

        return redirect('/classrooms')->with('success', "Guruh yangilandi.");
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();

        return back()->with('success', "Guruh o'chirildi.");
    }

    public function export()
    {
        return Excel::download(new ClassroomsExport, 'guruhlar.xlsx');
    }
}
