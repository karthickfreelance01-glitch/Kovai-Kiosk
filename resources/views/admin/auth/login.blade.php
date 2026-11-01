<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Pathy Display Racks</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
    :root {
        --brand-green: #8DC63F;
        --brand-green-dark: #76A82F;
        --brand-green-light: #EEF7DD;
        --brand-grey: #757575;
        --brand-grey-dark: #4A4A4A;
        --brand-grey-light: #F4F4F4;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
        font-family: 'Inter', sans-serif;
        background: #F7F8F5;
        min-height: 100vh; display: flex; align-items: center; justify-content: center;
        padding: 24px; position: relative;
    }
    .login-card {
        background: #FFFFFF;
        border: 1px solid #E5E7EB;
        border-radius: 20px;
        padding: 44px 38px;
        width: 100%; max-width: 440px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        text-align: center;
    }
    .login-logo {
        display: inline-block;
        margin-bottom: 24px;
        background: #FFFFFF;
        padding: 8px 16px;
        border-radius: 12px;
        border: 1px solid #EEF7DD;
    }
    .login-logo img {
        height: 48px;
        width: auto;
        display: block;
    }
    .login-title {
        font-family: 'Poppins', sans-serif;
        font-size: 1.5rem; font-weight: 700; color: var(--brand-grey-dark);
        margin-bottom: 6px;
    }
    .login-sub {
        color: var(--brand-grey);
        font-size: 0.88rem; margin-bottom: 28px;
    }
    .form-group { margin-bottom: 18px; text-align: left; }
    .form-label {
        display: block; margin-bottom: 6px;
        font-family: 'Poppins', sans-serif; font-size: 0.78rem;
        font-weight: 600; letter-spacing: 0.5px; color: var(--brand-grey-dark);
        text-transform: uppercase;
    }
    .form-control {
        width: 100%; padding: 12px 16px;
        background: #FFFFFF; border: 1.5px solid #E2E8F0;
        border-radius: 12px; color: #1E293B; font-size: 0.92rem;
        font-family: 'Inter', sans-serif; outline: none; transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus {
        border-color: var(--brand-green);
        box-shadow: 0 0 0 3px rgba(141,198,63,0.2);
    }
    .form-control::placeholder { color: #94A3B8; }
    .form-error { color: #DC2626; font-size: 0.78rem; margin-top: 5px; }
    .btn-login {
        width: 100%; padding: 13px 20px;
        background: var(--brand-green);
        color: #FFFFFF; border: none; border-radius: 50px;
        font-family: 'Poppins', sans-serif; font-size: 0.95rem; font-weight: 700;
        cursor: pointer; transition: all 0.25s; margin-top: 10px;
        box-shadow: 0 4px 14px rgba(141,198,63,0.3);
    }
    .btn-login:hover {
        background: var(--brand-green-dark);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(118,168,47,0.35);
    }
    .flash-error {
        background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.25);
        color: #DC2626; padding: 12px 16px; border-radius: 10px;
        font-size: 0.85rem; margin-bottom: 20px; text-align: left;
        display: flex; align-items: center; gap: 8px;
    }
    .remember-row { display: flex; align-items: center; gap: 8px; margin: 8px 0 16px; text-align: left; }
    .remember-row label { font-size: 0.85rem; color: var(--brand-grey); cursor: pointer; }
    .back-link { text-align: center; margin-top: 24px; font-size: 0.85rem; color: var(--brand-grey); }
    .back-link a { color: var(--brand-green-dark); font-weight: 600; text-decoration: none; }
    .back-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="login-card">
        <a href="{{ route('home') }}" class="login-logo">
            <img src="{{ asset('images/pdr-logo.png') }}" alt="Pathy Display Racks">
        </a>
        <h1 class="login-title">Admin Login</h1>
        <p class="login-sub">Sign in to manage catalog, enquiries, and settings</p>

        @if($errors->any())
        <div class="flash-error">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ $errors->first() }}
        </div>
        @endif

        @if(session('success'))
        <div style="background:rgba(141,198,63,0.12);border:1px solid rgba(141,198,63,0.3);color:var(--brand-green-dark);padding:12px 16px;border-radius:10px;font-size:0.85rem;margin-bottom:20px;display:flex;align-items:center;gap:8px;text-align:left;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST" id="admin-login-form">
            @csrf
            <div class="form-group">
                <label class="form-label" for="login-email">Email Address</label>
                <input type="email" id="login-email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="admin@pathykiosk.in">
            </div>
            <div class="form-group">
                <label class="form-label" for="login-password">Password</label>
                <input type="password" id="login-password" name="password" class="form-control" required placeholder="••••••••">
            </div>
            <div class="remember-row">
                <input type="checkbox" id="remember" name="remember" style="accent-color:var(--brand-green)">
                <label for="remember">Remember me</label>
            </div>
            <button type="submit" class="btn-login" id="login-submit-btn">Sign In to Dashboard</button>
        </form>

        <div class="back-link">
            <a href="{{ route('home') }}">← Back to Website</a>
        </div>
    </div>
</body>
</html>
