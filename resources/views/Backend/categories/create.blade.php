<x-app-layout>
    <div class="min-h-screen py-4">
        <div class="mx-auto max-w-6xl">
            <div class="rounded-xl bg-white shadow-xl ring-1 ring-slate-200">
                <form action="{{ route('backend.categories.store') }}" method="POST" class="p-6">
                    @csrf

                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        <div>
                            <div class="mb-6">
                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Name <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="Enter category name..."
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 @error('name') border-red-500 focus:ring-red-100 @enderror"
                                />
                                <p class="mt-1 text-xs text-slate-500">Slug will be auto-generated from the name.</p>

                                @error('name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label class="mb-2 block text-sm font-semibold text-slate-700">Description</label>

                                <textarea
                                    name="description"
                                    rows="5"
                                    placeholder="Write a short description..."
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 @error('description') border-red-500 focus:ring-red-100 @enderror"
                                >{{ old('description') }}</textarea>

                                @error('description')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <div class="mb-6">
                                <label class="mb-2 block text-sm font-semibold text-slate-700">Status</label>
                                <div class="flex flex-wrap gap-3">
                                    <label class="inline-flex cursor-pointer items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:border-indigo-300 hover:bg-indigo-50/40 has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50 has-[:checked]:text-indigo-700">
                                        <input type="radio" name="status" value="1" @checked(old('status', 1) == 1) class="h-4 w-4 accent-indigo-600" />
                                        Active
                                    </label>

                                    <label class="inline-flex cursor-pointer items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:border-indigo-300 hover:bg-indigo-50/40 has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50 has-[:checked]:text-indigo-700">
                                        <input type="radio" name="status" value="0" @checked(old('status', 1) == 0) class="h-4 w-4 accent-indigo-600" />
                                        Inactive
                                    </label>
                                </div>

                                @error('status')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
                        <a href="{{ route('backend.categories.index') }}"
                           class="rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                            Cancel
                        </a>

                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/20 transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200 active:scale-[0.98]"
                        >
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>