<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', today()->format('Y-m'));
        $date = Carbon::parse($month . '-01');
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();

        $students = Student::with(['todayAttendance', 'attendance' => function ($q) use ($startOfMonth, $endOfMonth) {
            $q->whereBetween('date', [$startOfMonth, $endOfMonth]);
        }])->latest()->get();

        $days = [];
        $day = $startOfMonth->copy();
        while ($day->lte($endOfMonth)) {
            $days[] = $day->copy();
            $day->addDay();
        }

        $stats = [
            'present' => Attendance::whereDate('date', today())->where('status', 'present')->count(),
            'absent' => Attendance::whereDate('date', today())->where('status', 'absent')->count(),
            'total' => Student::count(),
        ];

        $this->cleanupOldRecords();

        return view('attendance.index', compact('students', 'days', 'month', 'date', 'stats'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
        ]);

        $record = Attendance::where('student_id', $request->student_id)
            ->whereDate('date', $request->date)
            ->first();

        if ($request->has('chk')) {
            if ($record) {
                $record->update(['status' => 'present']);
            } else {
                Attendance::create([
                    'student_id' => $request->student_id,
                    'date' => Carbon::parse($request->date)->format('Y-m-d'),
                    'status' => 'present',
                    'created_by' => Auth::id(),
                ]);
            }
        } else {
            if ($record) {
                $record->delete();
            }
        }

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return back();
    }

    public function markAllPresent(Request $request)
    {
        $request->validate(['date' => 'required|date']);
        $date = Carbon::parse($request->date)->format('Y-m-d');
        $students = Student::all();
        $count = 0;

        foreach ($students as $student) {
            $record = Attendance::where('student_id', $student->id)
                ->whereDate('date', $date)
                ->first();

            if (!$record) {
                Attendance::create([
                    'student_id' => $student->id,
                    'date' => $date,
                    'status' => 'present',
                    'created_by' => Auth::id(),
                ]);
                $count++;
            }
        }

        return back()->with('success', "Barcha o'quvchilar hozir deb belgilandi.");
    }

    public function clearDay(Request $request)
    {
        $request->validate(['date' => 'required|date']);
        $date = Carbon::parse($request->date)->format('Y-m-d');

        Attendance::where('date', $date)->delete();

        return back()->with('success', "Kunning barcha yozuvlari o'chirildi.");
    }

    private function cleanupOldRecords(): void
    {
        Attendance::where('created_at', '<', now()->subMonths(3))->delete();
    }
}
