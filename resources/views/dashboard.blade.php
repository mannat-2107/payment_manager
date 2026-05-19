<x-app-layout>
<div class="min-h-screen sys-bg transition-colors duration-300">

    {{-- ═══════════════════════════════════════
         COMMAND BAR / TOP HEADER
    ═══════════════════════════════════════ --}}
    <div class="bento-card border-b sticky top-[64px] z-40">
        <div class="max-w-screen-2xl mx-auto px-6 py-3 flex items-center justify-between gap-4">

            {{-- Left: Page title --}}
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0" style="background:var(--sys-primary);opacity:0.9;">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                </div>
                <div class="min-w-0">
                    <h1 class="text-sm font-bold font-outfit truncate" style="color:var(--sys-text)">Command Center</h1>
                    <p class="text-xs truncate" style="color:var(--sys-text-3)">{{ now()->format('D, d M Y · H:i') }}</p>
                </div>
            </div>

            {{-- Center: Alert strip --}}
            @if($pendingPayrolls > 0)
            <a href="{{ route('payroll.index') }}" class="hidden md:flex items-center gap-2 text-xs font-bold px-3 py-1.5 rounded-md" style="background:rgba(245,158,11,0.12);color:var(--sys-warn);">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                {{ $pendingPayrolls }} Payrolls Pending
            </a>
            @elseif($totalPending > 0)
            <a href="{{ route('transactions.index') }}" class="hidden md:flex items-center gap-2 text-xs font-bold px-3 py-1.5 rounded-md" style="background:rgba(99,102,241,0.12);color:var(--sys-accent);">
                <span class="w-1.5 h-1.5 rounded-full animate-pulse" style="background:var(--sys-accent);display:inline-block;"></span>
                {{ $totalPending }} Transfers Processing
            </a>
            @else
            <span class="hidden md:flex items-center gap-2 text-xs font-semibold px-3 py-1.5 rounded-md" style="background:rgba(13,148,136,0.1);color:var(--sys-primary);">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                All Systems Operational
            </span>
            @endif

            {{-- Right: Actions + Theme Switcher --}}
            <div class="flex items-center gap-2 shrink-0">

                {{-- Theme Switcher --}}
                <div class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg border" style="border-color:var(--sys-border);background:var(--sys-surface-2);" title="Switch Theme">
                    <svg class="w-3.5 h-3.5 shrink-0" style="color:var(--sys-text-3)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                    <div class="theme-dot active" data-theme="slate"     style="background:linear-gradient(135deg,#0d9488,#1e293b)" onclick="PayManagerTheme.set('slate');"       title="Slate"></div>
                    <div class="theme-dot"        data-theme="midnight"  style="background:linear-gradient(135deg,#818cf8,#0a0f1e)" onclick="PayManagerTheme.set('midnight');"    title="Midnight"></div>
                    <div class="theme-dot"        data-theme="cyber"     style="background:linear-gradient(135deg,#22c55e,#050505)" onclick="PayManagerTheme.set('cyber');"       title="Cyber"></div>
                    <div class="theme-dot"        data-theme="monochrome" style="background:linear-gradient(135deg,#525252,#ffffff)" onclick="PayManagerTheme.set('monochrome');" title="Mono"></div>
                </div>

                <a href="{{ route('transactions.create') }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold text-white transition-all hover:opacity-90 hover:-translate-y-px" style="background:var(--sys-primary);">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    New Payment
                </a>
                <a href="{{ route('payroll.create') }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all hover:opacity-90 hover:-translate-y-px" style="background:var(--sys-surface-2);color:var(--sys-text);border:1px solid var(--sys-border);">
                    <svg class="w-3.5 h-3.5" style="color:var(--sys-primary)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Run Payroll
                </a>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════
         MAIN BENTO GRID
    ═══════════════════════════════════════ --}}
    <div class="max-w-screen-2xl mx-auto px-6 py-6 space-y-0 ani-1">

        {{-- ─── ROW 1: KPI STATS ─── --}}
        <x-dashboard.top-stats
            :totalPaid="$totalPaid"
            :totalEmployees="$totalEmployees"
            :totalPending="$totalPending"
            :totalFailed="$totalFailed"
        />

        {{-- ─── ROW 2: CHART + QUICK TOOLS + DEPARTMENTS (flush) ─── --}}
        <div class="bento-card border rounded-2xl overflow-hidden mt-6 ani-2">
            <div class="grid grid-cols-1 lg:grid-cols-12 divide-y lg:divide-y-0 lg:divide-x" style="border-color:var(--sys-border)">

                {{-- Chart (7 cols) --}}
                <div class="lg:col-span-7">
                    <x-dashboard.chart />
                </div>

                {{-- Quick Tools (3 cols) --}}
                <div class="lg:col-span-3 border-t lg:border-t-0 lg:border-l" style="border-color:var(--sys-border)">
                    <x-dashboard.quick-tools />
                </div>

                {{-- Departments (2 cols) --}}
                <div class="lg:col-span-2 border-t lg:border-t-0 lg:border-l" style="border-color:var(--sys-border)">
                    <x-dashboard.departments
                        :departments="$departments"
                        :totalEmployees="$totalEmployees"
                    />
                </div>

            </div>
        </div>

        {{-- ─── ROW 3: TRANSACTIONS + FINANCIAL SUMMARY + PAYROLL (flush) ─── --}}
        <div class="bento-card border rounded-2xl overflow-hidden mt-6 ani-3">
            <div class="grid grid-cols-1 lg:grid-cols-12 divide-y lg:divide-y-0 lg:divide-x" style="border-color:var(--sys-border)">

                {{-- Recent Transactions (7 cols) --}}
                <div class="lg:col-span-7">
                    <x-dashboard.recent-transactions :recentTransactions="$recentTransactions" />
                </div>

                {{-- Financial Summary (2 cols) --}}
                <div class="lg:col-span-2 border-t lg:border-t-0 lg:border-l" style="border-color:var(--sys-border)">
                    <x-dashboard.financial-summary
                        :totalGross="$totalGross"
                        :totalPF="$totalPF"
                        :totalTDS="$totalTDS"
                        :totalESI="$totalESI"
                        :totalNet="$totalNet"
                    />
                </div>

                {{-- Recent Payroll (3 cols) --}}
                <div class="lg:col-span-3 border-t lg:border-t-0 lg:border-l" style="border-color:var(--sys-border)">
                    <x-dashboard.recent-payroll :recentPayrolls="$recentPayrolls" />
                </div>

            </div>
        </div>

    </div>{{-- /bento grid --}}
</div>

{{-- ─── CHART SCRIPT ─── --}}
<script>
function initPayrollChart() {
    const ctx = document.getElementById('payrollChart');
    if (!ctx) return;
    const style = getComputedStyle(document.documentElement);
    const primary  = style.getPropertyValue('--sys-primary').trim()  || '#0d9488';
    const text3    = style.getPropertyValue('--sys-text-3').trim()   || '#94a3b8';
    const border   = style.getPropertyValue('--sys-border').trim()   || '#e2e8f0';
    const surface  = style.getPropertyValue('--sys-surface').trim()  || '#ffffff';

    window.payrollChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun'],
            datasets: [{
                label: 'Net Payroll (₹)',
                data: [
                    {{ round($totalNet * 0.78) }},
                    {{ round($totalNet * 0.88) }},
                    {{ round($totalNet * 0.83) }},
                    {{ round($totalNet * 1.05) }},
                    {{ round($totalNet * 0.95) }},
                    {{ $totalNet }}
                ],
                borderColor: primary,
                backgroundColor: primary + '22',
                borderWidth: 2.5,
                tension: 0.45,
                fill: true,
                pointBackgroundColor: surface,
                pointBorderColor: primary,
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleFont: { family: 'Inter', size: 12 },
                    bodyFont:  { family: 'JetBrains Mono', size: 13, weight: 'bold' },
                    padding: 12,
                    cornerRadius: 10,
                    displayColors: false,
                    callbacks: {
                        label: function(ctx) { return ' ₹' + ctx.raw.toLocaleString('en-IN'); }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    grid: { color: border, drawBorder: false },
                    ticks: { font: { family: 'JetBrains Mono', size: 10 }, color: text3 }
                },
                x: {
                    grid: { display: false, drawBorder: false },
                    ticks: { font: { family: 'Inter', size: 11, weight: '600' }, color: text3 }
                }
            },
            interaction: { intersect: false, mode: 'index' }
        }
    });
}
document.addEventListener('DOMContentLoaded', initPayrollChart);
</script>
</x-app-layout>