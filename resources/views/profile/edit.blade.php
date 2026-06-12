@extends('layouts.admin')

@section('title', "Profil")
@section('heading', "Profil")

@section('content')
<style>
    .form-card {
        max-width: 480px;
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
    .field input {
        width: 100%; padding: 10px 14px;
        border: 1.5px solid #e5e7eb; border-radius: 10px;
        font-size: 0.9rem; color: #111827;
        background: #fff; outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        font-family: inherit;
    }
    .field input:focus {
        border-color: #a16207;
        box-shadow: 0 0 0 3px rgba(161,98,7,0.1);
    }
    .field .error { margin-top: 4px; font-size: 0.8rem; color: #dc2626; }
    .field .hint { margin-top: 4px; font-size: 0.75rem; color: #9ca3af; }

    .btn {
        padding: 10px 20px; border: none; border-radius: 10px;
        font-size: 0.85rem; font-weight: 600; cursor: pointer;
        font-family: inherit;
        transition: background 0.15s, transform 0.1s;
    }
    .btn-primary { background: #a16207; color: #fff; }
    .btn-primary:hover { background: #854d0e; transform: translateY(-1px); }

    @media (max-width: 768px) {
        .form-card { padding: 20px; border-radius: 12px; }
    }

    .info-box {
        background: #fefce8;
        border: 1px solid #fde68a;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 20px;
        font-size: 0.85rem;
        color: #854d0e;
    }
    .info-box strong { display: block; margin-bottom: 4px; }

    hr { border: none; border-top: 1px solid #e5e7eb; margin: 20px 0; }
</style>

<div class="form-card">
    <div class="info-box">
        <strong>{{ auth()->user()->name }}</strong>
        Rol: {{ auth()->user()->role === 'super_admin' ? 'Super admin' : 'Admin' }}
    </div>

    <form method="POST" action="/profile">
        @csrf
        @method('PUT')

        <div class="field">
            <label for="name">Ism</label>
            <input id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
            @error('name')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="phone">Telefon</label>
            <input id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required>
            @error('phone')<div class="error">{{ $message }}</div>@enderror
        </div>

        <hr>

        <div class="field">
            <label for="current_password">Joriy parol</label>
            <input id="current_password" name="current_password" type="password" placeholder="Joriy parolingiz" required>
            @error('current_password')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="new_password">Yangi parol (ixtiyoriy)</label>
            <input id="new_password" name="new_password" type="password" placeholder="Agar o'zgartirmoqchi bo'lsangiz">
            <div class="hint">Kamida 8 belgidan iborat bo'lishi kerak</div>
        </div>

        <div class="field">
            <label for="new_password_confirmation">Yangi parolni tasdiqlang</label>
            <input id="new_password_confirmation" name="new_password_confirmation" type="password" placeholder="Yangi parolni takrorlang">
        </div>

        <button type="submit" class="btn btn-primary">Saqlash</button>
    </form>
</div>
@endsection
