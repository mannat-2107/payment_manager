<x-app-layout>
    <div class="min-h-screen bg-slate-50 font-sans pb-12">
        {{-- Header --}}
        <div class="bg-white border-b border-slate-200 px-4 sm:px-6 lg:px-8 py-6 sticky top-16 z-40 shadow-sm">
            <div class="max-w-3xl mx-auto flex items-center gap-4">
                <a href="{{ route('departments.index') }}" class="p-2 bg-slate-50 text-slate-500 rounded-lg hover:bg-slate-100 hover:text-slate-800 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h2 class="text-2xl font-bold text-slate-800 font-outfit tracking-tight">Edit Department</h2>
                    <p class="text-sm text-slate-500 mt-1 font-medium">Update details for <span class="text-slate-700 font-bold">{{ $department->name }}</span></p>
                </div>
            </div>
        </div>

        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 slide-in">
            @if($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-700 px-5 py-4 rounded-xl mb-6 shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-1.5 bg-rose-100 rounded-lg">
                            <svg class="w-5 h-5 flex-shrink-0 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="font-bold text-sm">Please correct the following errors:</p>
                    </div>
                    <ul class="list-disc pl-12 text-sm font-medium space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="p-6 md:p-8">
                    <form method="POST" action="{{ route('departments.update', $department) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Department Name <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $department->name) }}" required
                                   class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent text-slate-800 font-medium bg-slate-50 focus:bg-white transition-colors">
                        </div>

                        <div class="mb-8">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Description <span class="text-slate-400 font-normal lowercase tracking-normal">(optional)</span></label>
                            <textarea name="description" rows="4"
                                      class="w-full p-4 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent text-slate-700 font-medium bg-slate-50 focus:bg-white transition-colors resize-none">{{ old('description', $department->description) }}</textarea>
                        </div>

                        <div class="flex items-center gap-4 pt-6 border-t border-slate-100">
                            <button type="submit"
                                    class="btn-primary flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-500 to-emerald-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-teal-500/30">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Save Changes
                            </button>
                            <a href="{{ route('departments.index') }}"
                               class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition-colors">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>