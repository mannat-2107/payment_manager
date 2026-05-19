<x-app-layout>
<x-slot name="header">
    <div class="flex items-center gap-3">
        <a href="{{ route('leave.my-leaves') }}" class="p-2 rounded-xl hover:bg-slate-100 text-slate-500 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold outfit text-slate-800">Apply for Leave</h1>
            <p class="text-sm text-slate-500 mt-0.5">Submit a leave request to your manager</p>
        </div>
    </div>
</x-slot>

<div class="py-8 px-4 max-w-2xl mx-auto ani-1">

    {{-- Leave Balance Cards --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        @foreach(\App\Models\LeaveRequest::$types as $key => $label)
        <div class="glass-card rounded-2xl p-4 text-center">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">{{ $label }}</p>
            <p class="text-2xl font-bold text-teal-700">{{ \App\Models\LeaveRequest::$quota[$key] }}</p>
            <p class="text-xs text-slate-400">days/year</p>
        </div>
        @endforeach
    </div>

    <div class="glass-card rounded-2xl p-6">
        @if($errors->any())
        <div class="mb-5 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700 space-y-1">
            @foreach($errors->all() as $error)
            <p>• {{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('leave.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Leave Type <span class="text-red-500">*</span></label>
                <select name="leave_type" required class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent bg-white">
                    <option value="">— Select Type —</option>
                    @foreach(\App\Models\LeaveRequest::$types as $key => $label)
                    <option value="{{ $key }}" {{ old('leave_type')==$key?'selected':'' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">From Date <span class="text-red-500">*</span></label>
                    <input type="date" name="from_date" value="{{ old('from_date') }}" required
                        min="{{ date('Y-m-d') }}"
                        class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">To Date <span class="text-red-500">*</span></label>
                    <input type="date" name="to_date" value="{{ old('to_date') }}" required
                        min="{{ date('Y-m-d') }}"
                        class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                </div>
            </div>

            {{-- Live day counter --}}
            <div id="dayCounter" class="hidden px-4 py-2.5 bg-teal-50 border border-teal-200 rounded-xl text-sm text-teal-700 font-medium text-center"></div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Reason <span class="text-red-500">*</span></label>
                <textarea name="reason" rows="4" required maxlength="1000"
                    class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent resize-none"
                    placeholder="Briefly describe the reason for your leave...">{{ old('reason') }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('leave.my-leaves') }}" class="flex-1 text-center px-5 py-2.5 border border-slate-200 text-slate-600 font-semibold text-sm rounded-xl hover:bg-slate-50 transition-all">Cancel</a>
                <button type="submit" class="flex-1 px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm rounded-xl transition-all btn-primary">
                    Submit Request
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const fromInput = document.querySelector('[name="from_date"]');
const toInput   = document.querySelector('[name="to_date"]');
const counter   = document.getElementById('dayCounter');

function updateCounter() {
    const from = new Date(fromInput.value);
    const to   = new Date(toInput.value);
    if (isNaN(from) || isNaN(to) || to < from) { counter.classList.add('hidden'); return; }
    let days = 0;
    let d = new Date(from);
    while (d <= to) {
        const day = d.getDay();
        if (day !== 0 && day !== 6) days++;
        d.setDate(d.getDate() + 1);
    }
    counter.textContent = `📅 ${days} working day${days !== 1 ? 's' : ''} selected`;
    counter.classList.remove('hidden');
}

fromInput.addEventListener('change', updateCounter);
toInput.addEventListener('change', updateCounter);
</script>
</x-app-layout>
