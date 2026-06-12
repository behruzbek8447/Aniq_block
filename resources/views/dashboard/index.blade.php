@extends('layouts.admin')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')
<style>
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 28px; }
    .stat-card {
        background: #fff; border-radius: 14px; padding: 20px;
        border: 1px solid #e5e7eb;
        display: flex; align-items: center; gap: 16px;
        transition: box-shadow 0.2s;
    }
    .stat-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
    .stat-icon {
        width: 48px; height: 48px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-icon svg { width: 24px; height: 24px; }
    .stat-info h3 { font-size: 1.5rem; font-weight: 800; color: #111827; line-height: 1.2; }
    .stat-info p { font-size: 0.8rem; color: #6b7280; margin-top: 2px; }
    .stat-icon.students { background: #fefce8; color: #a16207; }
    .stat-icon.teachers { background: #f0fdf4; color: #166534; }
    .stat-icon.classrooms { background: #eff6ff; color: #1e40af; }
    .stat-icon.enrollments { background: #fdf2f8; color: #9d174d; }
    .stat-icon.present { background: #f0fdf4; color: #16a34a; }
    .stat-icon.absent { background: #fef2f2; color: #dc2626; }

    .row { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 28px; }
    @media (max-width: 768px) { .row { grid-template-columns: 1fr; } }

    .card {
        background: #fff; border-radius: 14px; border: 1px solid #e5e7eb;
        padding: 20px;
    }
    .card-title {
        font-size: 0.85rem; font-weight: 700; color: #111827;
        padding-bottom: 12px; border-bottom: 1px solid #f3f4f6;
        margin-bottom: 12px;
        display: flex; justify-content: space-between; align-items: center;
    }
    .card-title a { font-size: 0.75rem; font-weight: 500; color: #a16207; text-decoration: none; }
    .card-title a:hover { text-decoration: underline; }

    .student-item, .attendance-item {
        display: flex; align-items: center; gap: 12px;
        padding: 8px 0;
        border-bottom: 1px solid #f9fafb;
    }
    .student-item:last-child, .attendance-item:last-child { border-bottom: none; }
    .student-avatar {
        width: 36px; height: 36px; border-radius: 10px;
        background: #fefce8; color: #a16207;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 0.85rem; flex-shrink: 0;
    }
    .student-info { flex: 1; min-width: 0; }
    .student-info .name { font-size: 0.85rem; font-weight: 600; color: #111827; }
    .student-info .meta { font-size: 0.75rem; color: #9ca3af; }
    .badge {
        font-size: 0.7rem; font-weight: 600; padding: 2px 10px; border-radius: 20px;
    }
    .badge-success { background: #f0fdf4; color: #16a34a; }
    .badge-danger { background: #fef2f2; color: #dc2626; }
    .badge-warning { background: #fefce8; color: #a16207; }

    .bar-chart { display: flex; align-items: flex-end; gap: 8px; height: 120px; padding-top: 10px; }
    .bar-wrapper { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 4px; height: 100%; }
    .bar {
        width: 100%; max-width: 40px; border-radius: 6px 6px 0 0;
        min-height: 4px; transition: height 0.5s ease;
        background: linear-gradient(180deg, #a16207, #ca8a04);
    }
    .bar-label { font-size: 0.65rem; color: #6b7280; font-weight: 500; white-space: nowrap; }

    .classroom-stat { display: flex; align-items: center; gap: 12px; padding: 6px 0; }
    .classroom-stat .bar-mini {
        height: 8px; border-radius: 4px; background: #fefce8; flex: 1; overflow: hidden;
    }
    .classroom-stat .bar-fill {
        height: 100%; border-radius: 4px; background: #a16207; transition: width 0.5s ease;
    }
    .classroom-stat .c-name { font-size: 0.8rem; font-weight: 600; color: #374151; min-width: 80px; }
    .classroom-stat .c-count { font-size: 0.75rem; color: #9ca3af; min-width: 30px; text-align: right; }
</style>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon students">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div class="stat-info">
            <h3>{{ $totalStudents }}</h3>
            <p>O'quvchilar</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon teachers">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
        </div>
        <div class="stat-info">
            <h3>{{ $totalTeachers }}</h3>
            <p>O'qituvchilar</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon classrooms">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
        </div>
        <div class="stat-info">
            <h3>{{ $totalClassrooms }}</h3>
            <p>Guruhlar</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon enrollments">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
        </div>
        <div class="stat-info">
            <h3>{{ $totalEnrollments }}</h3>
            <p>Biriktirishlar</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon present">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <div class="stat-info">
            <h3>{{ $presentToday }}</h3>
            <p>Bugun keldi</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon absent">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </div>
        <div class="stat-info">
            <h3>{{ $absentToday }}</h3>
            <p>Bugun kelmadi</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="card">
        <div class="card-title">
            <span>Oxirgi o'quvchilar</span>
            <a href="/students">Barchasi →</a>
        </div>
        @forelse($recentStudents as $student)
            <div class="student-item">
                <div class="student-avatar">{{ substr($student->first_name ?: $student->fio, 0, 1) }}</div>
                <div class="student-info">
                    <div class="name">{{ $student->first_name ? $student->first_name . ' ' . $student->last_name : $student->fio }}</div>
                    <div class="meta">{{ $student->phone ? '+998' . $student->phone : '' }}</div>
                </div>
                <span class="badge badge-warning">{{ $student->created_at->format('d.m') }}</span>
            </div>
        @empty
            <p style="color: #9ca3af; font-size: 0.85rem; text-align: center; padding: 20px 0;">Hozircha o'quvchilar yo'q</p>
        @endforelse
    </div>

    <div class="card">
        <div class="card-title">
            <span>Haftalik davomat</span>
            <span style="font-size:0.75rem;color:#9ca3af;">Keldi soni</span>
        </div>
        <div class="bar-chart">
            @php $maxVal = max(max(array_column($weeklyData, 'count')), 1); @endphp
            @foreach($weeklyData as $item)
                <div class="bar-wrapper">
                    <div class="bar" style="height: {{ max($item['count'], 0) / $maxVal * 100 }}%;"></div>
                    <div class="bar-label">{{ $item['day'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="row">
    <div class="card">
        <div class="card-title">
            <span>Guruhlar bo'yicha</span>
            <a href="/classrooms">Barchasi →</a>
        </div>
        @php $maxEnrollments = max($classroomStats->max('enrollments_count'), 1); @endphp
        @forelse($classroomStats as $classroom)
            <div class="classroom-stat">
                <div class="c-name">{{ $classroom->name }}</div>
                <div class="bar-mini">
                    <div class="bar-fill" style="width: {{ $classroom->enrollments_count / $maxEnrollments * 100 }}%;"></div>
                </div>
                <div class="c-count">{{ $classroom->enrollments_count }}</div>
            </div>
        @empty
            <p style="color: #9ca3af; font-size: 0.85rem; text-align: center; padding: 20px 0;">Hozircha guruhlar yo'q</p>
        @endforelse
    </div>

    <div class="card">
        <div class="card-title">
            <span>So'nggi davomat</span>
            <a href="/attendance">Barchasi →</a>
        </div>
        @forelse($recentAttendance as $att)
            <div class="attendance-item">
                <div class="student-avatar">{{ $att->student ? substr($att->student->first_name ?: $att->student->fio, 0, 1) : '?' }}</div>
                <div class="student-info">
                    <div class="name">{{ $att->student ? ($att->student->first_name ? $att->student->first_name . ' ' . $att->student->last_name : $att->student->fio) : 'Noma\'lum' }}</div>
                    <div class="meta">{{ $att->date ? \Carbon\Carbon::parse($att->date)->format('d.m.Y') : '' }}</div>
                </div>
                <span class="badge {{ $att->status === 'present' ? 'badge-success' : 'badge-danger' }}">
                    {{ $att->status === 'present' ? 'Keldi' : 'Kemadi' }}
                </span>
            </div>
        @empty
            <p style="color: #9ca3af; font-size: 0.85rem; text-align: center; padding: 20px 0;">Hozircha davomat yo'q</p>
        @endforelse
    </div>
</div>
@endsection
