<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Kovai Kiosk</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Outfit:wght@400;500;600;700&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(160deg, #0D1B2A 0%, #161820 50%, #1C1C1E 100%);
        min-height: 100vh; display: flex; align-items: center; justify-content: center;
        position: relative; overflow: hidden;
    }
    body::before {
        content: '';
        position: absolute; inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23C9A84C' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    .login-card {
        background: rgba(30,32,40,0.9);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(201,168,76,0.15);
        border-radius: 20px;
        padding: 48px 40px;
        width: 100%; max-width: 420px;
        position: relative; z-index: 1;
        box-shadow: 0 40px 80px rgba(0,0,0,0.5);
    }
    .login-icon {
        width: 60px; height: 60px;
        background: linear-gradient(135deg, #C9A84C, #9E7B2E);
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 24px;
    }
    .login-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem; font-weight: 700; color: white;
        text-align: center; margin-bottom: 8px;
    }
    .login-sub {
        text-align: center; color: rgba(255,255,255,0.45);
        font-size: 0.85rem; margin-bottom: 36px;
        font-family: 'Outfit', sans-serif;
    }
    .form-group { margin-bottom: 18px; }
    .form-label {
        display: block; margin-bottom: 6px;
        font-family: 'Outfit', sans-serif; font-size: 0.78rem;
        font-weight: 600; letter-spacing: 0.5px; color: rgba(255,255,255,0.55);
        text-transform: uppercase;
    }
    .form-control {
        width: 100%; padding: 12px 16px;
        background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
        border-radius: 10px; color: white; font-size: 0.9rem;
        font-family: 'Inter', sans-serif; outline: none; transition: border-color 0.2s;
    }
    .form-control:focus { border-color: #C9A84C; }
    .form-control::placeholder { color: rgba(255,255,255,0.25); }
    .form-error { color: #FCA5A5; font-size: 0.78rem; margin-top: 5px; }
    .btn-login {
        width: 100%; padding: 14px;
        background: linear-gradient(135deg, #C9A84C, #9E7B2E);
        color: white; border: none; border-radius: 10px;
        font-family: 'Outfit', sans-serif; font-size: 0.95rem; font-weight: 700;
        cursor: pointer; transition: all 0.25s; margin-top: 8px;
    }
    .btn-login:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(201,168,76,0.35); }
    .flash-error {
        background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.3);
        color: #FCA5A5; padding: 12px 16px; border-radius: 8px;
        font-size: 0.85rem; margin-bottom: 20px;
        display: flex; align-items: center; gap: 8px;
    }
    .remember-row { display: flex; align-items: center; gap: 8px; margin: 4px 0; }
    .remember-row label { font-size: 0.85rem; color: rgba(255,255,255,0.5); cursor: pointer; font-family: 'Outfit', sans-serif; }
    .back-link { text-align: center; margin-top: 24px; font-size: 0.82rem; color: rgba(255,255,255,0.4); }
    .back-link a { color: #C9A84C; }
    .back-link a:hover { color: #E8C96D; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><rect x="3" y="3" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
        </div>
        <h1 class="login-title">Admin Login</h1>
        <p class="login-sub">Kovai Kiosk Management Panel</p>

        @if($errors->any())
        <div class="flash-error">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ $errors->first() }}
        </div>
        @endif

        @if(session('success'))
        <div style="background:rgba(16,185,129,0.12);border:1px solid rgba(16,185,129,0.3);color:#6EE7B7;padding:12px 16px;border-radius:8px;font-size:0.85rem;margin-bottom:20px;display:flex;align-items:center;gap:8px">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST" id="admin-login-form">
            @csrf
            <div class="form-group">
                <label class="form-label" for="login-email">Email Address</label>
                <input type="email" id="login-email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="admin@kovaikiok.com">
            </div>
            <div class="form-group">
                <label class="form-label" for="login-password">Password</label>
                <input type="password" id="login-password" name="password" class="form-control" required placeholder="••••••••">
            </div>
            <div class="remember-row">
                <input type="checkbox" id="remember" name="remember" style="accent-color:#C9A84C">
                <label for="remember">Remember me</label>
            </div>
            <button type="submit" class="btn-login" id="login-submit-btn">Sign In to Admin Panel</button>
        </form>

        <div class="back-link">
            <a href="{{ route('home') }}">← Back to Website</a>
        </div>
    </div>
</body>
</html>
