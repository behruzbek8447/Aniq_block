<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $classrooms = Classroom::with('schedules')->withCount('enrollments')->get();
        $days = ['', 'Dushanba', 'Seshanba', 'Chorshanba', 'Payshanba', 'Juma', 'Shanba', 'Yakshanba'];

        $selectedClassroomId = $request->get('classroom_id');

        return view('schedules.index', compact('classrooms', 'days', 'selectedClassroomId'));
    }

    public function create()
    {
        $classrooms = Classroom::all();
        $days = ['', 'Dushanba', 'Seshanba', 'Chorshanba', 'Payshanba', 'Juma', 'Shanba', 'Yakshanba'];

        return view('schedules.form', compact('classrooms', 'days'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'classroom_id' => ['required', 'exists:classrooms,id'],
            'day_of_week' => ['required', 'integer', 'between:1,7'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'subject_name' => ['required', 'string', 'max:255'],
            'teacher_name' => ['nullable', 'string', 'max:255'],
        ]);

        Schedule::create($validated);

        return redirect('/schedules?classroom_id=' . $validated['classroom_id'])->with('success', "Dars qo'shildi.");
    }

    public function edit(Schedule $schedule)
    {
        $classrooms = Classroom::all();
        $days = ['', 'Dushanba', 'Seshanba', 'Chorshanba', 'Payshanba', 'Juma', 'Shanba', 'Yakshanba'];

        return view('schedules.form', compact('schedule', 'classrooms', 'days'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'classroom_id' => ['required', 'exists:classrooms,id'],
            'day_of_week' => ['required', 'integer', 'between:1,7'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'subject_name' => ['required', 'string', 'max:255'],
            'teacher_name' => ['nullable', 'string', 'max:255'],
        ]);

        $schedule->update($validated);

        return redirect('/schedules?classroom_id=' . $validated['classroom_id'])->with('success', "Dars yangilandi.");
    }

    public function destroy(Schedule $schedule)
    {
        $classroomId = $schedule->classroom_id;
        $schedule->delete();

        return redirect('/schedules?classroom_id=' . $classroomId)->with('success', "Dars o'chirildi.");
    }
}
