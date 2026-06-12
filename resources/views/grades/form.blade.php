@extends('layouts.admin')

@section('title', isset($grade) ? "Bahoni tahrirlash" : "Baho qo'shish")
@section('heading', isset($grade) ? "Bahoni tahrirlash" : "Baho qo'shish")

@section('content')
<style>
    .form-card { max-width:520px; background:#fff; border-radius:16px; padding:32px; box-shadow:0 1px 6px rgba(0,0,0,.04); }
    .field { margin-bottom:18px; }
    .field label { display:block; margin-bottom:6px; font-size:.8rem; font-weight:600; color:#374151; }
    .field input, .field select, .field textarea { width:100%; padding:10px 14px; border:1.5px solid #e5e7eb; border-radius:10px; font-size:.9rem; color:#111827; background:#fff; outline:none; font-family:inherit; transition:border-color .2s,box-shadow .2s; }
    .field input:focus, .field select:focus, .field textarea:focus { border-color:#a16207; box-shadow:0 0 0 3px rgba(161,98,7,.1); }
    .field textarea { min-height:60px; resize:vertical; }
    .field .error { margin-top:4px; font-size:.8rem; color:#dc2626; }
    .row { display:flex; gap:12px; }
    .row .field { flex:1; }
    .actions { display:flex; gap:10px; margin-top:24px; }
    .btn { padding:10px 20px; border:none; border-radius:10px; font-size:.85rem; font-weight:600; cursor:pointer; text-decoration:none; font-family:inherit; transition:background .15s,transform .1s; }
    .btn-primary { background:#a16207; color:#fff; }
    .btn-primary:hover { background:#854d0e; transform:translateY(-1px); }
    .btn-secondary { background:#fff; color:#374151; border:1.5px solid #e5e7eb; }
    .btn-secondary:hover { background:#fefce8; border-color:#a16207; }
    @media(max-width:768px){ .form-card{padding:20px} .row{flex-direction:column;gap:0} .actions{flex-direction:column} }
</style>

<div class="form-card">
    <form method="POST" action="{{ isset($grade) ? '/grades/'.$grade->id : '/grades' }}">
        @csrf
        @if(isset($grade)) @method('PUT') @endif

        <div class="field">
            <label for="enrollment_id">O'quvchi (guruh)</label>
            <select id="enrollment_id" name="enrollment_id" required>
                <option value="">— Tanlang —</option>
                @foreach($enrollments as $e)
                <option value="{{ $e->id }}" {{ old('enrollment_id', $grade->enrollment_id ?? '') == $e->id ? 'selected' : '' }}>
                    {{ $e->student->first_name }} {{ $e->student->last_name }} ({{ $e->classroom->name }})
                </option>
                @endforeach
            </select>
            @error('enrollment_id')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="subject_id">Fan</label>
            <select id="subject_id" name="subject_id" required>
                <option value="">— Fan tanlang —</option>
                @foreach($subjects as $s)
                <option value="{{ $s->id }}" {{ old('subject_id', $grade->subject_id ?? '') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                @endforeach
            </select>
            @error('subject_id')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="row">
            <div class="field">
                <label for="grade">Baho (1-5)</label>
                <select id="grade" name="grade" required>
                    <option value="">— Baho —</option>
                    @for($g = 1; $g <= 5; $g++)
                    <option value="{{ $g }}" {{ old('grade', $grade->grade ?? '') == $g ? 'selected' : '' }}>{{ $g }}</option>
                    @endfor
                </select>
                @error('grade')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="graded_at">Sana</label>
                <input id="graded_at" name="graded_at" type="date" value="{{ old('graded_at', $grade->graded_at ?? today()->format('Y-m-d')) }}" required>
                @error('graded_at')<div class="error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="field">
            <label for="notes">Izoh</label>
            <textarea id="notes" name="notes" placeholder="Qo'shimcha ma'lumot">{{ old('notes', $grade->notes ?? '') }}</textarea>
            @error('notes')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">{{ isset($grade) ? 'Saqlash' : 'Qo\'shish' }}</button>
            <a href="/grades" class="btn btn-secondary">Bekor qilish</a>
        </div>
    </form>
</div>
@endsection
