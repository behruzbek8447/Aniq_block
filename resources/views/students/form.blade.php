@extends('layouts.admin')

@section('title', $student->id ? "O'quvchini tahrirlash" : 'Yangi o\'quvchi')
@section('heading', $student->id ? "O'quvchini tahrirlash" : 'Yangi o\'quvchi')

@section('content')
<style>
    .form-card {
        max-width: 520px;
        background: #fff;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.04);
    }
    .field { margin-bottom: 18px; }
    .field label {
        display: block; margin-bottom: 6px;
        font-size: 0.8rem; font-weight: 600; color: #374151;
    }
    .field input, .field textarea {
        width: 100%; padding: 10px 14px;
        border: 1.5px solid #e5e7eb; border-radius: 10px;
        font-size: 0.9rem; color: #111827;
        background: #fff; outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        font-family: inherit;
    }
    .field input:focus, .field textarea:focus {
        border-color: #a16207;
        box-shadow: 0 0 0 3px rgba(161,98,7,0.1);
    }
    .field textarea { min-height: 80px; resize: vertical; }
    .field .error { margin-top: 4px; font-size: 0.8rem; color: #dc2626; }

    .actions { display: flex; gap: 10px; margin-top: 24px; }
    .btn {
        padding: 10px 20px; border: none; border-radius: 10px;
        font-size: 0.85rem; font-weight: 600; cursor: pointer;
        text-decoration: none; font-family: inherit;
        transition: background 0.15s, transform 0.1s;
    }
    .btn-primary { background: #a16207; color: #fff; }
    .btn-primary:hover { background: #854d0e; transform: translateY(-1px); }
    .btn-secondary { background: #fff; color: #374151; border: 1.5px solid #e5e7eb; }
    .btn-secondary:hover { background: #fefce8; border-color: #a16207; }

    .row { display: flex; gap: 12px; }
    .row .field { flex: 1; }

    @media (max-width: 768px) {
        .form-card { padding: 20px; border-radius: 12px; }
        .actions { flex-direction: column; }
        .actions .btn { text-align: center; }
        .row { flex-direction: column; gap: 0; }
    }
</style>

<div class="form-card">
    <form method="POST" action="{{ $student->id ? '/students/'.$student->id : '/students' }}">
        @csrf
        @if($student->id) @method('PUT') @endif

        <div class="row">
            <div class="field">
                <label for="first_name">Ism</label>
                <input id="first_name" name="first_name" value="{{ old('first_name', $student->first_name ?? '') }}" placeholder="Ism" required>
                @error('first_name')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="last_name">Familiya</label>
                <input id="last_name" name="last_name" value="{{ old('last_name', $student->last_name ?? '') }}" placeholder="Familiya">
                @error('last_name')<div class="error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="field">
            <label for="phone">Telefon raqam</label>
            <input id="phone" name="phone" value="{{ old('phone', $student->phone ? '+998'.$student->phone : '') }}" placeholder="+998901234567" required>
            @error('phone')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="address">Manzil</label>
            <textarea id="address" name="address" placeholder="Yashash manzili">{{ old('address', $student->address ?? '') }}</textarea>
            @error('address')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">{{ isset($student) ? 'Saqlash' : 'Qo\'shish' }}</button>
            <a href="/students" class="btn btn-secondary">Bekor qilish</a>
        </div>
    </form>
</div>
@endsection
