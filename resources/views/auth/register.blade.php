<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account — PayManager</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Plus Jakarta Sans',sans-serif;background:#0a0a0f;color:#e8e8f0;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:40px 24px}
        @keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
        @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}
        @keyframes gradientMove{0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%}}
        @keyframes pulse{0%,100%{opacity:1}50%{opacity:0.4}}
        @keyframes glow{0%,100%{box-shadow:0 0 20px rgba(99,102,241,0.3)}50%{box-shadow:0 0 40px rgba(99,102,241,0.6)}}
        .glass{background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);backdrop-filter:blur(20px)}
        .input-field{width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:12px 16px 12px 44px;font-size:14px;color:#e8e8f0;font-family:'Plus Jakarta Sans',sans-serif;transition:all .2s;outline:none}
        .input-field:focus{border-color:rgba(99,102,241,0.6);background:rgba(99,102,241,0.08);box-shadow:0 0 0 3px rgba(99,102,241,0.15)}
        .input-field::placeholder{color:#4b4b6b}
        .input-wrap{position:relative}
        .input-icon{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#6b6b8a;font-size:16px;pointer-events:none}
        .btn-primary{width:100%;padding:13px;background:linear-gradient(135deg,#6366f1,#8b5cf6);border:none;border-radius:12px;font-size:15px;font-weight:700;color:#fff;cursor:pointer;transition:all .3s;font-family:'Plus Jakarta Sans',sans-serif}
        .btn-primary:hover{transform:translateY(-1px);box-shadow:0 8px 30px rgba(99,102,241,0.4)}
        .mono{font-family:'JetBrains Mono',monospace}
        .tag{display:inline-flex;align-items:center;gap:6px;background:rgba(99,102,241,0.15);border:1px solid rgba(99,102,241,0.3);color:#a5b4fc;font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;font-family:'JetBrains Mono',monospace}
        .hero-glow{position:fixed;width:600px;height:600px;border-radius:50%;background:radial-gradient(circle,rgba(99,102,241,0.12),transparent 70%);top:50%;left:50%;transform:translate(-50%,-50%);pointer-events:none;z-index:0}
        .card{animation:fadeUp .5s ease;position:relative;z-index:1;width:100%;max-width:460px}
        .back-link{display:inline-flex;align-items:center;gap:6px;color:#6b6b8a;font-size:12px;text-decoration:none;transition:color .2s;font-family:'JetBrains Mono',monospace}
        .back-link:hover{color:#e8e8f0}
        .field-group{margin-bottom:16px}
        .field-label{font-size:11px;font-weight:700;color:#8888aa;text-transform:uppercase;letter-spacing:.08em;display:block;margin-bottom:8px;font-family:'JetBrains Mono',monospace}
        .toggle-pass{position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;color:#6b6b8a;cursor:pointer;font-size:14px;padding:4px}
        .strength-bar{height:3px;border-radius:2px;background:rgba(255,255,255,0.08);margin-top:8px;overflow:hidden}
        .strength-fill{height:100%;border-radius:2px;transition:all .3s;width:0}
    </style>
</head>
<body>

<div class="hero-glow"></div>
<div style="position:fixed;top:15%;left:8%;width:4px;height:4px;background:#6366f1;border-radius:50%;animation:float 3s ease-in-out infinite;z-index:0"></div>
<div style="position:fixed;top:75%;left:5%;width:3px;height:3px;background:#8b5cf6;border-radius:50%;animation:float 4s ease-in-out infinite .5s;z-index:0"></div>
<div style="position:fixed;top:25%;right:8%;width:5px;height:5px;background:#06b6d4;border-radius:50%;animation:float 3.5s ease-in-out infinite 1s;z-index:0"></div>

<div class="card">

    <div style="margin-bottom:24px">
        <a href="{{ url('/') }}" class="back-link">← back to home</a>
    </div>

    <div style="text-align:center;margin-bottom:28px">
        <div style="width:52px;height:52px;background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:24px;margin:0 auto 14px;animation:glow 3s ease-in-out infinite">💳</div>
        <div class="tag" style="margin-bottom:10px">
            <span style="width:5px;height:5px;background:#6366f1;border-radius:50%;animation:pulse 1.5s infinite"></span>
            PayManager
        </div>
        <h1 style="font-size:24px;font-weight:800;color:#fff;letter-spacing:-0.5px;margin-bottom:4px">Create your account</h1>
        <p class="mono" style="font-size:12px;color:#6b6b8a">// join the platform</p>
    </div>

    <div class="glass" style="border-radius:20px;padding:28px">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="field-group">
                <label class="field-label">Full name</label>
                <div class="input-wrap">
                    <span class="input-icon">👤</span>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="input-field" placeholder="John Doe" required autofocus>
                </div>
                @error('name')
                    <p style="font-size:11px;color:#f87171;margin-top:6px" class="mono">{{ $message }}</p>
                @enderror
            </div>

            <div class="field-group">
                <label class="field-label">Email address</label>
                <div class="input-wrap">
                    <span class="input-icon">✉</span>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="input-field" placeholder="you@company.com" required>
                </div>
                @error('email')
                    <p style="font-size:11px;color:#f87171;margin-top:6px" class="mono">{{ $message }}</p>
                @enderror
            </div>

            <div class="field-group">
                <label class="field-label">Password</label>
                <div class="input-wrap">
                    <span class="input-icon">🔒</span>
                    <input type="password" name="password" id="password"
                           class="input-field" placeholder="Min 8 characters" required
                           oninput="checkStrength(this.value)">
                    <button type="button" class="toggle-pass" onclick="togglePass('password')">👁</button>
                </div>
                <div class="strength-bar">
                    <div class="strength-fill" id="strength-fill"></div>
                </div>
                @error('password')
                    <p style="font-size:11px;color:#f87171;margin-top:6px" class="mono">{{ $message }}</p>
                @enderror
            </div>

            <div class="field-group">
                <label class="field-label">Confirm password</label>
                <div class="input-wrap">
                    <span class="input-icon">🔒</span>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="input-field" placeholder="Repeat password" required>
                    <button type="button" class="toggle-pass" onclick="togglePass('password_confirmation')">👁</button>
                </div>
            </div>

            <button type="submit" class="btn-primary" style="margin-top:8px">
                Create account →
            </button>

            <div style="text-align:center;margin-top:20px">
                <p style="font-size:13px;color:#6b6b8a">
                    Already have an account?
                    <a href="{{ route('login') }}" style="color:#a5b4fc;font-weight:700;text-decoration:none;margin-left:4px">Sign in →</a>
                </p>
            </div>

        </form>
    </div>

</div>

<script>
function togglePass(id) {
    const el = document.getElementById(id);
    el.type = el.type === 'password' ? 'text' : 'password';
}

function checkStrength(val) {
    const fill = document.getElementById('strength-fill');
    let strength = 0;
    if (val.length >= 8) strength++;
    if (/[A-Z]/.test(val)) strength++;
    if (/[0-9]/.test(val)) strength++;
    if (/[^A-Za-z0-9]/.test(val)) strength++;
    const colors = ['#ef4444','#f97316','#eab308','#22c55e'];
    const widths = ['25%','50%','75%','100%'];
    fill.style.width = strength > 0 ? widths[strength-1] : '0';
    fill.style.background = strength > 0 ? colors[strength-1] : 'transparent';
}
</script>
</body>
</html>