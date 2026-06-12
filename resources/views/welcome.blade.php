<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ro'yxatdan o'tish — Turon odob-ilm maktabi</title>
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

        .form-card {
            background: #fff;
            border-radius: 24px;
            padding: 44px 40px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
            animation: fadeUp 0.5s ease-out;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .intro { text-align: center; margin-bottom: 28px; }
        .intro .icon {
            display: inline-flex; align-items: center; justify-content: center;
            width: 52px; height: 52px;
            border-radius: 14px;
            background: #166534;
            color: #fff;
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 12px;
        }
        .intro h2 { color: #854d0e; font-size: 1.35rem; font-weight: 700; }
        .intro p { color: #6b7280; font-size: 0.85rem; margin-top: 4px; }

        .message {
            margin-bottom: 20px;
            padding: 12px 16px;
            border-radius: 12px;
            background: #fefce8;
            color: #a16207;
            border: 1px solid #fde68a;
            font-size: 0.85rem;
            animation: slideDown 0.3s ease-out;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .field { margin-bottom: 18px; }
        .field label {
            display: block; margin-bottom: 6px;
            font-size: 0.8rem; font-weight: 600; color: #374151;
        }
        .field input {
            width: 100%; padding: 12px 16px;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.95rem; color: #111827;
            background: #fff;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-family: inherit;
        }
        .field input:focus {
            border-color: #a16207;
            box-shadow: 0 0 0 3px rgba(161,98,7,0.1);
        }
        .field .error { margin-top: 6px; font-size: 0.8rem; color: #dc2626; }

        .btn-primary {
            width: 100%; padding: 12px 20px;
            border: none; border-radius: 12px;
            background: #a16207;
            color: #fff;
            font-size: 0.95rem; font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s;
            font-family: inherit;
        }
        .btn-primary:hover { background: #854d0e; transform: translateY(-1px); }
        .btn-primary:active { transform: translateY(0); }

        .meta { margin-top: 24px; text-align: center; color: #6b7280; font-size: 0.85rem; }
        .meta a { color: #166534; font-weight: 700; text-decoration: none; }
        .meta a:hover { text-decoration: underline; }

        @media (max-width: 480px) {
            .form-card { padding: 28px 20px; border-radius: 16px; }
            .intro h2 { font-size: 1.15rem; }
        }
    </style>
</head>
<body>
    <div class="form-card">
        <div class="intro">
            <div class="icon">T</div>
            <h2>Turon odob-ilm maktabi</h2>
            <p>Hisob yaratish uchun ma'lumotlaringizni kiriting</p>
        </div>

        @if(session('status'))
            <div class="message">{{ session('status') }}</div>
        @endif

        <form method="POST" action="/register">
            @csrf
            <div class="field">
                <label for="name">Ism</label>
                <input id="name" name="name" value="{{ old('name') }}" placeholder="Ismingiz" required autofocus>
                @error('name')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="phone">Telefon raqam</label>
                <div style="display:flex;border:1.5px solid #e5e7eb;border-radius:10px;overflow:hidden;">
                    <span style="padding:10px 0 10px 14px;background:#f3f4f6;color:#6b7280;font-weight:600;font-size:0.9rem;border-right:1px solid #e5e7eb;">+998</span>
                    <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" placeholder="901234567" required autofocus style="flex:1;border:none;outline:none;padding:10px 14px;font-size:0.9rem;font-family:inherit;">
                </div>
                @error('phone')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="password">Parol</label>
                <input id="password" name="password" type="password" placeholder="Parol" required>
                @error('password')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="password_confirmation">Parolni tasdiqlang</label>
                <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Parolni takrorlang" required>
            </div>
            <button type="submit" class="btn-primary">Ro'yxatdan o'tish</button>
        </form>

        <p class="meta">Hisobingiz bormi? <a href="/login">Kirish</a></p>
    </div>
</body>
</html>
