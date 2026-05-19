<x-app-layout>
<x-slot name="header">
    <div class="flex items-center gap-3">
        <a href="{{ route('employees.show', $employee) }}" class="p-2 rounded-xl hover:bg-slate-100 text-slate-500 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold outfit text-slate-800">Documents — {{ $employee->user?->name ?? 'Unknown' }}</h1>
            <p class="text-sm text-slate-500 mt-0.5">{{ $employee->employee_code }} · {{ $employee->department->name ?? '' }}</p>
        </div>
    </div>
</x-slot>

<div class="py-8 px-4 max-w-5xl mx-auto space-y-6 ani-1">

    @if(session('success'))
    <div class="flex items-center gap-3 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="flex items-center gap-3 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm font-medium">
        {{ session('error') }}
    </div>
    @endif

    {{-- Upload Form --}}
    <div class="glass-card rounded-2xl p-6">
        <h2 class="font-bold text-slate-800 outfit text-lg mb-5">Upload New Document</h2>
        <form method="POST" action="{{ route('employee-documents.store', $employee) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Document Type <span class="text-red-500">*</span></label>
                    <select name="document_type" required class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent bg-white">
                        <option value="">— Select Type —</option>
                        @foreach(\App\Models\EmployeeDocument::$types as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('document_type') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">File <span class="text-red-500">*</span></label>
                    <input type="file" name="document_file" required accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                        class="w-full text-sm text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-teal-50 file:text-teal-700 file:font-semibold hover:file:bg-teal-100 file:transition-colors border border-slate-200 rounded-xl p-1.5">
                    <p class="text-xs text-slate-400 mt-1">PDF, JPG, PNG, DOC — max 10 MB</p>
                    @error('document_file') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm rounded-xl transition-all btn-primary">
                    Upload Document
                </button>
            </div>
        </form>
    </div>

    {{-- Document List --}}
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-bold text-slate-800 outfit">Uploaded Documents</h2>
            <span class="text-sm text-slate-400">{{ $documents->count() }} file{{ $documents->count()===1?'':'s' }}</span>
        </div>

        @if($documents->isEmpty())
        <div class="py-12 text-center text-slate-400">
            <p class="text-3xl mb-2">📂</p>
            <p class="font-medium">No documents uploaded yet</p>
        </div>
        @else
        <div class="divide-y divide-slate-50">
            @foreach($documents as $doc)
            <div class="flex items-center gap-4 px-5 py-4 hover:bg-slate-50/50 transition-colors">
                <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-xl shrink-0">
                    {{ \App\Models\EmployeeDocument::$icons[$doc->document_type] ?? '📎' }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-slate-800 truncate">{{ $doc->original_name }}</p>
                    <p class="text-xs text-slate-400">
                        {{ $doc->typeLabel() }} ·
                        {{ $doc->humanSize() }} ·
                        Uploaded by {{ $doc->uploader?->name ?? 'System' }} on {{ $doc->created_at->format('d M Y') }}
                    </p>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <a href="{{ route('employee-documents.download', $doc) }}"
                        class="px-3 py-1.5 text-xs font-semibold text-teal-700 border border-teal-200 hover:bg-teal-50 rounded-lg transition-all">
                        ↓ Download
                    </a>
                    <form method="POST" action="{{ route('employee-documents.destroy', $doc) }}" onsubmit="return confirm('Delete this document?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-red-600 border border-red-200 hover:bg-red-50 rounded-lg transition-all">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

</div>
</x-app-layout>
