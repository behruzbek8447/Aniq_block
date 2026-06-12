@extends('layouts.admin')

@section('title', 'Biriktirishlar')
@section('heading', 'Biriktirishlar')

@section('content')
<style>
    .toolbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; gap: 12px; flex-wrap: wrap; }
    .toolbar-left { display: flex; gap: 8px; flex: 1; max-width: 400px; }
    .toolbar-left form { display: flex; gap: 8px; flex: 1; }
    .toolbar input { flex: 1; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.85rem; outline: none; font-family: inherit; }
    .toolbar input:focus { border-color: #a16207; box-shadow: 0 0 0 3px rgba(161,98,7,0.1); }
    .toolbar-right { display: flex; gap: 8px; flex-wrap: wrap; }
    .btn { padding: 10px 18px; border: none; border-radius: 10px; font-size: 0.85rem; font-weight: 600; cursor: pointer; text-decoration: none; font-family: inherit; white-space: nowrap; display: inline-flex; align-items: center; gap: 6px; transition: background 0.15s, transform 0.1s; }
    .btn-primary { background: #a16207; color: #fff; }
    .btn-primary:hover { background: #854d0e; transform: translateY(-1px); }
    .btn-danger { background: #dc2626; color: #fff; }
    .btn-danger:hover { background: #b91c1c; }
    .btn-outline { background: #fff; color: #374151; border: 1.5px solid #e5e7eb; }
    .btn-outline:hover { background: #fefce8; border-color: #a16207; color: #a16207; }
    .btn-sm { padding: 6px 12px; font-size: 0.8rem; border-radius: 8px; }
    .table-wrap { background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 6px rgba(0,0,0,0.04); }
    table { width: 100%; border-collapse: collapse; }
    th { text-align: left; padding: 12px 16px; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; background: #fefce8; border-bottom: 1px solid #e5e7eb; }
    td { padding: 12px 16px; font-size: 0.85rem; color: #374151; border-bottom: 1px solid #f3f4f6; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #fffbeb; }
    .empty { text-align: center; padding: 48px 16px; color: #9ca3af; }
    .actions { display: flex; gap: 6px; }
    .pagination { display: flex; justify-content: center; gap: 4px; padding: 16px; }
    .pagination a, .pagination span { padding: 6px 12px; border-radius: 8px; font-size: 0.8rem; text-decoration: none; color: #374151; background: #fff; border: 1px solid #e5e7eb; }
    .pagination .active { background: #a16207; color: #fff; border-color: #a16207; }
    .pagination a:hover { background: #fefce8; border-color: #a16207; }
    .badge { display: inline-block; padding: 2px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; background: #fefce8; color: #a16207; }
    @media (max-width: 768px) { .toolbar-left { max-width: 100%; } .table-wrap { overflow-x: auto; } table { min-width: 500px; } }
</style>

<div class="toolbar">
    <div class="toolbar-left">
        <form method="GET">
            <input type="text" name="q" placeholder="O'quvchi yoki guruh nomi..." value="{{ request('q') }}">
            <button class="btn btn-outline" type="submit">Qidirish</button>
        </form>
    </div>
    <div class="toolbar-right">
        <a href="/enrollments/create" class="btn btn-primary">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Biriktirish
        </a>
    </div>
</div>

<div class="table-wrap">
    @if($enrollments->count())
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>O'quvchi</th>
                <th>Guruh</th>
                <th>Biriktirilgan vaqt</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($enrollments as $i => $enrollment)
            <tr>
                <td style="color:#9ca3af;">{{ $enrollments->firstItem() + $i }}</td>
                <td style="font-weight:500;">{{ $enrollment->student->fio ?: trim(($enrollment->student->first_name ?? '') . ' ' . ($enrollment->student->last_name ?? '')) }}</td>
                <td><span class="badge">{{ $enrollment->classroom->name }}</span></td>
                <td style="font-size:0.8rem;color:#9ca3af;">{{ $enrollment->enrolled_at->format('d.m.Y H:i') }}</td>
                <td>
                    <form method="POST" action="/enrollments/{{ $enrollment->id }}" onsubmit="return confirm('O\'chirishni tasdiqlaysizmi?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">O'chirish</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination">{{ $enrollments->links() }}</div>
    @else
    <div class="empty">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        <p>Hozircha biriktirishlar yo'q</p>
    </div>
    @endif
</div>
@endsection
