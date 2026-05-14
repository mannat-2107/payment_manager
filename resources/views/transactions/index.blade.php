<x-app-layout>
<style>
@keyframes fadeInUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.4}}
.ani-1{animation:fadeInUp .4s ease both}
.ani-2{animation:fadeInUp .4s .1s ease both}
.ani-3{animation:fadeInUp .4s .2s ease both}
.ani-4{animation:fadeInUp .4s .3s ease both}
.ani-5{animation:fadeInUp .4s .4s ease both}
.pulse{animation:pulse 2s infinite}
.stat-card{transition:transform .2s,box-shadow .2s}
.stat-card:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,0.08)}
.txn-row{transition:background .15s}
.txn-row:hover{background:#f8fafc}
</style>

<div class="min-h-screen bg-gray-50">

    {{-- Header --}}
    <div class="bg-white border-b border-gray-100 px-4 sm:px-6 lg:px-8 py-5">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Payment Transactions</h2>
                <p class="text-sm text-gray-400 mt-1">Track and manage all employee payment transactions</p>
            </div>
            <a href="{{ route('transactions.create') }}"
               class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-blue-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Transaction
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Alerts --}}
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl mb-6 flex items-center gap-3 ani-1">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        {{-- Stat Cards --}}
        <div class="grid grid-cols-4 gap-5 mb-8">

            <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-1">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest">Total Paid</p>
                    <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800">₹{{ number_format($totalPaid, 0) }}</p>
                <p class="text-xs text-green-500 mt-1 font-medium">Successful payments</p>
            </div>

            <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-2">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest">Successful</p>
                    <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $totalSuccess }}</p>
                <p class="text-xs text-green-500 mt-1 font-medium">Completed transactions</p>
            </div>

            <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-3">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest">Pending</p>
                    <div class="w-9 h-9 bg-yellow-50 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600 pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-yellow-500">{{ $totalPending }}</p>
                <p class="text-xs text-yellow-500 mt-1 font-medium pulse">Needs attention</p>
            </div>

            <div class="stat-card bg-white rounded-2xl border border-gray-100 p-5 ani-4">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest">Failed</p>
                    <div class="w-9 h-9 bg-red-50 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-red-500">{{ $totalFailed }}</p>
                <p class="text-xs text-red-400 mt-1 font-medium">Retry needed</p>
            </div>

        </div>

        {{-- Filters --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5 mb-6 ani-3">
            <form method="GET" action="{{ route('transactions.index') }}" class="flex gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-xs font-medium text-gray-400 mb-1.5 uppercase">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Employee name or transaction ID..."
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5 uppercase">Status</label>
                    <select name="status" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Status</option>
                        <option value="initiated"  {{ request('status') == 'initiated'  ? 'selected' : '' }}>Initiated</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="success"    {{ request('status') == 'success'    ? 'selected' : '' }}>Success</option>
                        <option value="failed"     {{ request('status') == 'failed'     ? 'selected' : '' }}>Failed</option>
                        <option value="reversed"   {{ request('status') == 'reversed'   ? 'selected' : '' }}>Reversed</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5 uppercase">Method</label>
                    <select name="method" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Methods</option>
                        <option value="bank_transfer" {{ request('method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="cheque"        {{ request('method') == 'cheque'        ? 'selected' : '' }}>Cheque</option>
                        <option value="cash"          {{ request('method') == 'cash'          ? 'selected' : '' }}>Cash</option>
                    </select>
                </div>
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-blue-700 transition">
                    Filter
                </button>
                <a href="{{ route('transactions.index') }}"
                   class="bg-gray-100 text-gray-600 px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-200 transition">
                    Reset
                </a>
            </form>
        </div>

        {{-- Transactions Table --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden ani-4">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-semibold text-gray-800">All Transactions</h3>
                <span class="text-sm text-gray-400">{{ $transactions->total() }} total records</span>
            </div>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Employee</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Reference</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Amount</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Method</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Status</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Date</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transactions as $txn)
                    <tr class="txn-row">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-xs font-semibold flex-shrink-0">
                                    {{ strtoupper(substr($txn->employee->user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ $txn->employee->user->name }}</p>
                                    <p class="text-xs text-gray-400 font-mono">{{ $txn->employee->employee_code }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-mono text-gray-500 bg-gray-50 px-2 py-1 rounded-lg">{{ $txn->transaction_reference }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-gray-800">₹{{ number_format($txn->amount, 0) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-500 capitalize">{{ str_replace('_', ' ', $txn->payment_method) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($txn->status === 'success')
                                <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 text-xs px-3 py-1.5 rounded-full font-medium">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>Success
                                </span>
                            @elseif($txn->status === 'processing')
                                <span class="inline-flex items-center gap-1.5 bg-yellow-100 text-yellow-700 text-xs px-3 py-1.5 rounded-full font-medium">
                                    <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full pulse"></span>Processing
                                </span>
                            @elseif($txn->status === 'initiated')
                                <span class="inline-flex items-center gap-1.5 bg-blue-100 text-blue-700 text-xs px-3 py-1.5 rounded-full font-medium">
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>Initiated
                                </span>
                            @elseif($txn->status === 'failed')
                                <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 text-xs px-3 py-1.5 rounded-full font-medium">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>Failed
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-700 text-xs px-3 py-1.5 rounded-full font-medium">
                                    <span class="w-1.5 h-1.5 bg-gray-500 rounded-full"></span>Reversed
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-400">
                            {{ $txn->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('transactions.show', $txn) }}"
                                   class="text-blue-600 hover:text-blue-700 text-xs font-medium hover:underline">View</a>

                                @if($txn->status !== 'success')
                                <form method="POST" action="{{ route('transactions.update', $txn) }}">
                                    @csrf @method('PUT')
                                    <select name="status" onchange="this.form.submit()"
                                            class="text-xs border border-gray-200 rounded-lg px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                        <option value="initiated"  {{ $txn->status == 'initiated'  ? 'selected' : '' }}>Initiated</option>
                                        <option value="processing" {{ $txn->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="success"    {{ $txn->status == 'success'    ? 'selected' : '' }}>Success</option>
                                        <option value="failed"     {{ $txn->status == 'failed'     ? 'selected' : '' }}>Failed</option>
                                        <option value="reversed"   {{ $txn->status == 'reversed'   ? 'selected' : '' }}>Reversed</option>
                                    </select>
                                </form>
                                @endif

                                @if($txn->status === 'failed')
                                <form method="POST" action="{{ route('transactions.retry', $txn) }}">
                                    @csrf
                                    <button type="submit"
                                            class="text-xs bg-orange-50 text-orange-600 border border-orange-200 px-2 py-1 rounded-lg hover:bg-orange-100 transition font-medium">
                                        Retry
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-400 text-sm font-medium">No transactions found</p>
                                <a href="{{ route('transactions.create') }}"
                                   class="text-blue-600 text-sm hover:underline">Create your first transaction →</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if($transactions->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $transactions->links() }}
            </div>
            @endif
        </div>

    </div>
</div>
</x-app-layout>