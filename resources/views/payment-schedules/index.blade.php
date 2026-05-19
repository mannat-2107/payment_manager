<x-app-layout>
<x-slot name="header">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold outfit text-slate-800">Payment Schedules</h1>
            <p class="text-sm text-slate-500 mt-0.5">Automate payroll on a fixed day each month</p>
        </div>
        <button onclick="document.getElementById('createModal').classList.remove('hidden')"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold rounded-xl transition-all btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Schedule
        </button>
    </div>
</x-slot>

<div class="py-8 px-4 max-w-6xl mx-auto space-y-6 ani-1">

    @if(session('success'))
    <div class="flex items-center gap-3 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Info Banner --}}
    <div class="glass-card rounded-2xl p-4 flex items-center gap-4 border-l-4 border-teal-500">
        <div class="text-teal-500 shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="text-sm text-slate-600">
            The Laravel scheduler runs <strong>daily at 08:00</strong> and triggers any active schedule whose run day matches today.
            Run <code class="font-mono text-xs bg-slate-100 px-1.5 py-0.5 rounded">php artisan schedule:run</code> or add the Windows Task Scheduler entry.
        </div>
    </div>

    {{-- Schedules Grid --}}
    @if($schedules->isEmpty())
    <div class="glass-card rounded-2xl p-12 text-center text-slate-400">
        <p class="text-4xl mb-3">🗓️</p>
        <p class="font-semibold text-slate-600">No payment schedules yet</p>
        <p class="text-sm mt-1">Create one to automate your monthly payroll runs.</p>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($schedules as $schedule)
        <div class="glass-card rounded-2xl p-5 stat-card {{ !$schedule->is_active ? 'opacity-60' : '' }}">
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-teal-100 flex items-center justify-center text-2xl font-black text-teal-700">
                    {{ $schedule->run_day_of_month }}
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $schedule->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-400' }}">
                    {{ $schedule->is_active ? 'Active' : 'Paused' }}
                </span>
            </div>

            <h3 class="font-bold text-slate-800 outfit text-lg mb-1">{{ $schedule->label }}</h3>
            <p class="text-sm text-slate-500 mb-1">Runs on day <strong>{{ $schedule->run_day_of_month }}</strong> of every month</p>
            @if($schedule->notes)
            <p class="text-xs text-slate-400 mb-3">{{ $schedule->notes }}</p>
            @endif

            <div class="grid grid-cols-2 gap-3 mb-4 text-xs text-slate-500">
                <div>
                    <p class="font-semibold text-slate-400 uppercase tracking-wide mb-0.5">Last Run</p>
                    <p>{{ $schedule->last_run_at ? $schedule->last_run_at->format('d M Y H:i') : '—' }}</p>
                </div>
                <div>
                    <p class="font-semibold text-slate-400 uppercase tracking-wide mb-0.5">Next Run</p>
                    <p>{{ $schedule->next_run_at ? $schedule->next_run_at->format('d M Y') : '—' }}</p>
                </div>
            </div>

            <div class="flex gap-2 pt-3 border-t border-slate-100">
                <form method="POST" action="{{ route('payment-schedules.run-now', $schedule) }}" class="flex-1"
                    onsubmit="return confirm('Run this schedule now for all active employees?')">
                    @csrf
                    <button type="submit" class="w-full py-2 text-xs font-semibold text-teal-700 bg-teal-50 hover:bg-teal-100 border border-teal-200 rounded-lg transition-all">
                        ▶ Run Now
                    </button>
                </form>
                <button onclick="openEditModal({{ $schedule->id }}, '{{ addslashes($schedule->label) }}', {{ $schedule->run_day_of_month }}, {{ $schedule->is_active ? 'true' : 'false' }}, '{{ addslashes($schedule->notes ?? '') }}')"
                    class="px-3 py-2 text-xs font-semibold text-slate-600 border border-slate-200 hover:bg-slate-50 rounded-lg transition-all">
                    Edit
                </button>
                <form method="POST" action="{{ route('payment-schedules.destroy', $schedule) }}" onsubmit="return confirm('Delete this schedule?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-2 text-xs font-semibold text-red-600 border border-red-200 hover:bg-red-50 rounded-lg transition-all">
                        ✕
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

{{-- Create Modal --}}
<div id="createModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md mx-4">
        <h3 class="text-lg font-bold outfit text-slate-800 mb-5">New Payment Schedule</h3>
        <form method="POST" action="{{ route('payment-schedules.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Label <span class="text-red-500">*</span></label>
                <input type="text" name="label" required maxlength="100"
                    class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                    placeholder="e.g. Monthly Payroll — 1st">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Run on Day of Month <span class="text-red-500">*</span></label>
                <input type="number" name="run_day_of_month" min="1" max="28" required value="1"
                    class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                <p class="text-xs text-slate-400 mt-1">Max day 28 to avoid month-end issues</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Notes</label>
                <textarea name="notes" rows="2" maxlength="500"
                    class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent resize-none"
                    placeholder="Optional notes..."></textarea>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('createModal').classList.add('hidden')"
                    class="flex-1 py-2.5 border border-slate-200 text-slate-600 font-semibold text-sm rounded-xl hover:bg-slate-50">Cancel</button>
                <button type="submit" class="flex-1 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm rounded-xl transition-all">Create</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div id="editModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md mx-4">
        <h3 class="text-lg font-bold outfit text-slate-800 mb-5">Edit Schedule</h3>
        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Label</label>
                <input type="text" id="editLabel" name="label" required class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Run on Day</label>
                <input type="number" id="editDay" name="run_day_of_month" min="1" max="28" required class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent">
            </div>
            <div class="flex items-center gap-3">
                <input type="checkbox" id="editActive" name="is_active" value="1" class="w-4 h-4 rounded text-teal-600">
                <label for="editActive" class="text-sm font-semibold text-slate-700">Active</label>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Notes</label>
                <textarea id="editNotes" name="notes" rows="2" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent resize-none"></textarea>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')"
                    class="flex-1 py-2.5 border border-slate-200 text-slate-600 font-semibold text-sm rounded-xl hover:bg-slate-50">Cancel</button>
                <button type="submit" class="flex-1 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm rounded-xl transition-all">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, label, day, active, notes) {
    document.getElementById('editForm').action = '/payment-schedules/' + id;
    document.getElementById('editLabel').value  = label;
    document.getElementById('editDay').value    = day;
    document.getElementById('editActive').checked = active;
    document.getElementById('editNotes').value  = notes;
    document.getElementById('editModal').classList.remove('hidden');
}
</script>
</x-app-layout>
