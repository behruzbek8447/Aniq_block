@extends('layouts.admin')

@section('title', "O'quvchini guruhga biriktirish")
@section('heading', "O'quvchini guruhga biriktirish")

@section('content')
<style>
    .form-card { max-width: 520px; background: #fff; border-radius: 16px; padding: 32px; box-shadow: 0 1px 6px rgba(0,0,0,0.04); }
    .field { margin-bottom: 18px; }
    .field label { display: block; margin-bottom: 6px; font-size: 0.8rem; font-weight: 600; color: #374151; }
    .field select { width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.9rem; color: #111827; background: #fff; outline: none; font-family: inherit; transition: border-color 0.2s, box-shadow 0.2s; }
    .field select:focus { border-color: #a16207; box-shadow: 0 0 0 3px rgba(161,98,7,0.1); }
    .field .error { margin-top: 4px; font-size: 0.8rem; color: #dc2626; }
    .actions { display: flex; gap: 10px; margin-top: 24px; }
    .btn { padding: 10px 20px; border: none; border-radius: 10px; font-size: 0.85rem; font-weight: 600; cursor: pointer; text-decoration: none; font-family: inherit; transition: background 0.15s, transform 0.1s; }
    .btn-primary { background: #a16207; color: #fff; }
    .btn-primary:hover { background: #854d0e; transform: translateY(-1px); }
    .btn-secondary { background: #fff; color: #374151; border: 1.5px solid #e5e7eb; }
    .btn-secondary:hover { background: #fefce8; border-color: #a16207; }
    @media (max-width: 768px) { .form-card { padding: 20px; } .actions { flex-direction: column; } }
</style>

<div class="form-card">
    <form method="POST" action="/enrollments">
        @csrf

        <div class="field">
            <label for="student_id">O'quvchi</label>
            <select id="student_id" name="student_id" required>
                <option value="">— O'quvchini tanlang —</option>
                @foreach($students as $s)
                <option value="{{ $s->id }}" {{ old('student_id') == $s->id ? 'selected' : '' }}>
                    {{ $s->fio ?: trim(($s->first_name ?? '') . ' ' . ($s->last_name ?? '')) }} ({{ $s->phone }})
                </option>
                @endforeach
            </select>
            @error('student_id')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="classroom_id">Guruh</label>
            <select id="classroom_id" name="classroom_id" required>
                <option value="">— Guruhni tanlang —</option>
                @foreach($classrooms as $c)
                <option value="{{ $c->id }}" {{ old('classroom_id') == $c->id ? 'selected' : '' }}>
                    {{ $c->name }} {{ $c->room_number ? '('.$c->room_number.')' : '' }}
                </option>
                @endforeach
            </select>
            @error('classroom_id')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">Biriktirish</button>
            <a href="/enrollments" class="btn btn-secondary">Bekor qilish</a>
        </div>
    </form>
</div>
@endsection
