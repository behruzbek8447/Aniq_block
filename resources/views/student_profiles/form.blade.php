@extends('layouts.admin')

@section('title', "O'quvchi profili")
@section('heading', "O'quvchi profili")

@section('content')
<style>
    .form-card { max-width: 520px; background: #fff; border-radius: 16px; padding: 32px; box-shadow: 0 1px 6px rgba(0,0,0,0.04); }
    .field { margin-bottom: 18px; }
    .field label { display: block; margin-bottom: 6px; font-size: 0.8rem; font-weight: 600; color: #374151; }
    .field input, .field textarea { width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.9rem; color: #111827; background: #fff; outline: none; font-family: inherit; transition: border-color 0.2s, box-shadow 0.2s; }
    .field input:focus, .field textarea:focus { border-color: #a16207; box-shadow: 0 0 0 3px rgba(161,98,7,0.1); }
    .field textarea { min-height: 80px; resize: vertical; }
    .field .error { margin-top: 4px; font-size: 0.8rem; color: #dc2626; }
    .field .hint { margin-top: 4px; font-size: 0.75rem; color: #9ca3af; }
    .actions { display: flex; gap: 10px; margin-top: 24px; }
    .btn { padding: 10px 20px; border: none; border-radius: 10px; font-size: 0.85rem; font-weight: 600; cursor: pointer; text-decoration: none; font-family: inherit; transition: background 0.15s, transform 0.1s; }
    .btn-primary { background: #a16207; color: #fff; }
    .btn-primary:hover { background: #854d0e; transform: translateY(-1px); }
    .btn-secondary { background: #fff; color: #374151; border: 1.5px solid #e5e7eb; }
    .btn-secondary:hover { background: #fefce8; border-color: #a16207; }
    .info { padding: 12px 16px; background: #fefce8; border-radius: 10px; margin-bottom: 20px; font-size: 0.85rem; color: #854d0e; border: 1px solid #fde68a; }
    @media (max-width: 768px) { .form-card { padding: 20px; } .actions { flex-direction: column; } }
</style>

<div class="form-card">
    <div class="info">
        <strong>{{ $student->fio ?: trim(($student->first_name ?? '') . ' ' . ($student->last_name ?? '')) }}</strong> — profil ma'lumotlari
    </div>

    <form method="POST" action="/students/{{ $student->id }}/profile">
        @csrf
        @method('PUT')

        <div class="field">
            <label for="birth_date">Tug'ilgan sana</label>
            <input id="birth_date" name="birth_date" type="date" value="{{ old('birth_date', $profile->birth_date ?? '') }}">
            @error('birth_date')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="address">Manzil</label>
            <textarea id="address" name="address" placeholder="Yashash manzili">{{ old('address', $profile->address ?? '') }}</textarea>
            @error('address')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="parent_name">Ota-onaning ismi</label>
            <input id="parent_name" name="parent_name" value="{{ old('parent_name', $profile->parent_name ?? '') }}" placeholder="Ota yoki onaning ismi">
            @error('parent_name')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">Saqlash</button>
            <a href="/students" class="btn btn-secondary">Bekor qilish</a>
        </div>
    </form>
</div>
@endsection
