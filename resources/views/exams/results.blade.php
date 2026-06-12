@extends('layouts.admin')

@section('title', $exam->name . ' — Natijalar')
@section('heading', $exam->name . ' — Natijalar')

@section('content')
<style>
    .info-card { background:#fff; border-radius:16px; padding:20px; box-shadow:0 1px 6px rgba(0,0,0,.04); margin-bottom:20px; display:flex; gap:24px; flex-wrap:wrap; }
    .info-card .item { font-size:.85rem; }
    .info-card .item .label { color:#9ca3af; font-size:.75rem; }
    .info-card .item .value { font-weight:600; color:#374151; }

    .field { margin-bottom:18px; }
    .field label { display:block; margin-bottom:6px; font-size:.8rem; font-weight:600; color:#374151; }
    .field input { width:70px; padding:8px 10px; border:1.5px solid #e5e7eb; border-radius:8px; font-size:.9rem; color:#111827; background:#fff; outline:none; font-family:inherit; text-align:center; transition:border-color .2s; }
    .field input:focus { border-color:#a16207; box-shadow:0 0 0 3px rgba(161,98,7,.1); }
    .field input.has-score { border-color:#166534; background:#f0fdf4; }

    .table-wrap { background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 1px 6px rgba(0,0,0,.04); margin-bottom:20px; }
    table { width:100%; border-collapse:collapse; }
    th { text-align:left; padding:12px 16px; font-size:.75rem; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:.05em; background:#fefce8; border-bottom:1px solid #e5e7eb; }
    td { padding:12px 16px; font-size:.85rem; color:#374151; border-bottom:1px solid #f3f4f6; }
    tr:last-child td { border-bottom:none; }
    tr:hover td { background:#fffbeb; }

    .btn { padding:10px 18px; border:none; border-radius:10px; font-size:.85rem; font-weight:600; cursor:pointer; text-decoration:none; font-family:inherit; transition:background .15s,transform .1s; }
    .btn-primary { background:#a16207; color:#fff; }
    .btn-primary:hover { background:#854d0e; transform:translateY(-1px); }
    .btn-secondary { background:#fff; color:#374151; border:1.5px solid #e5e7eb; display:inline-flex; align-items:center; gap:6px; }
    .btn-secondary:hover { background:#fefce8; border-color:#a16207; }
</style>

<div class="info-card">
    <div class="item"><div class="label">Guruh</div><div class="value">{{ $exam->classroom->name }}</div></div>
    <div class="item"><div class="label">Fan</div><div class="value">{{ $exam->subject->name }}</div></div>
    <div class="item"><div class="label">Sana</div><div class="value">{{ $exam->exam_date->format('d.m.Y') }}</div></div>
    <div class="item"><div class="label">Maks ball</div><div class="value">{{ $exam->max_score }}</div></div>
</div>

<form method="POST" action="/exams/{{ $exam->id }}/results">
    @csrf

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>O'quvchi</th>
                    <th>Ball (maks: {{ $exam->max_score }})</th>
                </tr>
            </thead>
            <tbody>
                @forelse($enrollments as $i => $enrollment)
                @php
                    $result = $exam->results->firstWhere('enrollment_id', $enrollment->id);
                @endphp
                <tr>
                    <td style="color:#9ca3af;">{{ $i + 1 }}</td>
                    <td style="font-weight:500;">{{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}</td>
                    <td>
                        <div class="field" style="margin-bottom:0;">
                            <input type="number" name="scores[{{ $enrollment->id }}]" value="{{ old('scores.'.$enrollment->id, $result->score ?? '') }}" min="0" max="{{ $exam->max_score }}" placeholder="-" class="{{ $result ? 'has-score' : '' }}" oninput="this.classList.toggle('has-score', this.value !== '')">
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;padding:32px;color:#9ca3af;">Bu guruhda o'quvchilar yo'q</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="display:flex;gap:10px;">
        <button type="submit" class="btn btn-primary">Saqlash</button>
        <a href="/exams" class="btn btn-secondary">Ortga</a>
    </div>
</form>
@endsection
