@extends('layouts.admin')

@section('title', $teacher->id ? "O'qituvchini tahrirlash" : "Yangi o'qituvchi")
@section('heading', $teacher->id ? "O'qituvchini tahrirlash" : "Yangi o'qituvchi")

@section('content')
<style>
    .card { max-width:600px; background:#fff; border-radius:16px; padding:32px; box-shadow:0 1px 6px rgba(0,0,0,.04); margin-bottom:20px; }
    .field { margin-bottom:18px; }
    .field label { display:block; margin-bottom:6px; font-size:.8rem; font-weight:600; color:#374151; }
    .field input { width:100%; padding:10px 14px; border:1.5px solid #e5e7eb; border-radius:10px; font-size:.9rem; color:#111827; background:#fff; outline:none; font-family:inherit; transition:border-color .2s,box-shadow .2s; }
    .field input:focus { border-color:#a16207; box-shadow:0 0 0 3px rgba(161,98,7,.1); }
    .field .error { margin-top:4px; font-size:.8rem; color:#dc2626; }
    .row { display:flex; gap:12px; }
    .row .field { flex:1; }
    .actions { display:flex; gap:10px; margin-top:24px; }
    .btn { padding:10px 20px; border:none; border-radius:10px; font-size:.85rem; font-weight:600; cursor:pointer; text-decoration:none; font-family:inherit; transition:background .15s,transform .1s; display:inline-flex; align-items:center; gap:6px; }
    .btn-primary { background:#a16207; color:#fff; }
    .btn-primary:hover { background:#854d0e; transform:translateY(-1px); }
    .btn-secondary { background:#fff; color:#374151; border:1.5px solid #e5e7eb; }
    .btn-secondary:hover { background:#fefce8; border-color:#a16207; }
    .btn-sm { padding:6px 12px; font-size:.8rem; border-radius:8px; }
    .btn-danger { background:#dc2626; color:#fff; }
    .btn-danger:hover { background:#b91c1c; }
    @media(max-width:768px){ .card{padding:20px} .row{flex-direction:column;gap:0} .actions{flex-direction:column} }

    .cert-list { margin-top:12px; }
    .cert-item { display:flex; align-items:center; gap:12px; padding:10px 14px; border:1px solid #e5e7eb; border-radius:10px; margin-bottom:8px; }
    .cert-item:last-child { margin-bottom:0; }
    .cert-info { flex:1; }
    .cert-info .cert-name { font-size:.85rem; font-weight:600; color:#111827; }
    .cert-info .cert-meta { font-size:.75rem; color:#6b7280; }
    .cert-info .cert-meta span { margin-right:12px; }
    .section-title { font-size:.9rem; font-weight:700; color:#111827; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; display:flex; justify-content:space-between; align-items:center; }
    .inline-form { display:flex; gap:8px; flex-wrap:wrap; align-items:flex-end; }
    .inline-form .field { flex:1; min-width:120px; margin-bottom:0; }
    .inline-form .field input { padding:8px 12px; font-size:.8rem; }
</style>

<div class="card">
    <form method="POST" action="{{ $teacher->id ? '/teachers/'.$teacher->id : '/teachers' }}">
        @csrf
        @if($teacher->id) @method('PUT') @endif

        <div class="row">
            <div class="field">
                <label for="first_name">Ism</label>
                <input id="first_name" name="first_name" value="{{ old('first_name', $teacher->first_name ?? '') }}" required>
                @error('first_name')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="last_name">Familiya</label>
                <input id="last_name" name="last_name" value="{{ old('last_name', $teacher->last_name ?? '') }}">
                @error('last_name')<div class="error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="field">
            <label for="phone">Telefon</label>
            <div style="display:flex;border:1.5px solid #e5e7eb;border-radius:10px;overflow:hidden;">
                <span style="padding:10px 0 10px 14px;background:#f3f4f6;color:#6b7280;font-weight:600;font-size:.9rem;border-right:1px solid #e5e7eb;">+998</span>
                <input id="phone" name="phone" value="{{ old('phone', $teacher->phone ?? '') }}" placeholder="901234567" style="flex:1;border:none;outline:none;padding:10px 14px;font-size:.9rem;font-family:inherit;">
            </div>
            @error('phone')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="subject_name">Fani</label>
            <input id="subject_name" name="subject_name" value="{{ old('subject_name', $teacher->subject_name ?? '') }}" placeholder="Masalan: Matematika">
            @error('subject_name')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">{{ isset($teacher->id) ? 'Saqlash' : 'Qo\'shish' }}</button>
            <a href="/teachers" class="btn btn-secondary">Bekor qilish</a>
        </div>
    </form>
</div>

@if(isset($teacher->id))
<div class="card">
    <div class="section-title">
        <span>Sertifikatlar</span>
    </div>

    <form method="POST" action="/teachers/{{ $teacher->id }}/certificates" class="inline-form">
        @csrf
        <div class="field">
            <label for="cert_name">Sertifikat nomi</label>
            <input id="cert_name" name="name" placeholder="Sertifikat nomi" required>
        </div>
        <div class="field">
            <label for="issued_by">Bergan tashkilot</label>
            <input id="issued_by" name="issued_by" placeholder="Tashkilot nomi">
        </div>
        <div class="field">
            <label for="issued_date">Berilgan sana</label>
            <input id="issued_date" name="issued_date" type="date">
        </div>
        <button type="submit" class="btn btn-primary btn-sm" style="margin-bottom:0;">Qo'shish</button>
    </form>

    <div class="cert-list">
        @forelse($teacher->certificates as $cert)
            <div class="cert-item">
                <div class="cert-info">
                    <div class="cert-name">{{ $cert->name }}</div>
                    <div class="cert-meta">
                        @if($cert->issued_by)<span>{{ $cert->issued_by }}</span>@endif
                        @if($cert->issued_date)<span>{{ $cert->issued_date->format('d.m.Y') }}</span>@endif
                    </div>
                </div>
                <form method="POST" action="/teachers/{{ $teacher->id }}/certificates/{{ $cert->id }}" onsubmit="return confirm('O\'chirishni tasdiqlaysizmi?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">O'chirish</button>
                </form>
            </div>
        @empty
            <p style="text-align:center;padding:20px 0;color:#9ca3af;font-size:.85rem;">Hali sertifikatlar yo'q</p>
        @endforelse
    </div>
</div>
@endif
@endsection
