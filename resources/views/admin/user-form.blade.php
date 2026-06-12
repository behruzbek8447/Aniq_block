@extends('layouts.admin')

@section('title', 'Yangi admin')
@section('heading', 'Yangi admin')

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
    .field input, .field select {
        width: 100%; padding: 10px 14px;
        border: 1.5px solid #e5e7eb; border-radius: 10px;
        font-size: 0.9rem; color: #111827;
        background: #fff; outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        font-family: inherit;
    }
    .field input:focus, .field select:focus {
        border-color: #a16207;
        box-shadow: 0 0 0 3px rgba(161,98,7,0.1);
    }
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
</style>

<div class="form-card">
    <form method="POST" action="/admin/users">
        @csrf

        <div class="field">
            <label for="name">Ism</label>
            <input id="name" name="name" value="{{ old('name') }}" placeholder="Admin ismi" required autofocus>
            @error('name')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="phone">Telefon raqam</label>
            <div style="display:flex;border:1.5px solid #e5e7eb;border-radius:10px;overflow:hidden;">
                <span style="padding:10px 0 10px 14px;background:#f3f4f6;color:#6b7280;font-weight:600;font-size:0.9rem;border-right:1px solid #e5e7eb;">+998</span>
                <input id="phone" name="phone" value="{{ old('phone') }}" placeholder="901234567" required style="flex:1;border:none;outline:none;padding:10px 14px;font-size:0.9rem;font-family:inherit;">
            </div>
            @error('phone')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="role">Rol</label>
            <select id="role" name="role">
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>Super admin</option>
            </select>
            @error('role')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="password">Parol</label>
            <input id="password" name="password" type="password" placeholder="Kamida 8 belgi" required>
            @error('password')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="password_confirmation">Parolni tasdiqlang</label>
            <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Parolni takrorlang" required>
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">Yaratish</button>
            <a href="/admin/users" class="btn btn-secondary">Bekor qilish</a>
        </div>
    </form>
</div>
@endsection
