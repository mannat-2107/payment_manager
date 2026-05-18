<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PayManager — Employee Payment Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Plus Jakarta Sans',sans-serif;background:#0a0a0f;color:#e8e8f0;overflow-x:hidden}
        @keyframes fadeUp{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)}}
        @keyframes fadeIn{from{opacity:0}to{opacity:1}}
        @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
        @keyframes pulse{0%,100%{opacity:1}50%{opacity:0.5}}
        @keyframes slideRight{from{width:0}to{width:100%}}
        @keyframes countUp{from{opacity:0;transform:scale(0.5)}to{opacity:1;transform:scale(1)}}
        @keyframes gradientMove{0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%}}
        @keyframes glow{0%,100%{box-shadow:0 0 20px rgba(99,102,241,0.3)}50%{box-shadow:0 0 40px rgba(99,102,241,0.6)}}
        .gradient-text{background:linear-gradient(135deg,#6366f1,#8b5cf6,#06b6d4);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;background-size:200% 200%;animation:gradientMove 4s ease infinite}
        .glass{background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);backdrop-filter:blur(10px)}
        .animate-on-scroll{opacity:0;transform:translateY(30px);transition:all .6s ease}
        .animate-on-scroll.visible{opacity:1;transform:translateY(0)}
        .feature-card{transition:all .3s ease}
        .feature-card:hover{transform:translateY(-4px);border-color:rgba(99,102,241,0.4);background:rgba(99,102,241,0.08)}
        .stat-number{font-family:'JetBrains Mono',monospace;font-size:42px;font-weight:700;background:linear-gradient(135deg,#6366f1,#8b5cf6);-webkit-background-clip:text;-webkit-text-fill-color:transparent}
        .btn-primary{background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;border:none;cursor:pointer;transition:all .3s;font-weight:700;letter-spacing:-0.2px}
        .btn-primary:hover{transform:translateY(-2px);box-shadow:0 8px 30px rgba(99,102,241,0.4)}
        .btn-outline{background:transparent;color:#e8e8f0;border:1px solid rgba(255,255,255,0.2);cursor:pointer;transition:all .3s;font-weight:600}
        .btn-outline:hover{background:rgba(255,255,255,0.06);border-color:rgba(255,255,255,0.4)}
        .hero-glow{position:absolute;width:600px;height:600px;border-radius:50%;background:radial-gradient(circle,rgba(99,102,241,0.15),transparent 70%);top:50%;left:50%;transform:translate(-50%,-50%);pointer-events:none}
        .nav-blur{background:rgba(10,10,15,0.8);backdrop-filter:blur(20px);border-bottom:1px solid rgba(255,255,255,0.06)}
        .step-line{position:absolute;top:24px;left:calc(50% + 30px);width:calc(100% - 60px);height:1px;background:linear-gradient(90deg,rgba(99,102,241,0.5),rgba(139,92,246,0.2));z-index:0}
        .mono{font-family:'JetBrains Mono',monospace}
        .tag{display:inline-flex;align-items:center;gap:6px;background:rgba(99,102,241,0.15);border:1px solid rgba(99,102,241,0.3);color:#a5b4fc;font-size:12px;font-weight:600;padding:4px 12px;border-radius:20px;font-family:'JetBrains Mono',monospace}
        .scroll-indicator{animation:float 2s ease-in-out infinite}
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="nav-blur fixed top-0 left-0 right-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div style="width:36px;height:36px;background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px">💳</div>
            <div>
                <div style="font-size:15px;font-weight:800;color:#fff;letter-spacing:-0.3px">PayManager</div>
                <div class="mono" style="font-size:9px;color:#6b6b8a">payment platform</div>
            </div>
        </div>
        <div class="flex items-center gap-6">
            <a href="#features" style="font-size:13px;font-weight:500;color:#8888aa;text-decoration:none;transition:color .2s" onmouseover="this.style.color='#e8e8f0'" onmouseout="this.style.color='#8888aa'">Features</a>
            <a href="#how-it-works" style="font-size:13px;font-weight:500;color:#8888aa;text-decoration:none;transition:color .2s" onmouseover="this.style.color='#e8e8f0'" onmouseout="this.style.color='#8888aa'">How it works</a>
            <a href="#stats" style="font-size:13px;font-weight:500;color:#8888aa;text-decoration:none;transition:color .2s" onmouseover="this.style.color='#e8e8f0'" onmouseout="this.style.color='#8888aa'">Stats</a>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" class="btn-outline" style="padding:8px 20px;border-radius:10px;font-size:13px;text-decoration:none;display:inline-block">Sign in</a>
            <a href="{{ route('register') }}" class="btn-primary" style="padding:8px 20px;border-radius:10px;font-size:13px;text-decoration:none;display:inline-block">Get started →</a>
        </div>
    </div>
</nav>

{{-- Hero --}}
<section style="min-height:100vh;display:flex;align-items:center;justify-content:center;position:relative;padding:120px 24px 80px">
    <div class="hero-glow"></div>

    {{-- Floating particles --}}
    <div style="position:absolute;top:20%;left:10%;width:4px;height:4px;background:#6366f1;border-radius:50%;animation:float 3s ease-in-out infinite"></div>
    <div style="position:absolute;top:60%;left:5%;width:3px;height:3px;background:#8b5cf6;border-radius:50%;animation:float 4s ease-in-out infinite .5s"></div>
    <div style="position:absolute;top:30%;right:10%;width:5px;height:5px;background:#06b6d4;border-radius:50%;animation:float 3.5s ease-in-out infinite 1s"></div>
    <div style="position:absolute;top:70%;right:15%;width:3px;height:3px;background:#6366f1;border-radius:50%;animation:float 2.5s ease-in-out infinite .2s"></div>

    <div style="text-align:center;max-width:800px;animation:fadeUp .8s ease">
        <div class="tag" style="margin-bottom:24px">
            <span style="width:6px;height:6px;background:#6366f1;border-radius:50%;animation:pulse 1.5s infinite"></span>
            v2.0 · Employee Payment Management Platform
        </div>

        <h1 style="font-size:clamp(40px,6vw,72px);font-weight:800;line-height:1.1;letter-spacing:-2px;margin-bottom:24px;color:#fff">
            Streamline your<br>
            <span class="gradient-text">employee payments</span><br>
            effortlessly
        </h1>

        <p style="font-size:18px;color:#8888aa;line-height:1.7;margin-bottom:40px;max-width:560px;margin-left:auto;margin-right:auto">
            A complete platform to manage salary structures, run payroll, track payment transactions, and generate payslips — all in one place.
        </p>

        <div style="display:flex;align-items:center;justify-content:center;gap:16px;margin-bottom:60px">
            <a href="{{ route('register') }}" class="btn-primary" style="padding:14px 32px;border-radius:12px;font-size:15px;text-decoration:none;display:inline-block;animation:glow 3s ease-in-out infinite">
                Start for free →
            </a>
            <a href="{{ route('login') }}" class="btn-outline" style="padding:14px 32px;border-radius:12px;font-size:15px;text-decoration:none;display:inline-block">
                Sign in
            </a>
        </div>

        {{-- Hero stats --}}
        <div style="display:flex;align-items:center;justify-content:center;gap:40px">
            <div style="text-align:center">
                <div class="mono" style="font-size:24px;font-weight:700;color:#6366f1">₹0</div>
                <div style="font-size:12px;color:#6b6b8a;margin-top:2px">Setup cost</div>
            </div>
            <div style="width:1px;height:40px;background:rgba(255,255,255,0.1)"></div>
            <div style="text-align:center">
                <div class="mono" style="font-size:24px;font-weight:700;color:#8b5cf6">100%</div>
                <div style="font-size:12px;color:#6b6b8a;margin-top:2px">Data control</div>
            </div>
            <div style="width:1px;height:40px;background:rgba(255,255,255,0.1)"></div>
            <div style="text-align:center">
                <div class="mono" style="font-size:24px;font-weight:700;color:#06b6d4">PDF</div>
                <div style="font-size:12px;color:#6b6b8a;margin-top:2px">Payslip export</div>
            </div>
        </div>

        {{-- Scroll indicator --}}
        <div class="scroll-indicator" style="margin-top:60px;display:flex;flex-direction:column;align-items:center;gap:8px">
            <div style="font-size:11px;color:#6b6b8a;font-family:'JetBrains Mono',monospace">scroll to explore</div>
            <div style="width:1px;height:40px;background:linear-gradient(to bottom,rgba(99,102,241,0.6),transparent)"></div>
        </div>
    </div>
</section>

{{-- Features --}}
<section id="features" style="padding:100px 24px">
    <div style="max-width:1200px;margin:0 auto">
        <div style="text-align:center;margin-bottom:60px" class="animate-on-scroll">
            <div class="tag" style="margin-bottom:16px">// features</div>
            <h2 style="font-size:42px;font-weight:800;color:#fff;letter-spacing:-1px;margin-bottom:16px">Everything you need</h2>
            <p style="font-size:16px;color:#8888aa;max-width:500px;margin:0 auto">A complete suite of tools to manage your entire employee payment lifecycle.</p>
        </div>

        <div style="display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px">

            <div class="glass feature-card animate-on-scroll" style="border-radius:16px;padding:28px">
                <div style="width:48px;height:48px;background:rgba(99,102,241,0.15);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:20px">👥</div>
                <h3 style="font-size:17px;font-weight:700;color:#fff;margin-bottom:8px;letter-spacing:-0.3px">Employee Management</h3>
                <p style="font-size:13px;color:#8888aa;line-height:1.7">Complete employee profiles with bank details, department assignment, and status tracking.</p>
            </div>

            <div class="glass feature-card animate-on-scroll" style="border-radius:16px;padding:28px">
                <div style="width:48px;height:48px;background:rgba(139,92,246,0.15);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:20px">💰</div>
                <h3 style="font-size:17px;font-weight:700;color:#fff;margin-bottom:8px;letter-spacing:-0.3px">Salary Structure</h3>
                <p style="font-size:13px;color:#8888aa;line-height:1.7">Define basic, HRA, allowances with automatic PF, ESI, and TDS deduction calculations.</p>
            </div>

            <div class="glass feature-card animate-on-scroll" style="border-radius:16px;padding:28px">
                <div style="width:48px;height:48px;background:rgba(6,182,212,0.15);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:20px">⚡</div>
                <h3 style="font-size:17px;font-weight:700;color:#fff;margin-bottom:8px;letter-spacing:-0.3px">Payroll Engine</h3>
                <p style="font-size:13px;color:#8888aa;line-height:1.7">Auto-calculate monthly payroll with one click. Approve, review, and mark as paid with full audit trail.</p>
            </div>

            <div class="glass feature-card animate-on-scroll" style="border-radius:16px;padding:28px">
                <div style="width:48px;height:48px;background:rgba(16,185,129,0.15);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:20px">🔄</div>
                <h3 style="font-size:17px;font-weight:700;color:#fff;margin-bottom:8px;letter-spacing:-0.3px">Payment Transactions</h3>
                <p style="font-size:13px;color:#8888aa;line-height:1.7">Track every payment from initiation to completion. Bank transfer, cheque, cash — with retry on failure.</p>
            </div>

            <div class="glass feature-card animate-on-scroll" style="border-radius:16px;padding:28px">
                <div style="width:48px;height:48px;background:rgba(245,158,11,0.15);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:20px">📄</div>
                <h3 style="font-size:17px;font-weight:700;color:#fff;margin-bottom:8px;letter-spacing:-0.3px">PDF Payslips</h3>
                <p style="font-size:13px;color:#8888aa;line-height:1.7">Generate and download professional payslips instantly. Email them directly to employees automatically.</p>
            </div>

            <div class="glass feature-card animate-on-scroll" style="border-radius:16px;padding:28px">
                <div style="width:48px;height:48px;background:rgba(239,68,68,0.15);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:20px">📊</div>
                <h3 style="font-size:17px;font-weight:700;color:#fff;margin-bottom:8px;letter-spacing:-0.3px">Reports & Analytics</h3>
                <p style="font-size:13px;color:#8888aa;line-height:1.7">Monthly payment summaries, department-wise breakdown, deduction reports, and transaction analytics.</p>
            </div>

        </div>
    </div>
</section>

{{-- How it works --}}
<section id="how-it-works" style="padding:100px 24px;background:rgba(255,255,255,0.02)">
    <div style="max-width:1000px;margin:0 auto">
        <div style="text-align:center;margin-bottom:60px" class="animate-on-scroll">
            <div class="tag" style="margin-bottom:16px">// how it works</div>
            <h2 style="font-size:42px;font-weight:800;color:#fff;letter-spacing:-1px;margin-bottom:16px">Simple 4-step process</h2>
            <p style="font-size:16px;color:#8888aa">From employee onboarding to salary payment in minutes.</p>
        </div>

        <div style="display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:24px;position:relative">
            @foreach([
                ['01', 'Add Employee', 'Create employee profile with personal info and bank details.', '#6366f1'],
                ['02', 'Set Salary', 'Configure salary structure with earnings and deductions.', '#8b5cf6'],
                ['03', 'Run Payroll', 'Generate payroll automatically. Review and approve.', '#06b6d4'],
                ['04', 'Pay & Track', 'Process payment and track transaction status live.', '#10b981'],
            ] as $step)
            <div class="animate-on-scroll" style="text-align:center">
                <div style="width:52px;height:52px;background:rgba({{ $step[3] === '#6366f1' ? '99,102,241' : ($step[3] === '#8b5cf6' ? '139,92,246' : ($step[3] === '#06b6d4' ? '6,182,212' : '16,185,129')) }},0.15);border:1px solid rgba({{ $step[3] === '#6366f1' ? '99,102,241' : ($step[3] === '#8b5cf6' ? '139,92,246' : ($step[3] === '#06b6d4' ? '6,182,212' : '16,185,129')) }},0.4);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-family:'JetBrains Mono',monospace;font-size:14px;font-weight:700;color:{{ $step[3] }}">
                    {{ $step[0] }}
                </div>
                <h3 style="font-size:15px;font-weight:700;color:#fff;margin-bottom:8px;letter-spacing:-0.2px">{{ $step[1] }}</h3>
                <p style="font-size:12px;color:#8888aa;line-height:1.7">{{ $step[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Stats --}}
<section id="stats" style="padding:100px 24px">
    <div style="max-width:1000px;margin:0 auto">
        <div style="text-align:center;margin-bottom:60px" class="animate-on-scroll">
            <div class="tag" style="margin-bottom:16px">// platform stats</div>
            <h2 style="font-size:42px;font-weight:800;color:#fff;letter-spacing:-1px">Built for scale</h2>
        </div>

        <div style="display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px">
            @foreach([
                ['₹0', 'Setup Cost', 'Free to deploy'],
                ['∞', 'Employees', 'No limits'],
                ['PDF', 'Payslips', 'Instant download'],
                ['100%', 'Secure', 'Your data only'],
            ] as $stat)
            <div class="glass animate-on-scroll" style="border-radius:16px;padding:28px;text-align:center">
                <div class="mono" style="font-size:36px;font-weight:700;background:linear-gradient(135deg,#6366f1,#8b5cf6);-webkit-background-clip:text;-webkit-text-fill-color:transparent;margin-bottom:8px">{{ $stat[0] }}</div>
                <div style="font-size:14px;font-weight:700;color:#fff;margin-bottom:4px">{{ $stat[1] }}</div>
                <div style="font-size:12px;color:#6b6b8a">{{ $stat[2] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section style="padding:100px 24px">
    <div style="max-width:700px;margin:0 auto;text-align:center" class="animate-on-scroll">
        <div class="glass" style="border-radius:24px;padding:60px 40px;position:relative;overflow:hidden">
            <div style="position:absolute;width:300px;height:300px;border-radius:50%;background:radial-gradient(circle,rgba(99,102,241,0.2),transparent 70%);top:50%;left:50%;transform:translate(-50%,-50%);pointer-events:none"></div>
            <div class="tag" style="margin-bottom:20px">// get started today</div>
            <h2 style="font-size:36px;font-weight:800;color:#fff;letter-spacing:-1px;margin-bottom:16px">Ready to streamline<br>your payroll?</h2>
            <p style="font-size:15px;color:#8888aa;margin-bottom:32px;line-height:1.7">Join companies that trust PayManager for their employee payment processing.</p>
            <div style="display:flex;align-items:center;justify-content:center;gap:16px">
                <a href="{{ route('register') }}" class="btn-primary" style="padding:14px 32px;border-radius:12px;font-size:15px;text-decoration:none;display:inline-block">
                    Create account →
                </a>
                <a href="{{ route('login') }}" class="btn-outline" style="padding:14px 32px;border-radius:12px;font-size:15px;text-decoration:none;display:inline-block">
                    Sign in
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Footer --}}
<footer style="border-top:1px solid rgba(255,255,255,0.06);padding:40px 24px">
    <div style="max-width:1200px;margin:0 auto;display:flex;align-items:center;justify-content:space-between">
        <div style="display:flex;align-items:center;gap:10px">
            <div style="width:28px;height:28px;background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:12px">💳</div>
            <span style="font-size:13px;font-weight:700;color:#fff">PayManager</span>
            <span class="mono" style="font-size:11px;color:#6b6b8a">© {{ date('Y') }}</span>
        </div>
        <div style="display:flex;gap:24px">
            <a href="{{ route('login') }}" style="font-size:12px;color:#6b6b8a;text-decoration:none">Login</a>
            <a href="{{ route('register') }}" style="font-size:12px;color:#6b6b8a;text-decoration:none">Register</a>
            <span class="mono" style="font-size:12px;color:#6b6b8a">Built with Laravel 12</span>
        </div>
    </div>
</footer>

<script>
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.animate-on-scroll').forEach(el => {
    observer.observe(el);
});

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});
</script>
</body>
</html>