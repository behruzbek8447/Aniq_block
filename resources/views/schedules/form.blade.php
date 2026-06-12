@extends('layouts.admin')

@section('title', isset($schedule) ? "Darsni tahrirlash" : "Dars qo'shish")
@section('heading', isset($schedule) ? "Darsni tahrirlash" : "Dars qo'shish")

@section('content')
<style>
    .form-card { max-width: 520px; background: #fff; border-radius: 16px; padding: 32px; box-shadow: 0 1px 6px rgba(0,0,0,0.04); }
    .field { margin-bottom: 18px; }
    .field label { display: block; margin-bottom: 6px; font-size: 0.8rem; font-weight: 600; color: #374151; }
    .field input, .field select { width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.9rem; color: #111827; background: #fff; outline: none; font-family: inherit; transition: border-color 0.2s, box-shadow 0.2s; }
    .field input:focus, .field select:focus { border-color: #a16207; box-shadow: 0 0 0 3px rgba(161,98,7,0.1); }
    .field .error { margin-top: 4px; font-size: 0.8rem; color: #dc2626; }
    .row { display: flex; gap: 12px; }
    .row .field { flex: 1; }
    .actions { display: flex; gap: 10px; margin-top: 24px; }
    .btn { padding: 10px 20px; border: none; border-radius: 10px; font-size: 0.85rem; font-weight: 600; cursor: pointer; text-decoration: none; font-family: inherit; transition: background 0.15s, transform 0.1s; }
    .btn-primary { background: #a16207; color: #fff; }
    .btn-primary:hover { background: #854d0e; transform: translateY(-1px); }
    .btn-secondary { background: #fff; color: #374151; border: 1.5px solid #e5e7eb; }
    .btn-secondary:hover { background: #fefce8; border-color: #a16207; }
    @media (max-width: 768px) { .form-card { padding: 20px; } .row { flex-direction: column; gap: 0; } .actions { flex-direction: column; } }
</style>

<div class="form-card">
    <form method="POST" action="{{ isset($schedule) ? '/schedules/'.$schedule->id : '/schedules' }}">
        @csrf
        @if(isset($schedule)) @method('PUT') @endif

        <div class="field">
            <label for="classroom_id">Guruh</label>
            <select id="classroom_id" name="classroom_id" required>
                <option value="">— Guruhni tanlang —</option>
                @foreach($classrooms as $c)
                <option value="{{ $c->id }}" {{ old('classroom_id', $schedule->classroom_id ?? request('classroom_id')) == $c->id ? 'selected' : '' }}>
                    {{ $c->name }} {{ $c->room_number ? '('.$c->room_number.')' : '' }}
                </option>
                @endforeach
            </select>
            @error('classroom_id')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="day_of_week">Hafta kuni</label>
            <select id="day_of_week" name="day_of_week" required>
                <option value="">— Kunni tanlang —</option>
                @foreach($days as $k => $day)
                    @if($k > 0)
                    <option value="{{ $k }}" {{ old('day_of_week', $schedule->day_of_week ?? '') == $k ? 'selected' : '' }}>{{ $day }}</option>
                    @endif
                @endforeach
            </select>
            @error('day_of_week')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="row">
            <div class="field">
                <label for="start_time">Boshlanish vaqti</label>
                <input id="start_time" name="start_time" type="time" value="{{ old('start_time', $schedule->start_time ?? '') }}" required>
                @error('start_time')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="end_time">Tugash vaqti</label>
                <input id="end_time" name="end_time" type="time" value="{{ old('end_time', $schedule->end_time ?? '') }}" required>
                @error('end_time')<div class="error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="field">
            <label for="subject_name">Fan nomi</label>
            <input id="subject_name" name="subject_name" value="{{ old('subject_name', $schedule->subject_name ?? '') }}" placeholder="Masalan: Matematika" required>
            @error('subject_name')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="teacher_name">O'qituvchi</label>
            <input id="teacher_name" name="teacher_name" value="{{ old('teacher_name', $schedule->teacher_name ?? '') }}" placeholder="O'qituvchi F.I.SH">
            @error('teacher_name')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">{{ isset($schedule) ? 'Saqlash' : 'Qo\'shish' }}</button>
            <a href="/schedules{{ isset($schedule) ? '?classroom_id='.$schedule->classroom_id : (request('classroom_id') ? '?classroom_id='.request('classroom_id') : '') }}" class="btn btn-secondary">Bekor qilish</a>
        </div>
    </form>
</div>
@endsection
