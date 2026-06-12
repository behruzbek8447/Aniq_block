@extends('layouts.admin')

@section('title', 'Davomat')
@section('heading', 'Davomat')

@section('content')
<style>
    .stats { display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap; }
    .stat-card {
        flex: 1; min-width: 120px; background: #fff;
        border-radius: 14px; padding: 16px 20px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.04);
        text-align: center;
    }
    .stat-card .num { font-size: 1.5rem; font-weight: 800; }
    .stat-card .label { font-size: 0.75rem; color: #6b7280; margin-top: 2px; }
    .stat-present .num { color: #166534; }
    .stat-absent .num { color: #dc2626; }
    .stat-leave .num { color: #a16207; }
    .stat-total .num { color: #374151; }
    .stat-present { border-top: 3px solid #166534; }
    .stat-absent { border-top: 3px solid #dc2626; }
    .stat-total { border-top: 3px solid #6b7280; }

    .actions-bar {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 20px; gap: 12px; flex-wrap: wrap;
    }
    .month-nav { display: flex; align-items: center; gap: 12px; }
    .month-nav h3 {
        font-size: 1rem; color: #111827; font-weight: 600;
        min-width: 160px; text-align: center;
    }
    .month-nav a {
        padding: 6px 14px; border-radius: 8px;
        background: #fff; border: 1.5px solid #e5e7eb;
        color: #374151; text-decoration: none; font-size: 0.85rem;
        transition: all 0.15s;
    }
    .month-nav a:hover { background: #fefce8; border-color: #a16207; color: #a16207; }

    .btn-group { display: flex; gap: 8px; flex-wrap: wrap; }
    .btn {
        padding: 8px 16px; border: none; border-radius: 8px;
        font-size: 0.8rem; font-weight: 600; cursor: pointer;
        text-decoration: none; font-family: inherit; white-space: nowrap;
        transition: background 0.15s, transform 0.1s;
    }
    .btn-sm { padding: 4px 10px; font-size: 0.75rem; border-radius: 6px; }
    .btn-yellow { background: #a16207; color: #fff; }
    .btn-yellow:hover { background: #854d0e; }
    .btn-success { background: #166534; color: #fff; }
    .btn-success:hover { background: #15803d; }
    .btn-danger { background: #dc2626; color: #fff; }
    .btn-danger:hover { background: #b91c1c; }
    .btn-outline { background: #fff; color: #374151; border: 1.5px solid #e5e7eb; }
    .btn-outline:hover { background: #fefce8; border-color: #a16207; color: #a16207; }

    .table-wrap {
        background: #fff;
        border-radius: 16px;
        overflow: auto;
        box-shadow: 0 1px 6px rgba(0,0,0,0.04);
    }
    table { width: 100%; border-collapse: collapse; min-width: 900px; }
    th {
        text-align: center; padding: 8px 6px;
        font-size: 0.7rem; font-weight: 600; color: #6b7280;
        text-transform: uppercase; letter-spacing: 0.03em;
        background: #fefce8; border-bottom: 1px solid #e5e7eb;
        white-space: nowrap;
    }
    th:first-child { text-align: left; padding-left: 16px; position: sticky; left: 0; background: #fefce8; z-index: 2; min-width: 160px; }
    th.day-header { min-width: 36px; }
    th.weekend { color: #dc2626; background: #fef2f2; }
    th.today { background: #fefce8; color: #a16207; font-weight: 800; }

    td { text-align: center; padding: 6px; border-bottom: 1px solid #f3f4f6; font-size: 0.8rem; }
    td:first-child {
        text-align: left; padding-left: 16px;
        font-weight: 500; color: #374151;
        position: sticky; left: 0; background: #fff; z-index: 1;
    }
    tr:hover td { background: #fffbeb; }
    tr:hover td:first-child { background: #fffbeb; }

    .status-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 28px; height: 28px; border-radius: 6px;
        border: 1.5px solid #e5e7eb; background: #fff;
        cursor: pointer; font-size: 0.75rem;
        transition: all 0.15s;
        font-family: inherit;
    }
    .status-btn:hover { border-color: #a16207; }
    .status-btn.present { background: #166534; border-color: #166534; color: #fff; }
    .status-btn.absent { background: #dc2626; border-color: #dc2626; color: #fff; }
    .status-btn.leave { background: #a16207; border-color: #a16207; color: #fff; }
    .status-btn.today-btn { width: auto; padding: 0 8px; gap: 3px; }

    .day-label { display: flex; flex-direction: column; align-items: center; line-height: 1.2; }
    .day-label .dow { font-size: 0.6rem; color: #9ca3af; }
    .day-label .dom { font-size: 0.8rem; font-weight: 600; }

    .chk-wrap { display: inline-flex; align-items: center; cursor: pointer; }
    .chk-wrap input { display: none; }
    .chk-wrap .chk-box {
        width: 24px; height: 24px; border-radius: 5px;
        border: 2px solid #d1d5db; background: #fff;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.15s;
    }
    .chk-wrap .chk-box svg { width: 14px; height: 14px; stroke: #fff; }
    .chk-wrap.checked .chk-box { background: #166534; border-color: #166534; }
    .chk-wrap:hover .chk-box { border-color: #a16207; }

    @media (max-width: 768px) {
        .stats { gap: 8px; }
        .stat-card { min-width: 80px; padding: 12px; }
        .stat-card .num { font-size: 1.2rem; }
        .actions-bar { flex-direction: column; align-items: stretch; }
        .month-nav { justify-content: center; }
        .month-nav h3 { min-width: 120px; font-size: 0.9rem; }
        .btn-group { justify-content: center; }
        .table-wrap { overflow-x: auto; border-radius: 12px; }
        table { min-width: 600px; }
        th, td { padding: 6px 4px; }
        th:first-child { min-width: 100px; }
        th.day-header { min-width: 30px; }
    }
</style>

<div class="stats">
    <div class="stat-card stat-present">
        <div class="num">{{ $stats['present'] }}</div>
        <div class="label">Bugun bor</div>
    </div>
    <div class="stat-card stat-absent">
        <div class="num">{{ $stats['absent'] }}</div>
        <div class="label">Bugun yo'q</div>
    </div>
    <div class="stat-card stat-total">
        <div class="num">{{ $stats['total'] }}</div>
        <div class="label">Jami o'quvchi</div>
    </div>
</div>

<div class="actions-bar">
    <div class="month-nav">
        <a href="?month={{ $date->copy()->subMonth()->format('Y-m') }}">←</a>
        <h3>{{ $date->format('Y') }} — {{ __(ucfirst($date->format('F'))) }}</h3>
        <a href="?month={{ $date->copy()->addMonth()->format('Y-m') }}">→</a>
    </div>
    <div class="btn-group">
        <form method="POST" action="/attendance/mark-all" style="display:inline">
            @csrf
            <input type="hidden" name="date" value="{{ today()->format('Y-m-d') }}">
            <button type="submit" class="btn btn-success">Barchasini belgilash</button>
        </form>
        <form method="POST" action="/attendance/clear-day" style="display:inline" onsubmit="return confirm('Kunning barcha yozuvlari o\'chirilsinmi?')">
            @csrf
            <input type="hidden" name="date" value="{{ today()->format('Y-m-d') }}">
            <button type="submit" class="btn btn-danger">Kunni tozalash</button>
        </form>
    </div>
</div>

<div class="table-wrap">
    <div style="padding:8px 16px;background:#fff;border-bottom:1px solid #e5e7eb;display:flex;gap:16px;font-size:0.8rem;color:#6b7280;">
        <span><span style="display:inline-block;width:10px;height:10px;border-radius:3px;background:#166534;margin-right:4px;"></span> Bor (check)</span>
        <span><span style="display:inline-block;width:10px;height:10px;border-radius:3px;background:#dc2626;margin-right:4px;"></span> Yo'q (bo'sh)</span>
        <span style="color:#9ca3af;">| Bugun uchun checkboxni bosib qo'ying</span>
    </div>
    <table>
        <thead>
            <tr>
                <th>O'quvchi</th>
                @foreach($days as $day)
                <th class="day-header {{ $day->isWeekend() ? 'weekend' : '' }} {{ $day->isToday() ? 'today' : '' }}">
                    <div class="day-label">
                        <span class="dow">{{ substr($day->format('D'), 0, 2) }}</span>
                        <span class="dom">{{ $day->format('j') }}</span>
                    </div>
                </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
            <tr>
                <td>{{ $student->first_name ? trim($student->first_name . ' ' . $student->last_name) : $student->fio }}</td>
                @foreach($days as $day)
                    @php
                        $record = $student->attendance->firstWhere('date', $day->format('Y-m-d'));
                        $status = $record?->status;
                        $isToday = $day->isToday();
                    @endphp
                    <td>
                        @if($isToday)
                        <label class="chk-wrap {{ $status === 'present' ? 'checked' : '' }}">
                            <form method="POST" action="/attendance/toggle" class="inline-form">
                                @csrf
                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                                <input type="hidden" name="date" value="{{ $day->format('Y-m-d') }}">
                                <input type="checkbox" name="chk" {{ $status === 'present' ? 'checked' : '' }} onchange="this.form.submit()">
                                <span class="chk-box">
                                    @if($status === 'present')
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                    @endif
                                </span>
                            </form>
                        </label>
                        @else
                            @if($status === 'present')
                            <span class="status-btn present" title="Bor">✓</span>
                            @elseif($status === 'absent')
                            <span class="status-btn absent" title="Yo'q">✗</span>
                            @else
                            <span style="color:#e5e7eb;">·</span>
                            @endif
                        @endif
                    </td>
                @endforeach
            </tr>
            @empty
            <tr><td colspan="{{ count($days) + 1 }}" style="text-align:center;padding:32px;color:#9ca3af;">O'quvchilar yo'q</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
