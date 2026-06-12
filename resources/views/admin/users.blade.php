@extends('layouts.admin')

@section('title', 'Adminlar')
@section('heading', 'Adminlar')

@section('content')
<style>
    .toolbar {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 20px; gap: 12px; flex-wrap: wrap;
    }
    .btn {
        padding: 10px 18px; border: none; border-radius: 10px;
        font-size: 0.85rem; font-weight: 600; cursor: pointer;
        text-decoration: none; font-family: inherit;
        display: inline-flex; align-items: center; gap: 6px;
        transition: background 0.15s, transform 0.1s;
    }
    .btn-primary { background: #a16207; color: #fff; }
    .btn-primary:hover { background: #854d0e; transform: translateY(-1px); }
    .btn-sm { padding: 6px 12px; font-size: 0.8rem; border-radius: 8px; }
    .btn-danger { background: #dc2626; color: #fff; }
    .btn-danger:hover { background: #b91c1c; }

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

    .badge {
        display: inline-block; padding: 2px 10px; border-radius: 20px;
        font-size: 0.75rem; font-weight: 600;
    }
    .badge-super { background: #fefce8; color: #a16207; }
    .badge-admin { background: #f0fdf4; color: #166534; }

    .actions { display: flex; gap: 6px; }

    .pagination { display: flex; justify-content: center; gap: 4px; padding: 16px; }
    .pagination a, .pagination span {
        padding: 6px 12px; border-radius: 8px;
        font-size: 0.8rem; text-decoration: none; color: #374151;
        background: #fff; border: 1px solid #e5e7eb;
    }
    .pagination .active { background: #a16207; color: #fff; border-color: #a16207; }
    .pagination a:hover { background: #fefce8; border-color: #a16207; }

    .empty { text-align: center; padding: 48px 16px; color: #9ca3af; }
</style>

<div class="toolbar">
    <div style="font-size:0.85rem;color:#6b7280;">
        Jami: <strong>{{ $users->total() }}</strong> ta foydalanuvchi
    </div>
    <a href="/admin/users/create" class="btn btn-primary">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Yangi admin
    </a>
</div>

<div class="table-wrap">
    @if($users->count())
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Ism</th>
                <th>Telefon</th>
                <th>Rol</th>
                <th>Qo'shilgan</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $i => $user)
            <tr>
                <td style="color:#9ca3af;">{{ $users->firstItem() + $i }}</td>
                <td style="font-weight:500;">{{ $user->name }} @if($user->id === auth()->id())<span style="color:#9ca3af;font-weight:400;">(siz)</span>@endif</td>
                <td>+998{{ $user->phone }}</td>
                <td>
                    <span class="badge {{ $user->role === 'super_admin' ? 'badge-super' : 'badge-admin' }}">
                        {{ $user->role === 'super_admin' ? 'Super admin' : 'Admin' }}
                    </span>
                </td>
                <td style="font-size:0.8rem;color:#9ca3af;">{{ $user->created_at->format('d.m.Y') }}</td>
                <td>
                    <div class="actions">
                        @if($user->id !== auth()->id())
                        <form method="POST" action="/admin/users/{{ $user->id }}" onsubmit="return confirm('Foydalanuvchini o\'chirishni tasdiqlaysizmi?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">O'chirish</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination">
        {{ $users->links() }}
    </div>
    @else
    <div class="empty"><p>Foydalanuvchilar yo'q</p></div>
    @endif
</div>
@endsection
