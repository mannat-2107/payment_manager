<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Request Access — PayManager Engine</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;700;800;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        outfit: ['Outfit', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    colors: {
                        slate: { 950: '#020617' }
                    },
                    animation: {
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #020617; color: #f8fafc; overflow-x: hidden; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 40px 0; }
        .bg-grid { background-size: 40px 40px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0.02) 1px, transparent 1px), linear-gradient(to bottom, rgba(255, 255, 255, 0.02) 1px, transparent 1px); mask-image: radial-gradient(circle at center, black 40%, transparent 80%); -webkit-mask-image: radial-gradient(circle at center, black 40%, transparent 80%); }
        .glass-panel { background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.08); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); }
        .input-field { width: 100%; background: rgba(2, 6, 23, 0.5); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 14px 16px 14px 44px; font-size: 14px; color: #f8fafc; transition: all 0.2s; outline: none; }
        .input-field:focus { border-color: rgba(45, 212, 191, 0.5); box-shadow: 0 0 0 3px rgba(45, 212, 191, 0.15); background: rgba(2, 6, 23, 0.8); }
        .input-field::placeholder { color: #475569; }
        .btn-glow { position: relative; }
        .btn-glow::before { content: ''; position: absolute; top: -2px; left: -2px; right: -2px; bottom: -2px; background: linear-gradient(45deg, #14b8a6, #38bdf8, #818cf8, #14b8a6); z-index: -1; border-radius: 14px; background-size: 400%; animation: glow 20s linear infinite; opacity: 0; transition: opacity 0.3s; }
        .btn-glow:hover::before { opacity: 1; }
        @keyframes glow { 0% { background-position: 0 0; } 50% { background-position: 400% 0; } 100% { background-position: 0 0; } }
        .strength-bar { height: 3px; border-radius: 2px; background: rgba(255,255,255,0.05); margin-top: 8px; overflow: hidden; }
        .strength-fill { height: 100%; border-radius: 2px; transition: all 0.3s; width: 0; }
    </style>
</head>
<body class="antialiased selection:bg-teal-500/30 selection:text-teal-200">

    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute inset-0 bg-grid"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-teal-500/10 rounded-full blur-[120px] mix-blend-screen animate-pulse-slow"></div>
    </div>

    <div class="w-full max-w-md px-6 relative z-10">
        
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-xs font-mono text-slate-400 hover:text-white transition-colors mb-8">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Return to Engine
        </a>

        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-teal-400 to-emerald-600 flex items-center justify-center text-white shadow-lg shadow-teal-500/20 mx-auto mb-6">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            </div>
            <h1 class="font-outfit text-3xl font-black text-white tracking-tight mb-2">Create Account</h1>
            <p class="font-mono text-xs text-teal-400 uppercase tracking-widest">// Join the platform</p>
        </div>

        <div class="glass-panel rounded-2xl p-8 mb-6">
            
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-5">
                    <label class="font-mono text-[10px] uppercase tracking-widest text-slate-400 mb-2 block">Full Name</label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <input type="text" name="name" value="{{ old('name') }}" class="input-field" placeholder="John Doe" required autofocus>
                    </div>
                    @error('name')
                        <p class="font-mono text-[10px] text-rose-400 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label class="font-mono text-[10px] uppercase tracking-widest text-slate-400 mb-2 block">Email Address</label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" class="input-field" placeholder="you@company.com" required>
                    </div>
                    @error('email')
                        <p class="font-mono text-[10px] text-rose-400 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label class="font-mono text-[10px] uppercase tracking-widest text-slate-400 mb-2 block">Password</label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <input type="password" name="password" id="password" class="input-field" placeholder="Min 8 characters" required onkeyup="checkStrength(this.value)">
                        <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300" onclick="document.getElementById('password').type = document.getElementById('password').type === 'password' ? 'text' : 'password'">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                    <div class="strength-bar">
                        <div class="strength-fill" id="strength-fill"></div>
                    </div>
                    @error('password')
                        <p class="font-mono text-[10px] text-rose-400 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8">
                    <label class="font-mono text-[10px] uppercase tracking-widest text-slate-400 mb-2 block">Confirm Password</label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="input-field" placeholder="Repeat characters" required>
                    </div>
                </div>

                <button type="submit" class="btn-glow w-full bg-slate-900 border border-slate-700 hover:border-slate-500 text-white px-6 py-3.5 rounded-xl text-sm font-bold transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Create Account
                </button>
            </form>
        </div>

        <div class="text-center">
            <p class="text-sm text-slate-500">
                Already have an account?
                <a href="{{ route('login') }}" class="text-teal-400 font-semibold hover:text-teal-300 ml-1">Sign In &rarr;</a>
            </p>
        </div>

    </div>

    <script>
    function checkStrength(val) {
        const fill = document.getElementById('strength-fill');
        let strength = 0;
        if (val.length >= 8) strength++;
        if (/[A-Z]/.test(val)) strength++;
        if (/[0-9]/.test(val)) strength++;
        if (/[^A-Za-z0-9]/.test(val)) strength++;
        const colors = ['#f43f5e','#f59e0b','#eab308','#10b981'];
        const widths = ['25%','50%','75%','100%'];
        fill.style.width = strength > 0 ? widths[strength-1] : '0';
        fill.style.background = strength > 0 ? colors[strength-1] : 'transparent';
    }
    </script>
</body>
</html>