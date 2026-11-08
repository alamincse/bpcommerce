<x-app-layout>
    <div class="min-h-screen py-4">
        <div class="mx-auto max-w-6xl">
            <div class="rounded-xl bg-white shadow-xl ring-1 ring-slate-200">
                <form action="{{ route('backend.subcategories.update', $subcategory) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        <div>
                            <div class="mb-6">
                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Category <span class="text-red-500">*</span>
                                </label>

                                <select
                                    name="category_id"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 @error('category_id') border-red-500 focus:ring-red-100 @enderror"
                                >
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                            @selected(old('category_id', $subcategory->category_id) == $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-slate-500">The parent category this subcategory belongs to.</p>

                                @error('category_id')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Name <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name', $subcategory->name) }}"
                                    placeholder="Enter subcategory name..."
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
                                >{{ old('description', $subcategory->description) }}</textarea>

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
                                        <input type="radio" name="status" value="1"
                                            @checked(old('status', $subcategory->status) == 1)
                                            class="h-4 w-4 accent-indigo-600" />
                                        Active
                                    </label>

                                    <label class="inline-flex cursor-pointer items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:border-indigo-300 hover:bg-indigo-50/40 has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50 has-[:checked]:text-indigo-700">
                                        <input type="radio" name="status" value="0"
                                            @checked(old('status', $subcategory->status) == 0)
                                            class="h-4 w-4 accent-indigo-600" />
                                        Inactive
                                    </label>
                                </div>

                                @error('status')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-4">
                                <h4 class="mb-3 text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Metadata
                                </h4>

                                <dl class="space-y-2 text-sm">
                                    <div class="flex items-center justify-between gap-3">
                                        <dt class="text-slate-500">Slug</dt>
                                        <dd class="rounded-lg bg-white px-2.5 py-1 font-mono text-xs text-slate-700 ring-1 ring-slate-200">
                                            {{ $subcategory->slug }}
                                        </dd>
                                    </div>

                                    <div class="flex items-center justify-between gap-3">
                                        <dt class="text-slate-500">Created</dt>
                                        <dd class="text-slate-700">
                                            {{ $subcategory->created_at->format('d M, Y · h:i A') }}
                                        </dd>
                                    </div>

                                    <div class="flex items-center justify-between gap-3">
                                        <dt class="text-slate-500">Last updated</dt>
                                        <dd class="text-slate-700">
                                            {{ $subcategory->updated_at->format('d M, Y · h:i A') }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
                        <a href="{{ route('backend.subcategories.index') }}"
                           class="rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                            Cancel
                        </a>

                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/20 transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200 active:scale-[0.98]"
                        >
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>