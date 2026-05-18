<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PayManager') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        *{box-sizing:border-box}
        body{font-family:'Plus Jakarta Sans',sans-serif !important}
        .mono{font-family:'JetBrains Mono',monospace}
        @keyframes fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
        @keyframes pulse{0%,100%{opacity:1}50%{opacity:.4}}
        .ani-1{animation:fadeUp .4s ease both}
        .ani-2{animation:fadeUp .4s .1s ease both}
        .ani-3{animation:fadeUp .4s .2s ease both}
        .ani-4{animation:fadeUp .4s .3s ease both}
        .ani-5{animation:fadeUp .4s .4s ease both}
        .pulse{animation:pulse 2s infinite}
        .stat-card{transition:transform .2s,box-shadow .2s}
        .stat-card:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,0.08)}
        .row-hover{transition:background .15s}
        .row-hover:hover{background:#f8fafc}
        .quick-btn{transition:transform .15s,box-shadow .15s}
        .quick-btn:hover{transform:translateY(-2px);box-shadow:0 4px 12px rgba(0,0,0,0.08)}
    </style>
    @livewireStyles
</head>
<body style="background:#f1f5f9;margin:0">
    <x-banner />
    <div class="min-h-screen" style="background:#f1f5f9">
        @livewire('navigation-menu')
        <main>
            {{ $slot }}
        </main>
    </div>
    @stack('modals')
    @livewireScripts
</body>
</html>