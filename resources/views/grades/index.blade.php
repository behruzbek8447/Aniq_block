@extends('layouts.admin')

@section('title', 'Baholar')
@section('heading', 'Baholar')

@section('content')
<style>
    .toolbar { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; gap:12px; flex-wrap:wrap; }
    .toolbar-left { display:flex; gap:8px; flex:1; max-width:400px; }
    .toolbar-left form { display:flex; gap:8px; flex:1; }
    .toolbar input, .toolbar select { padding:10px 14px; border:1.5px solid #e5e7eb; border-radius:10px; font-size:.85rem; outline:none; font-family:inherit; background:#fff; }
    .toolbar input:focus, .toolbar select:focus { border-color:#a16207; box-shadow:0 0 0 3px rgba(161,98,7,.1); }
    .toolbar select { max-width:180px; }
    .toolbar-right { display:flex; gap:8px; flex-wrap:wrap; }
    .btn { padding:10px 18px; border:none; border-radius:10px; font-size:.85rem; font-weight:600; cursor:pointer; text-decoration:none; font-family:inherit; white-space:nowrap; display:inline-flex; align-items:center; gap:6px; transition:background .15s,transform .1s; }
    .btn-primary { background:#a16207; color:#fff; }
    .btn-primary:hover { background:#854d0e; transform:translateY(-1px); }
    .btn-warning { background:#a16207; color:#fff; }
    .btn-warning:hover { background:#854d0e; }
    .btn-danger { background:#dc2626; color:#fff; }
    .btn-danger:hover { background:#b91c1c; }
    .btn-outline { background:#fff; color:#374151; border:1.5px solid #e5e7eb; }
    .btn-outline:hover { background:#fefce8; border-color:#a16207; color:#a16207; }
    .btn-sm { padding:6px 12px; font-size:.8rem; border-radius:8px; }
    .table-wrap { background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 1px 6px rgba(0,0,0,.04); }
    table { width:100%; border-collapse:collapse; }
    th { text-align:left; padding:12px 16px; font-size:.75rem; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:.05em; background:#fefce8; border-bottom:1px solid #e5e7eb; }
    td { padding:12px 16px; font-size:.85rem; color:#374151; border-bottom:1px solid #f3f4f6; }
    tr:last-child td { border-bottom:none; }
    tr:hover td { background:#fffbeb; }
    .actions { display:flex; gap:6px; }
    .pagination { display:flex; justify-content:center; gap:4px; padding:16px; }
    .pagination a, .pagination span { padding:6px 12px; border-radius:8px; font-size:.8rem; text-decoration:none; color:#374151; background:#fff; border:1px solid #e5e7eb; }
    .pagination .active { background:#a16207; color:#fff; border-color:#a16207; }
    .pagination a:hover { background:#fefce8; border-color:#a16207; }
    .empty { text-align:center; padding:48px 16px; color:#9ca3af; }
    .grade-badge { display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:8px; font-weight:700; font-size:.85rem; }
    .grade-5 { background:#f0fdf4; color:#166534; }
    .grade-4 { background:#fefce8; color:#a16207; }
    .grade-3 { background:#fff7ed; color:#c2410c; }
    .grade-2 { background:#fef2f2; color:#dc2626; }
    .grade-1 { background:#fef2f2; color:#991b1b; }
    .badge-subject { display:inline-block; padding:2px 10px; border-radius:20px; background:#fefce8; color:#a16207; font-size:.75rem; font-weight:700; }
    @media(max-width:768px){ .toolbar-left{max-width:100%} .table-wrap{overflow-x:auto} table{min-width:600px} .actions{flex-direction:column} }
</style>

<div class="toolbar">
    <div class="toolbar-left">
        <form method="GET" style="display:flex;gap:8px;flex:1;">
            <input type="text" name="q" placeholder="O'quvchi..." value="{{ request('q') }}" style="flex:1;">
            <select name="subject_id">
                <option value="">Barcha fanlar</option>
                @foreach($subjects as $s)
                <option value="{{ $s->id }}" {{ request('subject_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                @endforeach
            </select>
            <button class="btn btn-outline" type="submit">Filter</button>
        </form>
    </div>
    <div class="toolbar-right">
        <a href="/grades/create" class="btn btn-primary">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Baho qo'shish
        </a>
    </div>
</div>

<div class="table-wrap">
    @if($grades->count())
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>O'quvchi</th>
                <th>Guruh</th>
                <th>Fan</th>
                <th>Baho</th>
                <th>Sana</th>
                <th>Izoh</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($grades as $i => $grade)
            <tr>
                <td style="color:#9ca3af;">{{ $grades->firstItem() + $i }}</td>
                <td style="font-weight:500;">{{ $grade->enrollment->student->first_name }} {{ $grade->enrollment->student->last_name }}</td>
                <td>{{ $grade->enrollment->classroom->name }}</td>
                <td><span class="badge-subject">{{ $grade->subject->name }}</span></td>
                <td>
                    <span class="grade-badge grade-{{ $grade->grade }}">{{ $grade->grade }}</span>
                </td>
                <td style="font-size:.8rem;color:#9ca3af;">{{ $grade->graded_at->format('d.m.Y') }}</td>
                <td style="font-size:.8rem;color:#9ca3af;max-width:150px;overflow:hidden;text-overflow:ellipsis;">{{ $grade->notes ?? '—' }}</td>
                <td>
                    <div class="actions">
                        <a href="/grades/{{ $grade->id }}/edit" class="btn btn-sm btn-warning">Tahrir</a>
                        <form method="POST" action="/grades/{{ $grade->id }}" onsubmit="return confirm('O\'chirishni tasdiqlaysizmi?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">O'chir</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination">{{ $grades->links() }}</div>
    @else
    <div class="empty">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5"><path d="M12 2v20M2 12h20"/></svg>
        <p>Hozircha baholar yo'q</p>
    </div>
    @endif
</div>
@endsection
