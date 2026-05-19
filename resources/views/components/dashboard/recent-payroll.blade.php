@props(['recentPayrolls'])

<div class="flex flex-col h-full">
    {{-- Header --}}
    <div class="flex justify-between items-center px-5 py-3.5 border-b" style="border-color:var(--sys-border)">
        <p class="text-[10px] font-bold uppercase tracking-widest font-mono-code" style="color:var(--sys-text-3)">Latest Payroll</p>
        <a href="{{ route('payroll.index') }}" class="text-[10px] font-bold hover:underline" style="color:var(--sys-primary)">View All →</a>
    </div>

    {{-- List --}}
    <div class="divide-y flex-1 overflow-y-auto" style="border-color:var(--sys-border)">
        @forelse($recentPayrolls as $record)
            <div class="row-hover flex items-center justify-between px-5 py-3">
                <div class="min-w-0 mr-3">
                    <p class="text-xs font-bold truncate" style="color:var(--sys-text)">{{ $record->employee?->user?->name ?? 'Unknown Employee' }}</p>
                    <p class="text-[10px] font-mono-code" style="color:var(--sys-text-3)">
                        {{ DateTime::createFromFormat('!m', $record->month)->format('M') }} {{ $record->year }}
                    </p>
                </div>
                <div class="text-right shrink-0">
                    <p class="text-xs font-bold font-mono-code" style="color:var(--sys-primary)">₹{{ number_format($record->net_salary, 0) }}</p>
                    @if($record->status === 'paid')
                        <span class="text-[10px] font-bold uppercase" style="color:#10b981;">Paid</span>
                    @else
                        <span class="text-[10px] font-bold uppercase" style="color:var(--sys-warn);">{{ $record->status }}</span>
                    @endif
                </div>
            </div>
        @empty
            <p class="px-5 py-8 text-center text-xs" style="color:var(--sys-text-3)">No recent payrolls.</p>
        @endforelse
    </div>
</div>
