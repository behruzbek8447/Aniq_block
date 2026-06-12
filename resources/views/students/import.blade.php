@extends('layouts.admin')

@section('title', "Excel'dan import")
@section('heading', "Excel'dan import")

@section('content')
<style>
    .import-card {
        max-width: 520px;
        background: #fff;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.04);
    }
    .import-card .icon {
        width: 48px; height: 48px;
        border-radius: 12px;
        background: #fefce8;
        color: #a16207;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 16px;
    }
    .import-card h3 { font-size: 1rem; color: #111827; margin-bottom: 4px; }
    .import-card p { font-size: 0.85rem; color: #6b7280; margin-bottom: 20px; }

    .field { margin-bottom: 18px; }
    .field label {
        display: block; margin-bottom: 6px;
        font-size: 0.8rem; font-weight: 600; color: #374151;
    }
    .field input[type="file"] {
        width: 100%; padding: 10px 14px;
        border: 1.5px dashed #e5e7eb; border-radius: 10px;
        font-size: 0.9rem; color: #111827;
        background: #f9fafb; outline: none; font-family: inherit;
    }
    .field .hint { margin-top: 4px; font-size: 0.75rem; color: #9ca3af; }

    .btn {
        padding: 10px 20px; border: none; border-radius: 10px;
        font-size: 0.85rem; font-weight: 600; cursor: pointer;
        font-family: inherit;
        transition: background 0.15s, transform 0.1s;
    }
    .btn-primary { background: #a16207; color: #fff; }
    .btn-primary:hover { background: #854d0e; transform: translateY(-1px); }
    .btn-secondary { background: #fff; color: #374151; border: 1.5px solid #e5e7eb; }
    .btn-secondary:hover { background: #f9fafb; }

    .steps { margin-bottom: 20px; }
    .steps li {
        font-size: 0.85rem; color: #6b7280;
        margin-bottom: 6px; list-style: none;
        padding-left: 20px; position: relative;
    }
    .steps li::before {
        content: '';
        position: absolute; left: 0; top: 6px;
        width: 6px; height: 6px; border-radius: 50%;
        background: #a16207;
    }

    .actions { display: flex; gap: 10px; }

    @media (max-width: 768px) {
        .import-card { padding: 20px; border-radius: 12px; }
        .actions { flex-direction: column; }
        .actions .btn { text-align: center; }
    }
</style>

<div class="import-card">
    <div class="icon">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
    </div>
    <h3>Excel yuklash</h3>
    <p>Fayl quyidagi ustunlardan iborat bo'lishi kerak:</p>

    <ul class="steps">
        <li><strong>f_i_sh</strong> — O'quvchining F.I.SH</li>
        <li><strong>telefon</strong> — Telefon raqami</li>
        <li><strong>manzil</strong> — Yashash manzili (ixtiyoriy)</li>
        <li>Fayl formati: <strong>.xlsx, .xls, .csv</strong></li>
    </ul>

    <form method="POST" action="/students/import" enctype="multipart/form-data">
        @csrf
        <div class="field">
            <label for="file">Faylni tanlang</label>
            <input id="file" type="file" name="file" accept=".xlsx,.xls,.csv" required>
            @error('file')<div style="margin-top:4px;font-size:0.8rem;color:#dc2626;">{{ $message }}</div>@enderror
            <div class="hint">Faqat .xlsx, .xls yoki .csv fayllar qabul qilinadi</div>
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">Import qilish</button>
            <a href="/students" class="btn btn-secondary">Bekor qilish</a>
        </div>
    </form>
</div>
@endsection
