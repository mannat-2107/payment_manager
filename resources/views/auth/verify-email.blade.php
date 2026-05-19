<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Access — PayManager Engine</title>
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
        body { background-color: #020617; color: #f8fafc; overflow-x: hidden; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .bg-grid { background-size: 40px 40px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0.02) 1px, transparent 1px), linear-gradient(to bottom, rgba(255, 255, 255, 0.02) 1px, transparent 1px); mask-image: radial-gradient(circle at center, black 40%, transparent 80%); -webkit-mask-image: radial-gradient(circle at center, black 40%, transparent 80%); }
        .glass-panel { background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.08); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); }
        .btn-glow { position: relative; }
        .btn-glow::before { content: ''; position: absolute; top: -2px; left: -2px; right: -2px; bottom: -2px; background: linear-gradient(45deg, #14b8a6, #38bdf8, #818cf8, #14b8a6); z-index: -1; border-radius: 14px; background-size: 400%; animation: glow 20s linear infinite; opacity: 0; transition: opacity 0.3s; }
        .btn-glow:hover::before { opacity: 1; }
        @keyframes glow { 0% { background-position: 0 0; } 50% { background-position: 400% 0; } 100% { background-position: 0 0; } }
    </style>
</head>
<body class="antialiased selection:bg-teal-500/30 selection:text-teal-200">

    <div class="absolute inset-0 z-0 pointer-events-none">
        <div class="absolute inset-0 bg-grid"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-teal-500/10 rounded-full blur-[120px] mix-blend-screen animate-pulse-slow"></div>
    </div>

    <div class="w-full max-w-md px-6 relative z-10">

        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-teal-400 to-emerald-600 flex items-center justify-center text-white shadow-lg shadow-teal-500/20 mx-auto mb-6">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <h1 class="font-outfit text-3xl font-black text-white tracking-tight mb-2">Verify Your Email</h1>
            <p class="font-mono text-xs text-teal-400 uppercase tracking-widest">// Authentication Required</p>
        </div>

        <div class="glass-panel rounded-2xl p-8 mb-6">
            
            <p class="text-sm text-slate-400 leading-relaxed mb-6">
                {{ __('Before you can continue, please verify your email address by clicking the link we just sent you. If you didn\'t receive the email, we will gladly send you another.') }}
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="bg-teal-500/10 border border-teal-500/20 rounded-xl p-4 mb-6 flex gap-3">
                    <svg class="w-5 h-5 text-teal-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-xs text-teal-400 font-mono">{{ __('A new verification link has been sent to the email address you provided.') }}</p>
                </div>
            @endif

            <div class="flex flex-col gap-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn-glow w-full bg-slate-900 border border-slate-700 hover:border-slate-500 text-white px-6 py-3.5 rounded-xl text-sm font-bold transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        {{ __('Resend Verification Email') }}
                    </button>
                </form>

                <div class="flex items-center justify-between mt-2 pt-4 border-t border-slate-800">
                    <a href="{{ route('profile.show') }}" class="text-xs font-mono text-slate-400 hover:text-white transition-colors">
                        {{ __('Edit Profile') }}
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-xs font-mono text-rose-400 hover:text-rose-300 transition-colors">
                            {{ __('Sign Out') }}
                        </button>
                    </form>
                </div>
            </div>
            
        </div>

    </div>
</body>
</html>
