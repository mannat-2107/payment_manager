<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PayManager Engine | Next-Gen Payroll</title>
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
                        slate: {
                            850: '#151e2e',
                            900: '#0f172a',
                            950: '#020617',
                        }
                    },
                    animation: {
                        'blob': 'blob 7s infinite',
                        'grid-flow': 'gridFlow 20s linear infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        },
                        gridFlow: {
                            '0%': { transform: 'translateY(0)' },
                            '100%': { transform: 'translateY(50px)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #020617; color: #f8fafc; overflow-x: hidden; }
        
        .bg-grid {
            background-size: 50px 50px;
            background-image: linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            mask-image: linear-gradient(to bottom, transparent, black 10%, black 90%, transparent);
            -webkit-mask-image: linear-gradient(to bottom, transparent, black 10%, black 90%, transparent);
        }

        .text-gradient {
            background: linear-gradient(to right, #2dd4bf, #38bdf8, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glass-panel {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .feature-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .feature-card:hover {
            transform: translateY(-5px);
            background: rgba(30, 41, 59, 0.8);
            border-color: rgba(45, 212, 191, 0.3);
            box-shadow: 0 10px 40px -10px rgba(45, 212, 191, 0.2);
        }

        .btn-glow {
            position: relative;
        }
        .btn-glow::before {
            content: '';
            position: absolute;
            top: -2px; left: -2px; right: -2px; bottom: -2px;
            background: linear-gradient(45deg, #14b8a6, #3b82f6, #8b5cf6, #14b8a6);
            z-index: -1;
            border-radius: 14px;
            background-size: 400%;
            animation: glow 20s linear infinite;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        .btn-glow:hover::before { opacity: 1; }
        @keyframes glow { 0% { background-position: 0 0; } 50% { background-position: 400% 0; } 100% { background-position: 0 0; } }

        /* Perspective Mockup */
        .mockup-wrapper {
            perspective: 1000px;
            transform-style: preserve-3d;
        }
        .mockup-inner {
            transform: rotateX(15deg) rotateY(-15deg) rotateZ(5deg);
            transition: transform 0.5s ease;
        }
        .mockup-wrapper:hover .mockup-inner {
            transform: rotateX(5deg) rotateY(-5deg) rotateZ(2deg);
        }
    </style>
</head>
<body class="antialiased selection:bg-teal-500/30 selection:text-teal-200">

    <!-- Fixed Nav -->
    <nav class="fixed top-0 w-full z-50 glass-panel border-b-0 border-white/5">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-400 to-emerald-600 flex items-center justify-center text-white shadow-lg shadow-teal-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div>
                    <div class="font-outfit text-xl font-black text-white tracking-tight">PAYMANAGER</div>
                    <div class="text-[9px] text-teal-400 font-bold uppercase tracking-[0.2em] leading-none">Enterprise Engine</div>
                </div>
            </div>
            
            <div class="hidden md:flex items-center gap-8">
                <a href="#platform" class="text-sm font-semibold text-slate-400 hover:text-white transition-colors">Platform</a>
                <a href="#features" class="text-sm font-semibold text-slate-400 hover:text-white transition-colors">Infrastructure</a>
                <a href="#security" class="text-sm font-semibold text-slate-400 hover:text-white transition-colors">Security</a>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="btn-glow bg-slate-900 border border-slate-700 hover:border-teal-500/50 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Sign In
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-grid opacity-20"></div>
            <!-- Blobs -->
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-teal-500/20 rounded-full mix-blend-screen filter blur-[100px] animate-blob"></div>
            <div class="absolute top-20 right-1/4 w-96 h-96 bg-indigo-500/20 rounded-full mix-blend-screen filter blur-[100px] animate-blob" style="animation-delay: 2s"></div>
            <div class="absolute -bottom-32 left-1/2 w-96 h-96 bg-sky-500/20 rounded-full mix-blend-screen filter blur-[100px] animate-blob" style="animation-delay: 4s"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                
                <!-- Left: Copy -->
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-800/50 border border-slate-700 backdrop-blur-md mb-8">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-teal-500"></span>
                        </span>
                        <span class="text-xs font-semibold text-slate-300">PayManager v2.0 Architecture Live</span>
                    </div>

                    <h1 class="font-outfit text-5xl lg:text-7xl font-black text-white leading-[1.1] tracking-tight mb-6">
                        Intelligent <br />
                        <span class="text-gradient">payroll routing</span> <br />
                        for modern teams.
                    </h1>
                    
                    <p class="text-lg text-slate-400 leading-relaxed mb-10 max-w-lg font-medium">
                        Automate complex salary structures, compliance deductions, and bulk disbursements with our high-performance computational engine.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-white text-slate-900 rounded-2xl font-bold hover:bg-slate-100 transition-colors flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            Access Portal
                        </a>
                        <a href="#features" class="w-full sm:w-auto px-8 py-4 glass-panel text-white rounded-2xl font-semibold hover:bg-slate-800 transition-colors flex items-center justify-center gap-2 border border-slate-700">
                            Explore architecture
                        </a>
                    </div>
                    
                    <div class="mt-12 flex items-center gap-6 text-sm text-slate-500 font-mono">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            99.99% Uptime
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            AES-256 Secured
                        </div>
                    </div>
                </div>

                <!-- Right: Mockup -->
                <div class="hidden lg:block relative mockup-wrapper h-[600px] w-full">
                    <div class="mockup-inner absolute right-0 top-10 w-[800px] glass-panel rounded-2xl border border-slate-700/50 shadow-2xl overflow-hidden bg-slate-900/90">
                        <!-- Mockup Header -->
                        <div class="h-12 border-b border-slate-800 flex items-center px-4 gap-2 bg-slate-900/50">
                            <div class="flex gap-1.5">
                                <div class="w-3 h-3 rounded-full bg-rose-500/80"></div>
                                <div class="w-3 h-3 rounded-full bg-amber-500/80"></div>
                                <div class="w-3 h-3 rounded-full bg-emerald-500/80"></div>
                            </div>
                            <div class="mx-auto w-48 h-6 bg-slate-800 rounded-md flex items-center justify-center text-[10px] text-slate-500 font-mono">paymanager.app/dashboard</div>
                        </div>
                        <!-- Mockup Content -->
                        <div class="p-6 grid grid-cols-12 gap-6 h-[450px]">
                            <!-- Sidebar -->
                            <div class="col-span-3 space-y-4">
                                <div class="h-8 bg-slate-800 rounded-lg w-3/4"></div>
                                <div class="space-y-2 mt-8">
                                    <div class="h-4 bg-teal-500/20 border border-teal-500/30 rounded w-full"></div>
                                    <div class="h-4 bg-slate-800 rounded w-5/6"></div>
                                    <div class="h-4 bg-slate-800 rounded w-4/6"></div>
                                    <div class="h-4 bg-slate-800 rounded w-full"></div>
                                </div>
                            </div>
                            <!-- Main Area -->
                            <div class="col-span-9 space-y-6">
                                <!-- Top Cards -->
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="h-24 bg-gradient-to-br from-teal-500/10 to-transparent border border-teal-500/20 rounded-xl p-4 flex flex-col justify-between">
                                        <div class="h-3 w-1/2 bg-teal-500/40 rounded"></div>
                                        <div class="h-6 w-3/4 bg-teal-400 rounded"></div>
                                    </div>
                                    <div class="h-24 bg-slate-800/50 border border-slate-700/50 rounded-xl p-4 flex flex-col justify-between">
                                        <div class="h-3 w-1/2 bg-slate-600 rounded"></div>
                                        <div class="h-6 w-1/2 bg-slate-300 rounded"></div>
                                    </div>
                                    <div class="h-24 bg-slate-800/50 border border-slate-700/50 rounded-xl p-4 flex flex-col justify-between">
                                        <div class="h-3 w-1/2 bg-slate-600 rounded"></div>
                                        <div class="h-6 w-2/3 bg-slate-300 rounded"></div>
                                    </div>
                                </div>
                                <!-- Chart Area -->
                                <div class="h-48 bg-slate-800/30 border border-slate-700/30 rounded-xl p-4 relative overflow-hidden">
                                    <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-teal-500/20 to-transparent"></div>
                                    <!-- Fake chart line using svg -->
                                    <svg class="absolute bottom-0 left-0 w-full h-full" preserveAspectRatio="none" viewBox="0 0 100 100">
                                        <path d="M0,100 L0,70 Q25,80 50,40 T100,20 L100,100 Z" fill="rgba(20, 184, 166, 0.1)" />
                                        <path d="M0,70 Q25,80 50,40 T100,20" fill="none" stroke="#2dd4bf" stroke-width="2" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Metrics -->
    <section class="border-y border-slate-800 bg-slate-900/50 relative z-20">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 divide-x divide-slate-800">
                <div class="text-center px-4">
                    <div class="font-outfit text-4xl font-black text-white mb-1">0ms</div>
                    <div class="text-xs font-bold text-slate-500 uppercase tracking-widest">Processing Lag</div>
                </div>
                <div class="text-center px-4">
                    <div class="font-outfit text-4xl font-black text-white mb-1">100%</div>
                    <div class="text-xs font-bold text-slate-500 uppercase tracking-widest">Data Ownership</div>
                </div>
                <div class="text-center px-4">
                    <div class="font-outfit text-4xl font-black text-white mb-1">&infin;</div>
                    <div class="text-xs font-bold text-slate-500 uppercase tracking-widest">Scalability</div>
                </div>
                <div class="text-center px-4">
                    <div class="font-outfit text-4xl font-black text-teal-400 mb-1">PDF</div>
                    <div class="text-xs font-bold text-slate-500 uppercase tracking-widest">Native Exports</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="features" class="py-32 relative z-10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <h2 class="font-outfit text-4xl font-black text-white tracking-tight mb-6">Engineered for the enterprise.</h2>
                <p class="text-lg text-slate-400">Robust architectural primitives designed to handle complex organizational structures and compliance requirements seamlessly.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="feature-card glass-panel rounded-2xl p-8">
                    <div class="w-12 h-12 bg-teal-500/10 rounded-xl flex items-center justify-center text-teal-400 mb-6 border border-teal-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <h3 class="font-outfit text-xl font-bold text-white mb-3">Relational Workforce DB</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Map employees to departments, roles, and salary bands. Maintain complete historical logs of all personnel changes.</p>
                </div>

                <!-- Card 2 -->
                <div class="feature-card glass-panel rounded-2xl p-8">
                    <div class="w-12 h-12 bg-indigo-500/10 rounded-xl flex items-center justify-center text-indigo-400 mb-6 border border-indigo-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="font-outfit text-xl font-bold text-white mb-3">Algorithmic Computations</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Dynamic salary structures that automatically compute base, HRA, PF, and ESI based on compliance algorithms.</p>
                </div>

                <!-- Card 3 -->
                <div class="feature-card glass-panel rounded-2xl p-8">
                    <div class="w-12 h-12 bg-sky-500/10 rounded-xl flex items-center justify-center text-sky-400 mb-6 border border-sky-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="font-outfit text-xl font-bold text-white mb-3">Batch Processing</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Execute organizational-wide payroll runs in milliseconds. One-click approvals and lock mechanisms.</p>
                </div>
                
                <!-- Card 4 -->
                <div class="feature-card glass-panel rounded-2xl p-8">
                    <div class="w-12 h-12 bg-rose-500/10 rounded-xl flex items-center justify-center text-rose-400 mb-6 border border-rose-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    <h3 class="font-outfit text-xl font-bold text-white mb-3">Disbursement Ledger</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Track every outbound transaction. Built-in mechanisms for handling bank transfers, cash, and cheque logic.</p>
                </div>

                <!-- Card 5 -->
                <div class="feature-card glass-panel rounded-2xl p-8">
                    <div class="w-12 h-12 bg-amber-500/10 rounded-xl flex items-center justify-center text-amber-400 mb-6 border border-amber-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <h3 class="font-outfit text-xl font-bold text-white mb-3">Data Visualization</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Real-time Chart.js integrations rendering financial telemetry directly into your admin console.</p>
                </div>

                <!-- Card 6 -->
                <div class="feature-card glass-panel rounded-2xl p-8">
                    <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center text-emerald-400 mb-6 border border-emerald-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="font-outfit text-xl font-bold text-white mb-3">RBAC Security</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Strict role-based access control segregating Admin, HR, and Employee portals to prevent data leaks.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-32 relative z-10 overflow-hidden">
        <div class="absolute inset-0 bg-teal-500/5 mix-blend-screen"></div>
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="font-outfit text-5xl font-black text-white tracking-tight mb-8">Ready to upgrade your infrastructure?</h2>
            <p class="text-xl text-slate-400 mb-10 max-w-2xl mx-auto font-medium">Join modern organizations running their operations on PayManager Engine.</p>
            <a href="{{ route('login') }}" class="btn-glow inline-flex bg-white text-slate-900 px-10 py-5 rounded-2xl font-black text-lg hover:bg-slate-100 transition-colors items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                Sign In to Portal
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-slate-800 bg-slate-950 py-12 relative z-20">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-teal-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <span class="font-outfit font-bold text-white tracking-tight">PAYMANAGER</span>
                <span class="text-sm text-slate-600 font-mono pl-2 border-l border-slate-800">© {{ date('Y') }}</span>
            </div>
            
            <div class="flex items-center gap-8 text-sm font-semibold text-slate-500">
                <a href="{{ route('login') }}" class="hover:text-teal-400 transition-colors">System Login</a>
                <a href="#" class="hover:text-teal-400 transition-colors">Documentation</a>
                <span class="font-mono text-xs bg-slate-900 px-2 py-1 rounded border border-slate-800 text-slate-400">Built with Laravel 11</span>
            </div>
        </div>
    </footer>

</body>
</html>