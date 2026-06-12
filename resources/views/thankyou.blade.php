<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muvaffaqiyatli — Turon odob-ilm maktabi</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            font-family: system-ui, -apple-system, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fefce8;
            padding: 20px;
        }

        .card {
            background: #fff;
            border-radius: 24px;
            padding: 52px 44px 44px;
            width: 100%;
            max-width: 480px;
            text-align: center;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
            animation: popIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes popIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .check {
            width: 56px; height: 56px;
            border-radius: 50%;
            background: #166534;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        .check svg { width: 26px; height: 26px; stroke: #fff; stroke-width: 2.5; fill: none; stroke-linecap: round; stroke-linejoin: round; }

        .card h1 { color: #854d0e; font-size: 1.5rem; font-weight: 700; margin-bottom: 10px; }
        .card p { color: #6b7280; font-size: 0.9rem; line-height: 1.6; margin-bottom: 28px; }

        .btn-group { display: flex; flex-direction: column; gap: 10px; }
        .btn-primary {
            display: inline-flex; align-items: center; justify-content: center; gap: 6px;
            padding: 12px 24px; border-radius: 12px; border: none;
            background: #a16207; color: #fff;
            font-size: 0.95rem; font-weight: 600; text-decoration: none;
            transition: background 0.2s, transform 0.15s;
            font-family: inherit;
        }
        .btn-primary:hover { background: #854d0e; transform: translateY(-1px); }
        .btn-secondary {
            display: inline-flex; align-items: center; justify-content: center;
            padding: 11px 24px; border-radius: 12px;
            border: 1.5px solid #e5e7eb; background: #fff;
            color: #374151; font-size: 0.9rem; font-weight: 600; text-decoration: none;
            transition: border-color 0.2s;
            font-family: inherit;
        }
        .btn-secondary:hover { border-color: #a16207; color: #a16207; }

        @media (max-width: 480px) {
            .card { padding: 28px 20px; border-radius: 16px; }
            .card h1 { font-size: 1.2rem; }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="check">
            <svg viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" /></svg>
        </div>
        <h1>Ro'yxatdan o'tish muvaffaqiyatli!</h1>
        <p>Sizning hisobingiz yaratildi. Endi telefon raqam va parol yordamida tizimga kirishingiz mumkin.</p>
        <div class="btn-group">
            <a href="/login" class="btn-primary">Kirish →</a>
            <a href="/" class="btn-secondary">Bosh sahifaga qaytish</a>
        </div>
    </div>
</body>
</html>
