<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Thesis Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            color: #1a1a2e;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .login-wrap { width: 100%; max-width: 420px; }
        .login-header { text-align: center; margin-bottom: 24px; }
        .login-header .logo-wrap {
            width: 52px; height: 52px;
            background: #185FA5;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 14px;
        }
        .login-header .logo-wrap i { font-size: 26px; color: #fff; }
        .login-header h1 { font-size: 18px; font-weight: 500; color: #1a1a2e; }
        .login-header p { font-size: 13px; color: #6b7280; margin-top: 4px; }
        .card {
            background: #fff;
            border: 0.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 28px;
        }
        .form-group { margin-bottom: 16px; }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #1a1a2e;
            margin-bottom: 6px;
        }
        .input-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 9px 12px;
            border: 0.5px solid #d1d5db;
            border-radius: 8px;
            background: #fff;
        }
        .input-wrap:focus-within { border-color: #185FA5; }
        .input-wrap i { font-size: 16px; color: #9ca3af; flex-shrink: 0; }
        .input-wrap input {
            border: none;
            outline: none;
            font-size: 13px;
            font-family: inherit;
            color: #1a1a2e;
            width: 100%;
            background: transparent;
        }
        .btn-primary {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 18px;
            background: #185FA5;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
            font-weight: 500;
            margin-top: 8px;
        }
        .btn-primary:hover { background: #0C447C; }
        .alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 16px;
            border: 0.5px solid;
        }
        .alert-danger { background: #FCEBEB; border-color: #F09595; color: #791F1F; }
        .footer-note {
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            margin-top: 20px;
        }
        .login-link {
            text-align: center;
            font-size: 13px;
            margin-top: 16px;
        }
        .login-link a { color: #185FA5; text-decoration: none; font-weight: 500; }
        .login-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="login-wrap">
        <div class="login-header">
            <div class="logo-wrap">
                <i class="ti ti-school"></i>
            </div>
            <h1>Create Account</h1>
            <p>Register a new account for Thesis Management System</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="ti ti-alert-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <div class="card">
            <form action="{{ route('register') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <div class="input-wrap">
                        <i class="ti ti-user"></i>
                        <input type="text" id="name" name="name" placeholder="John Doe" value="{{ old('name') }}" required autocomplete="name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrap">
                        <i class="ti ti-mail"></i>
                        <input type="email" id="email" name="email" placeholder="you@example.com" value="{{ old('email') }}" required autocomplete="email">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <i class="ti ti-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Min. 8 characters" required autocomplete="new-password">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <div class="input-wrap">
                        <i class="ti ti-lock"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repeat password" required autocomplete="new-password">
                    </div>
                </div>

                <button type="submit" class="btn-primary">
                    <i class="ti ti-user-plus"></i> Register
                </button>
            </form>
        </div>

        <div class="login-link">
            Already have an account? <a href="{{ route('login') }}">Log in</a>
        </div>

        <p class="footer-note">Universitas Ahmad Dahlan &mdash; Academic System</p>
    </div>
</body>
</html>
