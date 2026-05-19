@props(['departments', 'totalEmployees'])

<div class="p-5 h-full flex flex-col">
    <p class="text-[10px] font-bold uppercase tracking-widest mb-4 font-mono-code" style="color:var(--sys-text-3)">By Dept</p>
    <div class="space-y-3 flex-1 overflow-y-auto">
    @forelse($departments as $dept)
        @php $pct = $totalEmployees > 0 ? round(($dept->employees_count / $totalEmployees) * 100) : 0; @endphp
        <div>
            <div class="flex justify-between items-center mb-1">
                <span class="text-xs font-semibold truncate mr-2" style="color:var(--sys-text-2)">{{ $dept->name }}</span>
                <span class="text-[10px] font-mono-code shrink-0" style="color:var(--sys-text-3)">{{ $dept->employees_count }}</span>
            </div>
            <div class="h-1.5 rounded-full overflow-hidden" style="background:var(--sys-border);">
                <div class="h-full rounded-full transition-all duration-1000"
                    style="width:{{ $pct }}%; background:var(--sys-primary);">
                </div>
            </div>
        </div>
    @empty
        <p class="text-xs italic" style="color:var(--sys-text-3)">No departments.</p>
    @endforelse
    </div>
</div>
