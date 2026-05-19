@props(['recentTransactions'])

<div class="flex flex-col h-full">
    {{-- Header --}}
    <div class="flex justify-between items-center px-5 py-3.5 border-b" style="border-color:var(--sys-border)">
        <p class="text-[10px] font-bold uppercase tracking-widest font-mono-code" style="color:var(--sys-text-3)">Recent Transfers</p>
        <a href="{{ route('transactions.index') }}" class="text-[10px] font-bold hover:underline" style="color:var(--sys-primary)">View All →</a>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto flex-1">
        <table class="w-full">
            <thead>
                <tr style="border-bottom:1px solid var(--sys-border); background:var(--sys-surface-2)">
                    <th class="text-left text-[10px] font-bold uppercase tracking-wider px-5 py-2.5" style="color:var(--sys-text-3)">Recipient</th>
                    <th class="text-left text-[10px] font-bold uppercase tracking-wider px-5 py-2.5" style="color:var(--sys-text-3)">Amount</th>
                    <th class="text-left text-[10px] font-bold uppercase tracking-wider px-5 py-2.5 hidden sm:table-cell" style="color:var(--sys-text-3)">Method</th>
                    <th class="text-left text-[10px] font-bold uppercase tracking-wider px-5 py-2.5" style="color:var(--sys-text-3)">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTransactions as $txn)
                    <tr class="row-hover border-b" style="border-color:var(--sys-border)">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full flex items-center justify-center text-[10px] font-bold shrink-0" style="background:var(--sys-surface-2);border:1px solid var(--sys-border);color:var(--sys-text-2);">
                                    {{ strtoupper(substr($txn->employee?->user?->name ?? 'NA', 0, 2)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold truncate" style="color:var(--sys-text)">{{ $txn->employee?->user?->name ?? 'Unknown Employee' }}</p>
                                    <p class="text-[10px] font-mono-code truncate" style="color:var(--sys-text-3)">{{ $txn->transaction_reference }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            <span class="text-xs font-bold font-mono-code" style="color:var(--sys-text)">₹{{ number_format($txn->amount, 0) }}</span>
                        </td>
                        <td class="px-5 py-3 hidden sm:table-cell">
                            <span class="text-xs capitalize" style="color:var(--sys-text-2)">{{ str_replace('_', ' ', $txn->payment_method) }}</span>
                        </td>
                        <td class="px-5 py-3">
                            @if($txn->status === 'success')
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded" style="background:rgba(16,185,129,0.12);color:#10b981;">✓ Success</span>
                            @elseif($txn->status === 'processing')
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded" style="background:rgba(245,158,11,0.12);color:var(--sys-warn);">↻ Processing</span>
                            @elseif($txn->status === 'initiated')
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded" style="background:rgba(99,102,241,0.12);color:var(--sys-accent);">● Initiated</span>
                            @elseif($txn->status === 'failed')
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded" style="background:rgba(225,29,72,0.12);color:var(--sys-danger);">✕ Failed</span>
                            @else
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded" style="background:var(--sys-surface-2);color:var(--sys-text-3);">Reversed</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-10 text-center text-xs" style="color:var(--sys-text-3)">
                            No transfers yet.
                            <a href="{{ route('transactions.create') }}" class="ml-1 font-bold" style="color:var(--sys-primary)">Create one →</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
