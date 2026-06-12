@extends('layouts.admin')

@section('title', "Dars jadvali")
@section('heading', "Dars jadvali")

@section('content')
<style>
    .toolbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; gap: 12px; flex-wrap: wrap; }
    .toolbar-left { display: flex; gap: 8px; flex: 1; max-width: 400px; }
    .toolbar-left form { display: flex; gap: 8px; flex: 1; align-items: center; }
    .toolbar-left select { flex: 1; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.85rem; outline: none; font-family: inherit; background: #fff; }
    .toolbar-left select:focus { border-color: #a16207; box-shadow: 0 0 0 3px rgba(161,98,7,0.1); }
    .toolbar-right { display: flex; gap: 8px; flex-wrap: wrap; }
    .btn { padding: 10px 18px; border: none; border-radius: 10px; font-size: 0.85rem; font-weight: 600; cursor: pointer; text-decoration: none; font-family: inherit; white-space: nowrap; display: inline-flex; align-items: center; gap: 6px; transition: background 0.15s, transform 0.1s; }
    .btn-primary { background: #a16207; color: #fff; }
    .btn-primary:hover { background: #854d0e; transform: translateY(-1px); }
    .btn-warning { background: #a16207; color: #fff; }
    .btn-warning:hover { background: #854d0e; }
    .btn-danger { background: #dc2626; color: #fff; }
    .btn-danger:hover { background: #b91c1c; }
    .btn-outline { background: #fff; color: #374151; border: 1.5px solid #e5e7eb; }
    .btn-outline:hover { background: #fefce8; border-color: #a16207; color: #a16207; }
    .btn-sm { padding: 6px 12px; font-size: 0.8rem; border-radius: 8px; }

    .schedule-grid { display: grid; grid-template-columns: 100px repeat(7, 1fr); gap: 6px; background: #fff; border-radius: 16px; padding: 16px; box-shadow: 0 1px 6px rgba(0,0,0,0.04); overflow-x: auto; }
    .grid-header { font-weight: 700; font-size: 0.8rem; color: #6b7280; text-align: center; padding: 8px; background: #fefce8; border-radius: 8px; }
    .grid-time { font-size: 0.75rem; color: #9ca3af; text-align: center; padding: 4px; display: flex; align-items: center; justify-content: center; }
    .grid-cell { background: #fffbeb; border-radius: 8px; padding: 8px; min-height: 70px; }
    .grid-cell.empty { background: transparent; }
    .lesson-card { background: #fff; border: 1px solid #fde68a; border-radius: 8px; padding: 6px 8px; margin-bottom: 4px; font-size: 0.75rem; }
    .lesson-card .subject { font-weight: 600; color: #854d0e; }
    .lesson-card .teacher { color: #6b7280; font-size: 0.7rem; }
    .lesson-card .time { color: #9ca3af; font-size: 0.65rem; }
    .lesson-actions { display: flex; gap: 4px; margin-top: 4px; }
    .lesson-actions form { display: inline; }

    .empty-state { text-align: center; padding: 48px 16px; color: #9ca3af; }

    .day-tabs { display: flex; gap: 4px; margin-bottom: 16px; flex-wrap: wrap; }
    .day-tab { padding: 6px 14px; border-radius: 8px; font-size: 0.8rem; font-weight: 500; border: 1.5px solid #e5e7eb; background: #fff; color: #374151; cursor: pointer; text-decoration: none; transition: all 0.15s; }
    .day-tab:hover { border-color: #a16207; color: #a16207; }
    .day-tab.active { background: #a16207; color: #fff; border-color: #a16207; }

    @media (max-width: 768px) {
        .schedule-grid { grid-template-columns: 80px repeat(7, 120px); padding: 12px; }
        .toolbar-left { max-width: 100%; }
    }
</style>

<div class="toolbar">
    <div class="toolbar-left">
        <form method="GET">
            <select name="classroom_id" onchange="this.form.submit()">
                <option value="">— Guruhni tanlang —</option>
                @foreach($classrooms as $c)
                <option value="{{ $c->id }}" {{ $selectedClassroomId == $c->id ? 'selected' : '' }}>
                    {{ $c->name }} {{ $c->room_number ? '('.$c->room_number.')' : '' }}
                </option>
                @endforeach
            </select>
        </form>
    </div>
    <div class="toolbar-right">
        @if($selectedClassroomId)
        <a href="/schedules/create?classroom_id={{ $selectedClassroomId }}" class="btn btn-primary">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Dars qo'shish
        </a>
        @endif
    </div>
</div>

@if($selectedClassroomId)
    @php
        $selectedClassroom = $classrooms->firstWhere('id', $selectedClassroomId);
        $schedules = $selectedClassroom ? $selectedClassroom->schedules->groupBy('day_of_week') : collect();
        $timeSlots = $selectedClassroom ? $selectedClassroom->schedules->sortBy('start_time')->pluck('start_time', 'id')->unique() : collect();
    @endphp

    <div class="schedule-grid">
        <div class="grid-header">Vaqt</div>
        @for($d = 1; $d <= 7; $d++)
            <div class="grid-header {{ in_array($d, [6,7]) ? 'weekend' : '' }}">{{ $days[$d] }}</div>
        @endfor

        @php
            $allLessons = $selectedClassroom ? $selectedClassroom->schedules->sortBy('start_time') : collect();
            $processed = [];
        @endphp

        @foreach($allLessons as $lesson)
            @if(in_array($lesson->id, $processed)) @continue @endif
            @php $processed[] = $lesson->id; @endphp
            <div class="grid-time">{{ substr($lesson->start_time, 0, 5) }} - {{ substr($lesson->end_time, 0, 5) }}</div>
            @for($d = 1; $d <= 7; $d++)
                @php
                    $dayLessons = $allLessons->where('day_of_week', $d)->where('start_time', $lesson->start_time);
                @endphp
                <div class="grid-cell {{ $dayLessons->isEmpty() ? 'empty' : '' }}">
                    @foreach($dayLessons as $l)
                    <div class="lesson-card">
                        <div class="subject">{{ $l->subject_name }}</div>
                        @if($l->teacher_name) <div class="teacher">{{ $l->teacher_name }}</div> @endif
                        <div class="lesson-actions">
                            <a href="/schedules/{{ $l->id }}/edit" class="btn btn-sm btn-warning" style="padding:2px 6px;font-size:0.65rem;">Tahrir</a>
                            <form method="POST" action="/schedules/{{ $l->id }}" onsubmit="return confirm('O\'chirishni tasdiqlaysizmi?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" style="padding:2px 6px;font-size:0.65rem;">O'chir</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endfor
        @endforeach
    </div>
@else
    <div class="empty-state">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        <p>Dars jadvalini ko'rish uchun guruhni tanlang</p>
    </div>
@endif
@endsection
