@extends('layouts.admin')

@section('title', "O'quvchilar")
@section('heading', "O'quvchilar")

@section('content')
<style>
    .toolbar {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 20px; gap: 12px; flex-wrap: wrap;
    }
    .toolbar-left { display: flex; gap: 8px; flex: 1; max-width: 400px; }
    .toolbar-left form { display: flex; gap: 8px; flex: 1; }
    .toolbar input {
        flex: 1; padding: 10px 14px;
        border: 1.5px solid #e5e7eb; border-radius: 10px;
        font-size: 0.85rem; outline: none; font-family: inherit;
    }
    .toolbar input:focus { border-color: #a16207; box-shadow: 0 0 0 3px rgba(161,98,7,0.1); }
    .toolbar-right { display: flex; gap: 8px; flex-wrap: wrap; }

    .btn {
        padding: 10px 18px; border: none; border-radius: 10px;
        font-size: 0.85rem; font-weight: 600; cursor: pointer;
        text-decoration: none; font-family: inherit;
        white-space: nowrap;
        display: inline-flex; align-items: center; gap: 6px;
        transition: background 0.15s, transform 0.1s;
    }
    .btn-primary { background: #a16207; color: #fff; }
    .btn-primary:hover { background: #854d0e; transform: translateY(-1px); }
    .btn-success { background: #166534; color: #fff; }
    .btn-success:hover { background: #15803d; transform: translateY(-1px); }
    .btn-outline { background: #fff; color: #374151; border: 1.5px solid #e5e7eb; }
    .btn-outline:hover { background: #fefce8; border-color: #a16207; color: #a16207; }
    .btn-sm { padding: 6px 12px; font-size: 0.8rem; border-radius: 8px; }
    .btn-danger { background: #dc2626; color: #fff; }
    .btn-danger:hover { background: #b91c1c; }
    .btn-warning { background: #a16207; color: #fff; }
    .btn-warning:hover { background: #854d0e; }
    .btn-info { background: #1d4ed8; color: #fff; }
    .btn-info:hover { background: #1e40af; }

    .table-wrap {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 6px rgba(0,0,0,0.04);
    }
    table { width: 100%; border-collapse: collapse; }
    th {
        text-align: left; padding: 12px 16px;
        font-size: 0.75rem; font-weight: 600; color: #6b7280;
        text-transform: uppercase; letter-spacing: 0.05em;
        background: #fefce8; border-bottom: 1px solid #e5e7eb;
    }
    td {
        padding: 12px 16px;
        font-size: 0.85rem; color: #374151;
        border-bottom: 1px solid #f3f4f6;
    }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #fffbeb; }

    .pagination { display: flex; justify-content: center; gap: 4px; padding: 16px; }
    .pagination a, .pagination span {
        padding: 6px 12px; border-radius: 8px;
        font-size: 0.8rem; text-decoration: none; color: #374151;
        background: #fff; border: 1px solid #e5e7eb;
    }
    .pagination .active { background: #a16207; color: #fff; border-color: #a16207; }
    .pagination a:hover { background: #fefce8; border-color: #a16207; }

    .empty { text-align: center; padding: 48px 16px; color: #9ca3af; }
    .empty p { margin-top: 4px; }

    .actions { display: flex; gap: 6px; flex-wrap: wrap; }

    .count-badge {
        display: inline-block; padding: 2px 10px; border-radius: 20px;
        background: #fefce8; color: #a16207; font-size: 0.75rem; font-weight: 700;
    }
    .badge-att {
        display: inline-block; padding: 2px 8px; border-radius: 6px;
        font-size: 0.7rem; font-weight: 700;
    }
    .badge-present { background: #f0fdf4; color: #166534; }
    .badge-absent { background: #fef2f2; color: #dc2626; }
    .badge-leave { background: #fefce8; color: #a16207; }
    .chk-sm { display: inline-flex; align-items: center; cursor: pointer; }
    .chk-sm input { display: none; }
    .chk-sm .chk-sq {
        width: 22px; height: 22px; border-radius: 5px;
        border: 2px solid #d1d5db; background: #fff;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.15s;
    }
    .chk-sm .chk-sq svg { width: 12px; height: 12px; stroke: #fff; }
    .chk-sm.checked .chk-sq { background: #166534; border-color: #166534; }
    .chk-sm:hover .chk-sq { border-color: #a16207; }

    .classroom-label {
        display: inline-block; padding: 2px 8px; border-radius: 6px;
        font-size: 0.7rem; font-weight: 600;
        background: #f0fdf4; color: #166534; margin: 1px;
    }

    @media (max-width: 768px) {
        .toolbar-left { max-width: 100%; }
        .toolbar input { min-width: 0; }
        .toolbar-right .btn { padding: 8px 12px; font-size: 0.8rem; }
        .table-wrap { overflow-x: auto; border-radius: 12px; }
        table { min-width: 700px; }
        th, td { padding: 10px 12px; }
        .actions { flex-direction: column; gap: 4px; }
        .btn-sm { padding: 4px 10px; font-size: 0.75rem; text-align: center; }
    }
</style>

<div class="toolbar">
    <div class="toolbar-left">
        <form method="GET">
            <input type="text" name="q" placeholder="Qidirish..." value="{{ request('q') }}">
            <button class="btn btn-outline" type="submit">Qidirish</button>
        </form>
    </div>
    <div class="toolbar-right">
        <a href="/students/import" class="btn btn-outline">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Import
        </a>
        <a href="/students/export" class="btn btn-success">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
            Export
        </a>
        <a href="/students/create" class="btn btn-primary">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Yangi
        </a>
    </div>
</div>

<div class="table-wrap">
    @if($students->count())
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>F.I.SH</th>
                <th>Telefon</th>
                <th>Guruhlari</th>
                <th>Bugun</th>
                <th>Qo'shildi</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $i => $student)
            <tr>
                <td style="color:#9ca3af;">{{ $students->firstItem() + $i }}</td>
                <td style="font-weight:500;">
                    {{ $student->first_name ? trim($student->first_name . ' ' . $student->last_name) : $student->fio }}
                </td>
                <td>+998{{ $student->phone }}</td>
                <td>
                    @forelse($student->enrollments as $e)
                        <span class="classroom-label">{{ $e->classroom->name }}</span>
                    @empty
                        <span style="color:#9ca3af;font-size:0.8rem;">—</span>
                    @endforelse
                </td>
                <td>
                    @php $ta = $student->todayAttendance; @endphp
                    @if($ta && $ta->status === 'present')
                        <span style="display:inline-flex;align-items:center;gap:4px;color:#166534;font-weight:600;font-size:0.85rem;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            Keldi
                        </span>
                    @else
                        <span style="display:inline-flex;align-items:center;gap:4px;color:#dc2626;font-weight:600;font-size:0.85rem;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            Kemadi
                        </span>
                    @endif
                </td>
                <td style="font-size:0.8rem;color:#9ca3af;">{{ $student->created_at->format('d.m.Y') }}</td>
                <td>
                    <div class="actions">
                        <a href="/students/{{ $student->id }}/profile" class="btn btn-sm btn-info">Profil</a>
                        <a href="/students/{{ $student->id }}/edit" class="btn btn-sm btn-warning">Tahrirlash</a>
                        <form method="POST" action="/students/{{ $student->id }}" onsubmit="return confirm('O\'chirishni tasdiqlaysizmi?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">O'chirish</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination">
        {{ $students->links() }}
    </div>
    @else
    <div class="empty">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        <p>Hozircha o'quvchilar yo'q</p>
    </div>
    @endif
</div>
@endsection
