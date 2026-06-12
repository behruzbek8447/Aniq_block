@extends('layouts.admin')

@section('title', isset($exam) ? "Imtihonni tahrirlash" : "Yangi imtihon")
@section('heading', isset($exam) ? "Imtihonni tahrirlash" : "Yangi imtihon")

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
    <form method="POST" action="{{ isset($exam) ? '/exams/'.$exam->id : '/exams' }}">
        @csrf
        @if(isset($exam)) @method('PUT') @endif

        <div class="row">
            <div class="field">
                <label for="classroom_id">Guruh</label>
                <select id="classroom_id" name="classroom_id" required>
                    <option value="">— Tanlang —</option>
                    @foreach($classrooms as $c)
                    <option value="{{ $c->id }}" {{ old('classroom_id', $exam->classroom_id ?? '') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
                @error('classroom_id')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="subject_id">Fan</label>
                <select id="subject_id" name="subject_id" required>
                    <option value="">— Tanlang —</option>
                    @foreach($subjects as $s)
                    <option value="{{ $s->id }}" {{ old('subject_id', $exam->subject_id ?? '') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                    @endforeach
                </select>
                @error('subject_id')<div class="error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="field">
            <label for="name">Imtihon nomi</label>
            <input id="name" name="name" value="{{ old('name', $exam->name ?? '') }}" placeholder="Masalan: 1-chorak yakuniy" required>
            @error('name')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="row">
            <div class="field">
                <label for="exam_date">Sana</label>
                <input id="exam_date" name="exam_date" type="date" value="{{ old('exam_date', $exam->exam_date ?? today()->format('Y-m-d')) }}" required>
                @error('exam_date')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="max_score">Maksimal ball</label>
                <input id="max_score" name="max_score" type="number" value="{{ old('max_score', $exam->max_score ?? 100) }}" min="1" required>
                @error('max_score')<div class="error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="field">
            <label for="notes">Izoh</label>
            <textarea id="notes" name="notes" placeholder="Qo'shimcha ma'lumot">{{ old('notes', $exam->notes ?? '') }}</textarea>
            @error('notes')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">{{ isset($exam) ? 'Saqlash' : 'Qo\'shish' }}</button>
            <a href="/exams" class="btn btn-secondary">Bekor qilish</a>
        </div>
    </form>
</div>
@endsection
