<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="slate">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PayManager') }}</title>
    
    <!-- Premium Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        /* =========================================================
           THEME DEFINITIONS
           ========================================================= */

        /* Slate — Default clean light theme */
        [data-theme="slate"] {
            --sys-bg:        #f1f5f9;
            --sys-surface:   #ffffff;
            --sys-surface-2: #f8fafc;
            --sys-border:    #e2e8f0;
            --sys-border-2:  #cbd5e1;
            --sys-text:      #0f172a;
            --sys-text-2:    #475569;
            --sys-text-3:    #94a3b8;
            --sys-primary:   #0d9488;
            --sys-primary-2: #0f766e;
            --sys-primary-bg:#f0fdfa;
            --sys-accent:    #6366f1;
            --sys-danger:    #e11d48;
            --sys-warn:      #f59e0b;
            --sys-nav-bg:    #1e293b;
            --sys-nav-text:  #e2e8f0;
        }

        /* Midnight — Dark mode: deep blue/purple */
        [data-theme="midnight"] {
            --sys-bg:        #0a0f1e;
            --sys-surface:   #111827;
            --sys-surface-2: #1a2236;
            --sys-border:    #1e2d45;
            --sys-border-2:  #2d3f5c;
            --sys-text:      #e2e8f0;
            --sys-text-2:    #94a3b8;
            --sys-text-3:    #475569;
            --sys-primary:   #818cf8;
            --sys-primary-2: #6366f1;
            --sys-primary-bg:#1e1b4b;
            --sys-accent:    #f472b6;
            --sys-danger:    #fb7185;
            --sys-warn:      #fbbf24;
            --sys-nav-bg:    #060c18;
            --sys-nav-text:  #cbd5e1;
        }

        /* Cyber — Neon on dark */
        [data-theme="cyber"] {
            --sys-bg:        #050505;
            --sys-surface:   #0d0d0d;
            --sys-surface-2: #141414;
            --sys-border:    #1f2f1f;
            --sys-border-2:  #2e4a2e;
            --sys-text:      #e4ffe4;
            --sys-text-2:    #86efac;
            --sys-text-3:    #4ade80;
            --sys-primary:   #22c55e;
            --sys-primary-2: #16a34a;
            --sys-primary-bg:#052e16;
            --sys-accent:    #f0abfc;
            --sys-danger:    #f87171;
            --sys-warn:      #facc15;
            --sys-nav-bg:    #020202;
            --sys-nav-text:  #86efac;
        }

        /* Monochrome — Minimalist grayscale */
        [data-theme="monochrome"] {
            --sys-bg:        #f5f5f5;
            --sys-surface:   #ffffff;
            --sys-surface-2: #fafafa;
            --sys-border:    #e5e5e5;
            --sys-border-2:  #d4d4d4;
            --sys-text:      #171717;
            --sys-text-2:    #525252;
            --sys-text-3:    #a3a3a3;
            --sys-primary:   #262626;
            --sys-primary-2: #171717;
            --sys-primary-bg:#f5f5f5;
            --sys-accent:    #737373;
            --sys-danger:    #dc2626;
            --sys-warn:      #ca8a04;
            --sys-nav-bg:    #171717;
            --sys-nav-text:  #e5e5e5;
        }

        /* =========================================================
           GLOBAL BASE STYLES (use CSS vars everywhere)
           ========================================================= */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', sans-serif !important;
            background: var(--sys-bg);
            color: var(--sys-text);
            transition: background 0.3s ease, color 0.3s ease;
        }
        h1,h2,h3,h4,h5,h6,.font-outfit { font-family: 'Outfit', sans-serif !important; }
        .font-mono-code { font-family: 'JetBrains Mono', monospace; }

        /* Semantic utility classes */
        .sys-bg        { background: var(--sys-bg); }
        .sys-surface   { background: var(--sys-surface); }
        .sys-surface-2 { background: var(--sys-surface-2); }
        .sys-border    { border-color: var(--sys-border); }
        .sys-border-2  { border-color: var(--sys-border-2); }
        .sys-text      { color: var(--sys-text); }
        .sys-text-2    { color: var(--sys-text-2); }
        .sys-text-3    { color: var(--sys-text-3); }
        .sys-primary   { color: var(--sys-primary); }
        .sys-primary-bg { background: var(--sys-primary-bg); }
        .bg-sys-primary { background: var(--sys-primary); }

        /* =========================================================
           ANIMATIONS
           ========================================================= */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px) scale(0.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-16px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes pulseSoft {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.6; }
        }
        @keyframes shimmer {
            0%   { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.92); }
            to   { opacity: 1; transform: scale(1); }
        }
        @keyframes slideRight {
            from { opacity: 0; transform: translateX(-20px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes countUp {
            from { opacity: 0; transform: translateY(8px); filter: blur(4px); }
            to   { opacity: 1; transform: translateY(0); filter: blur(0); }
        }
        @keyframes glow {
            0%, 100% { box-shadow: 0 0 8px rgba(13,148,136,0.15); }
            50%      { box-shadow: 0 0 20px rgba(13,148,136,0.3); }
        }
        @keyframes breathe {
            0%, 100% { opacity: 0.4; }
            50%      { opacity: 0.7; }
        }

        .ani-1 { animation: fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) both; }
        .ani-2 { animation: fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) 0.08s both; }
        .ani-3 { animation: fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) 0.16s both; }
        .ani-4 { animation: fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) 0.24s both; }
        .ani-5 { animation: fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) 0.32s both; }
        .slide-in  { animation: slideIn 0.45s cubic-bezier(0.16, 1, 0.3, 1) both; }
        .pulse-soft { animation: pulseSoft 2s infinite ease-in-out; }
        .scale-in  { animation: scaleIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) both; }
        .count-up  { animation: countUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both; }
        .glow-pulse { animation: glow 3s ease-in-out infinite; }
        .breathe   { animation: breathe 4s ease-in-out infinite; }

        /* Shimmer loading effect */
        .shimmer-bg {
            background: linear-gradient(90deg, transparent, var(--sys-primary-bg), transparent);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }

        /* =========================================================
           BENTO GRID COMPONENTS (themed)
           ========================================================= */
        .bento-card {
            background: var(--sys-surface);
            border-color: var(--sys-border);
            transition: background 0.3s ease, border-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
        }
        .bento-card:hover {
            box-shadow: 0 8px 30px -8px rgba(0,0,0,0.12);
        }
        .bento-card-2 {
            background: var(--sys-surface-2);
            border-color: var(--sys-border);
            transition: background 0.3s ease;
        }
        .bento-divider {
            background: var(--sys-border);
        }

        /* Row hover */
        .row-hover { transition: background 0.2s ease, transform 0.2s ease; }
        .row-hover:hover {
            background: var(--sys-surface-2);
            transform: translateX(2px);
        }

        /* Stat card hover */
        .stat-card {
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px) scale(1.01);
            box-shadow: 0 16px 40px -12px rgba(0,0,0,0.18);
        }

        /* Quick tool button */
        .quick-btn {
            background: var(--sys-surface-2);
            border-color: var(--sys-border);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .quick-btn:hover {
            border-color: var(--sys-primary);
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 12px 24px -6px rgba(0,0,0,0.15);
        }

        /* Interactive button ripple */
        .btn-primary {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px -6px rgba(13,148,136,0.4);
        }
        .btn-primary:active {
            transform: translateY(0);
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb {
            background: var(--sys-border-2);
            border-radius: 99px;
        }

        /* Nav theming */
        .sys-nav {
            background: var(--sys-nav-bg);
            border-color: var(--sys-border);
            transition: background 0.3s ease;
        }
        .sys-nav-text { color: var(--sys-nav-text); }

        /* Theme switcher */
        .theme-dot {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            border: 2px solid transparent;
            cursor: pointer;
            transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1), border-color 0.2s ease;
        }
        .theme-dot:hover { transform: scale(1.25); }
        .theme-dot.active {
            border-color: var(--sys-primary);
            transform: scale(1.1);
        }

        /* Glass */
        .glass-card {
            background: rgba(255,255,255,0.06);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--sys-border);
        }

        /* Page transition overlay */
        .page-ready { opacity: 0; }
        .page-loaded { opacity: 1; transition: opacity 0.4s ease; }
    </style>

    <!-- Theme init (prevent flash) -->
    <script>
        (function(){
            var t = localStorage.getItem('pm-theme') || 'slate';
            document.documentElement.setAttribute('data-theme', t);
        })();
    </script>

    @livewireStyles
</head>
<body class="font-sans antialiased">
    <x-banner />
    <div class="min-h-screen sys-bg">
        @livewire('navigation-menu')
        <main>
            {{ $slot }}
        </main>
    </div>
    @stack('modals')
    @livewireScripts

    <!-- Global Theme Engine -->
    <script>
        window.PayManagerTheme = {
            themes: ['slate', 'midnight', 'cyber', 'monochrome'],
            current: localStorage.getItem('pm-theme') || 'slate',
            set: function(theme) {
                this.current = theme;
                localStorage.setItem('pm-theme', theme);
                document.documentElement.setAttribute('data-theme', theme);
                // Re-render charts if they exist
                if (window.payrollChart) {
                    window.payrollChart.destroy();
                    if (typeof initPayrollChart === 'function') initPayrollChart();
                }
                // Update active dot
                document.querySelectorAll('.theme-dot').forEach(function(d) {
                    d.classList.toggle('active', d.dataset.theme === theme);
                });
            }
        };
        // Apply saved theme on load
        PayManagerTheme.set(PayManagerTheme.current);
    </script>
</body>
</html>