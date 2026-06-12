<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\Attendance;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalClassrooms = Classroom::count();
        $totalEnrollments = Enrollment::count();

        $todayAttendance = Attendance::whereDate('date', today())->get();
        $presentToday = $todayAttendance->where('status', 'present')->count();
        $absentToday = $todayAttendance->where('status', 'absent')->count();
        $totalTodayMarked = $todayAttendance->count();

        $recentStudents = Student::latest()->take(5)->get();

        $recentAttendance = Attendance::with('student')
            ->latest()
            ->take(10)
            ->get();

        $classroomStats = Classroom::withCount('enrollments')->get();

        $weeklyData = [];
        $weekdays = ['Dushanba', 'Seshanba', 'Chorshanba', 'Payshanba', 'Juma', 'Shanba'];
        foreach ($weekdays as $i => $day) {
            $date = now()->startOfWeek()->addDays($i);
            $weeklyData[] = [
                'day' => $day,
                'count' => Attendance::whereDate('date', $date)->where('status', 'present')->count(),
            ];
        }

        return view('dashboard.index', compact(
            'totalStudents', 'totalTeachers', 'totalClassrooms', 'totalEnrollments',
            'presentToday', 'absentToday', 'totalTodayMarked',
            'recentStudents', 'recentAttendance', 'classroomStats', 'weeklyData'
        ));
    }
}
