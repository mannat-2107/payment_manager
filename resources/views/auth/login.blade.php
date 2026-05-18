<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In — PayManager</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Plus Jakarta Sans',sans-serif;background:#0a0a0f;color:#e8e8f0;min-height:100vh;display:flex;align-items:center;justify-content:center}
        @keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
        @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}
        @keyframes gradientMove{0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%}}
        @keyframes pulse{0%,100%{opacity:1}50%{opacity:0.4}}
        @keyframes glow{0%,100%{box-shadow:0 0 20px rgba(99,102,241,0.3)}50%{box-shadow:0 0 40px rgba(99,102,241,0.6)}}
        .gradient-text{background:linear-gradient(135deg,#6366f1,#8b5cf6,#06b6d4);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;background-size:200%;animation:gradientMove 4s ease infinite}
        .glass{background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);backdrop-filter:blur(20px)}
        .input-field{width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:12px 16px 12px 44px;font-size:14px;color:#e8e8f0;font-family:'Plus Jakarta Sans',sans-serif;transition:all .2s;outline:none}
        .input-field:focus{border-color:rgba(99,102,241,0.6);background:rgba(99,102,241,0.08);box-shadow:0 0 0 3px rgba(99,102,241,0.15)}
        .input-field::placeholder{color:#4b4b6b}
        .input-wrap{position:relative;margin-bottom:16px}
        .input-icon{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#6b6b8a;font-size:16px;pointer-events:none}
        .btn-primary{width:100%;padding:13px;background:linear-gradient(135deg,#6366f1,#8b5cf6);border:none;border-radius:12px;font-size:15px;font-weight:700;color:#fff;cursor:pointer;letter-spacing:-0.2px;transition:all .3s;font-family:'Plus Jakarta Sans',sans-serif}
        .btn-primary:hover{transform:translateY(-1px);box-shadow:0 8px 30px rgba(99,102,241,0.4)}
        .btn-primary:active{transform:translateY(0)}
        .mono{font-family:'JetBrains Mono',monospace}
        .tag{display:inline-flex;align-items:center;gap:6px;background:rgba(99,102,241,0.15);border:1px solid rgba(99,102,241,0.3);color:#a5b4fc;font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;font-family:'JetBrains Mono',monospace}
        .hero-glow{position:fixed;width:600px;height:600px;border-radius:50%;background:radial-gradient(circle,rgba(99,102,241,0.12),transparent 70%);top:50%;left:50%;transform:translate(-50%,-50%);pointer-events:none;z-index:0}
        .card{animation:fadeUp .5s ease;position:relative;z-index:1}
        .checkbox-custom{width:18px;height:18px;border:1px solid rgba(255,255,255,0.2);border-radius:5px;background:rgba(255,255,255,0.06);cursor:pointer;accent-color:#6366f1}
        .divider{display:flex;align-items:center;gap:12px;margin:20px 0}
        .divider-line{flex:1;height:1px;background:rgba(255,255,255,0.08)}
        .divider-text{font-size:11px;color:#6b6b8a;font-family:'JetBrains Mono',monospace}
        .back-link{display:inline-flex;align-items:center;gap:6px;color:#6b6b8a;font-size:12px;text-decoration:none;transition:color .2s;font-family:'JetBrains Mono',monospace}
        .back-link:hover{color:#e8e8f0}
        .error-box{background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);border-radius:10px;padding:12px 16px;margin-bottom:16px}
        .toggle-pass{position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;color:#6b6b8a;cursor:pointer;font-size:14px;padding:4px}
    </style>
</head>
<body>

<div class="hero-glow"></div>

{{-- Floating particles --}}
<div style="position:fixed;top:20%;left:8%;width:4px;height:4px;background:#6366f1;border-radius:50%;animation:float 3s ease-in-out infinite;z-index:0"></div>
<div style="position:fixed;top:70%;left:5%;width:3px;height:3px;background:#8b5cf6;border-radius:50%;animation:float 4s ease-in-out infinite .5s;z-index:0"></div>
<div style="position:fixed;top:30%;right:8%;width:5px;height:5px;background:#06b6d4;border-radius:50%;animation:float 3.5s ease-in-out infinite 1s;z-index:0"></div>
<div style="position:fixed;top:75%;right:12%;width:3px;height:3px;background:#6366f1;border-radius:50%;animation:float 2.5s ease-in-out infinite .2s;z-index:0"></div>

<div style="width:100%;max-width:420px;padding:24px" class="card">

    {{-- Back to home --}}
    <div style="margin-bottom:24px">
        <a href="{{ url('/') }}" class="back-link">← back to home</a>
    </div>

    {{-- Logo --}}
    <div style="text-align:center;margin-bottom:32px">
        <div style="width:56px;height:56px;background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:26px;margin:0 auto 16px;animation:glow 3s ease-in-out infinite">💳</div>
        <div class="tag" style="margin-bottom:12px">
            <span style="width:5px;height:5px;background:#6366f1;border-radius:50%;animation:pulse 1.5s infinite"></span>
            PayManager
        </div>
        <h1 style="font-size:26px;font-weight:800;color:#fff;letter-spacing:-0.5px;margin-bottom:6px">Welcome back</h1>
        <p class="mono" style="font-size:12px;color:#6b6b8a">// sign in to your account</p>
    </div>

    {{-- Card --}}
    <div class="glass" style="border-radius:20px;padding:28px">

        {{-- Session Status --}}
        @if (session('status'))
            <div style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.3);border-radius:10px;padding:12px 16px;margin-bottom:16px">
                <p style="font-size:13px;color:#34d399">{{ session('status') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div style="margin-bottom:4px">
                <label style="font-size:11px;font-weight:700;color:#8888aa;text-transform:uppercase;letter-spacing:.08em;display:block;margin-bottom:8px" class="mono">Email address</label>
                <div class="input-wrap" style="margin-bottom:0">
                    <span class="input-icon">✉</span>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="input-field" placeholder="admin@payment.com" required autofocus>
                </div>
                @error('email')
                    <p style="font-size:11px;color:#f87171;margin-top:6px;font-family:'JetBrains Mono',monospace">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div style="margin-bottom:16px;margin-top:16px">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                    <label style="font-size:11px;font-weight:700;color:#8888aa;text-transform:uppercase;letter-spacing:.08em" class="mono">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size:11px;color:#6366f1;text-decoration:none;font-family:'JetBrains Mono',monospace">forgot password?</a>
                    @endif
                </div>
                <div class="input-wrap" style="margin-bottom:0">
                    <span class="input-icon">🔒</span>
                    <input type="password" name="password" id="password"
                           class="input-field" placeholder="••••••••" required>
                    <button type="button" class="toggle-pass" onclick="togglePassword()">👁</button>
                </div>
                @error('password')
                    <p style="font-size:11px;color:#f87171;margin-top:6px;font-family:'JetBrains Mono',monospace">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember me --}}
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:24px">
                <input type="checkbox" name="remember" id="remember" class="checkbox-custom">
                <label for="remember" style="font-size:13px;color:#8888aa;cursor:pointer">Remember me for 30 days</label>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-primary">
                Sign in →
            </button>

            {{-- Divider --}}
            <div class="divider">
                <div class="divider-line"></div>
                <div class="divider-text">or</div>
                <div class="divider-line"></div>
            </div>

            {{-- Register link --}}
            <div style="text-align:center">
                <p style="font-size:13px;color:#6b6b8a">
                    Don't have an account?
                    <a href="{{ route('register') }}" style="color:#a5b4fc;font-weight:700;text-decoration:none;margin-left:4px">Create one →</a>
                </p>
            </div>

        </form>
    </div>

    {{-- Demo credentials --}}
    <div class="glass" style="border-radius:12px;padding:16px;margin-top:16px;text-align:center">
        <p class="mono" style="font-size:10px;color:#6b6b8a;margin-bottom:8px">// demo credentials</p>
        <p class="mono" style="font-size:12px;color:#a5b4fc">admin@payment.com</p>
        <p class="mono" style="font-size:12px;color:#8888aa">password: password123</p>
    </div>

</div>

<script>
function togglePassword() {
    const pwd = document.getElementById('password');
    pwd.type = pwd.type === 'password' ? 'text' : 'password';
}
</script>
</body>
</html>