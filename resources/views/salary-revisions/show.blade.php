<x-app-layout>
<x-slot name="header">
    <div class="flex items-center gap-3">
        <a href="{{ route('salary-revisions.index') }}" class="p-2 rounded-xl hover:bg-slate-100 text-slate-500 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold outfit text-slate-800">{{ $employee->user?->name ?? 'Unknown' }}</h1>
            <p class="text-sm text-slate-500 mt-0.5">Salary revision timeline · {{ $revisions->count() }} record{{ $revisions->count()===1?'':'s' }}</p>
        </div>
    </div>
</x-slot>

<div class="py-8 px-4 max-w-4xl mx-auto ani-1">

    @if($revisions->isEmpty())
    <div class="glass-card rounded-2xl p-12 text-center text-slate-400">
        <p class="text-4xl mb-3">📈</p>
        <p class="font-semibold text-slate-600">No salary revisions recorded yet</p>
        <p class="text-sm mt-1">Revisions are logged automatically when the salary structure is updated.</p>
    </div>
    @else

    {{-- Current Summary --}}
    @php $latest = $revisions->first(); @endphp
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        <div class="glass-card rounded-2xl p-4 stat-card text-center">
            <p class="text-xs font-semibold text-slate-400 uppercase mb-1">Current Basic</p>
            <p class="text-xl font-black text-slate-800">₹{{ number_format($latest->new_basic) }}</p>
        </div>
        <div class="glass-card rounded-2xl p-4 stat-card text-center">
            <p class="text-xs font-semibold text-slate-400 uppercase mb-1">Current HRA</p>
            <p class="text-xl font-black text-slate-800">₹{{ number_format($latest->new_hra) }}</p>
        </div>
        <div class="glass-card rounded-2xl p-4 stat-card text-center">
            <p class="text-xs font-semibold text-slate-400 uppercase mb-1">Net Salary</p>
            <p class="text-xl font-black text-teal-700">₹{{ number_format($latest->new_net) }}</p>
        </div>
        <div class="glass-card rounded-2xl p-4 stat-card text-center">
            <p class="text-xs font-semibold text-slate-400 uppercase mb-1">Total Revisions</p>
            <p class="text-xl font-black text-slate-800">{{ $revisions->count() }}</p>
        </div>
    </div>

    {{-- Timeline --}}
    <div class="relative pl-8">
        {{-- Vertical line --}}
        <div class="absolute left-3 top-2 bottom-2 w-0.5 bg-slate-200 rounded-full"></div>

        @foreach($revisions as $i => $rev)
        @php
            $increment = $rev->netIncrement();
            $pct       = $rev->incrementPercent();
            $isIncrease = $increment >= 0;
        @endphp
        <div class="relative mb-6 ani-{{ min(5, $i+1) }}">
            {{-- Dot --}}
            <div class="absolute -left-8 top-4 w-6 h-6 rounded-full border-2 border-white shadow-sm
                {{ $isIncrease ? 'bg-teal-500' : 'bg-rose-500' }} flex items-center justify-center">
                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if($isIncrease)
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7"/>
                    @else
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/>
                    @endif
                </svg>
            </div>

            <div class="glass-card rounded-2xl p-5">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Effective From</p>
                        <p class="font-bold text-slate-800 mt-0.5">{{ $rev->effective_from->format('d M Y') }}</p>
                    </div>
                    <div class="text-right">
                        <span class="px-3 py-1 rounded-full text-sm font-bold
                            {{ $isIncrease ? 'bg-teal-100 text-teal-700' : 'bg-rose-100 text-rose-700' }}">
                            {{ $isIncrease ? '+' : '' }}{{ $pct }}%
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <p class="text-xs text-slate-400 mb-0.5">Basic</p>
                        <p class="text-xs text-slate-400 line-through">₹{{ number_format($rev->old_basic) }}</p>
                        <p class="font-semibold text-slate-800">₹{{ number_format($rev->new_basic) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 mb-0.5">HRA</p>
                        <p class="text-xs text-slate-400 line-through">₹{{ number_format($rev->old_hra) }}</p>
                        <p class="font-semibold text-slate-800">₹{{ number_format($rev->new_hra) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 mb-0.5">Net Salary</p>
                        <p class="text-xs text-slate-400 line-through">₹{{ number_format($rev->old_net) }}</p>
                        <p class="font-bold {{ $isIncrease ? 'text-teal-700' : 'text-rose-600' }}">
                            ₹{{ number_format($rev->new_net) }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs text-slate-400 pt-3 border-t border-slate-100">
                    <span>{{ $rev->reason ?? 'No reason provided' }}</span>
                    <span>Revised by {{ $rev->revisor?->name ?? 'System' }} · {{ $rev->created_at->format('d M Y, h:i A') }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
</x-app-layout>
