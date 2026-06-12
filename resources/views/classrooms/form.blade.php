@extends('layouts.admin')

@section('title', isset($classroom) ? "Guruhni tahrirlash" : 'Yangi guruh')
@section('heading', isset($classroom) ? "Guruhni tahrirlash" : 'Yangi guruh')

@section('content')
<style>
    .form-card { max-width: 520px; background: #fff; border-radius: 16px; padding: 32px; box-shadow: 0 1px 6px rgba(0,0,0,0.04); }
    .field { margin-bottom: 18px; }
    .field label { display: block; margin-bottom: 6px; font-size: 0.8rem; font-weight: 600; color: #374151; }
    .field input { width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.9rem; color: #111827; background: #fff; outline: none; font-family: inherit; transition: border-color 0.2s, box-shadow 0.2s; }
    .field input:focus { border-color: #a16207; box-shadow: 0 0 0 3px rgba(161,98,7,0.1); }
    .field .error { margin-top: 4px; font-size: 0.8rem; color: #dc2626; }
    .actions { display: flex; gap: 10px; margin-top: 24px; }
    .btn { padding: 10px 20px; border: none; border-radius: 10px; font-size: 0.85rem; font-weight: 600; cursor: pointer; text-decoration: none; font-family: inherit; transition: background 0.15s, transform 0.1s; }
    .btn-primary { background: #a16207; color: #fff; }
    .btn-primary:hover { background: #854d0e; transform: translateY(-1px); }
    .btn-secondary { background: #fff; color: #374151; border: 1.5px solid #e5e7eb; }
    .btn-secondary:hover { background: #fefce8; border-color: #a16207; }
    @media (max-width: 768px) { .form-card { padding: 20px; } .actions { flex-direction: column; } .actions .btn { text-align: center; } }
</style>

<div class="form-card">
    <form method="POST" action="{{ isset($classroom) ? '/classrooms/'.$classroom->id : '/classrooms' }}">
        @csrf
        @if(isset($classroom)) @method('PUT') @endif

        <div class="field">
            <label for="name">Guruh nomi</label>
            <input id="name" name="name" value="{{ old('name', $classroom->name ?? '') }}" placeholder="Masalan: 5-A guruh" required>
            @error('name')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="room_number">Xona raqami</label>
            <input id="room_number" name="room_number" value="{{ old('room_number', $classroom->room_number ?? '') }}" placeholder="Masalan: 201">
            @error('room_number')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">{{ isset($classroom) ? 'Saqlash' : 'Qo\'shish' }}</button>
            <a href="/classrooms" class="btn btn-secondary">Bekor qilish</a>
        </div>
    </form>
</div>
@endsection
