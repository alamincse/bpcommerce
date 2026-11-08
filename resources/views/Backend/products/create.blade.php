<x-app-layout>
    <div class="min-h-screen py-4">
        <div class="mx-auto max-w-6xl">
            <div class="rounded-xl bg-white shadow-xl ring-1 ring-slate-200">
                <form action="{{ route('backend.products.store') }}" method="POST"
                    enctype="multipart/form-data" class="p-6">
                    @csrf

                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        <div>
                            <div class="mb-6">
                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Category <span class="text-red-500">*</span>
                                </label>

                                <select id="category_id" name="category_id"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 @error('category_id') border-red-500 focus:ring-red-100 @enderror">
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('category_id')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Subcategory <span class="text-red-500">*</span>
                                </label>

                                <select id="subcategory_id" name="subcategory_id"
                                    @disabled(! old('category_id'))
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-400 @error('subcategory_id') border-red-500 focus:ring-red-100 @enderror">
                                    <option value="">Select a subcategory</option>
                                    @foreach($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}"
                                            data-category="{{ $subcategory->category_id }}"
                                            @selected(old('subcategory_id') == $subcategory->id)
                                        >
                                            {{ $subcategory->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <p id="subcategory-hint" class="mt-1 text-xs text-slate-500 {{ old('category_id') ? 'hidden' : '' }}">
                                    Pick a category first to enable this list.
                                </p>

                                @error('subcategory_id')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Name <span class="text-red-500">*</span>
                                </label>

                                <input type="text" name="name" value="{{ old('name') }}"
                                    placeholder="Enter product name..."
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 @error('name') border-red-500 focus:ring-red-100 @enderror" />
                                <p class="mt-1 text-xs text-slate-500">Slug will be auto-generated from the name.</p>

                                @error('name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label class="mb-2 block text-sm font-semibold text-slate-700">Description</label>

                                <textarea name="description" rows="6"
                                    placeholder="Write a detailed description..."
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 @error('description') border-red-500 focus:ring-red-100 @enderror">{{ old('description') }}</textarea>

                                @error('description')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <div class="mb-6">
                                <label class="mb-2 block text-sm font-semibold text-slate-700">Product Image</label>

                                <label for="image"
                                       class="group flex cursor-pointer flex-col items-center justify-center gap-2 rounded-xl border-2 border-dashed border-slate-300 bg-slate-50/50 px-4 py-6 text-center transition hover:border-indigo-400 hover:bg-indigo-50/40">
                                    <div id="image-preview-wrap"
                                         class="hidden flex h-56 w-full items-center justify-center overflow-hidden rounded-lg bg-slate-100 ring-1 ring-slate-200">
                                        <img id="image-preview" alt="Preview"
                                             class="max-h-full max-w-full object-contain" />
                                    </div>

                                    <div id="image-placeholder" class="flex flex-col items-center gap-2 text-slate-500">
                                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 16.5V18a1.5 1.5 0 0 0 1.5 1.5h15A1.5 1.5 0 0 0 21 18v-1.5m-4.5-4.5L12 7.5m0 0L7.5 12M12 7.5v10.5"/>
                                        </svg>
                                        <span class="text-sm font-medium">Click to upload</span>
                                        <span class="text-xs text-slate-400">PNG, JPG, JPEG, WEBP up to 1MB</span>
                                    </div>
                                </label>

                                <input id="image" type="file" name="image" accept="image/*" class="hidden" />

                                @error('image')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6 grid grid-cols-2 gap-4">
                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">Old Price</label>
                                    <div class="relative">
                                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-sm text-slate-400">৳</span>
                                        <input type="number" name="old_price" value="{{ old('old_price', 0) }}"
                                            step="0.01" min="0" placeholder="0.00"
                                            class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-8 pr-4 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 @error('old_price') border-red-500 focus:ring-red-100 @enderror" />
                                    </div>
                                    @error('old_price')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                                        New Price <span class="text-red-500">*</span>
                                    </label>

                                    <div class="relative">
                                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-sm text-slate-400">৳</span>
                                        <input type="number" name="new_price" value="{{ old('new_price', 0) }}"
                                            step="0.01" min="0" placeholder="0.00"
                                            class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-8 pr-4 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 @error('new_price') border-red-500 focus:ring-red-100 @enderror" />
                                    </div>
                                    @error('new_price')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="mb-2 block text-sm font-semibold text-slate-700">Status</label>
                                <div class="flex flex-wrap gap-3">
                                    <label class="inline-flex cursor-pointer items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:border-indigo-300 hover:bg-indigo-50/40 has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50 has-[:checked]:text-indigo-700">
                                        <input type="radio" name="status" value="1"
                                            @checked(old('status', 1) == 1) class="h-4 w-4 accent-indigo-600" />
                                        Active
                                    </label>

                                    <label class="inline-flex cursor-pointer items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:border-indigo-300 hover:bg-indigo-50/40 has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50 has-[:checked]:text-indigo-700">
                                        <input type="radio" name="status" value="0"
                                            @checked(old('status', 1) == 0) class="h-4 w-4 accent-indigo-600" />
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
                        <a href="{{ route('backend.products.index') }}"
                           class="rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                            Cancel
                        </a>

                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/20 transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200 active:scale-[0.98]">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            (function () {
                // Dependent category to subcategory
                const cat = document.getElementById('category_id');
                const sub = document.getElementById('subcategory_id');
                const hint = document.getElementById('subcategory-hint');
                const options = Array.from(sub.querySelectorAll('option[data-category]'));

                function syncSubcategoryState() {
                    const catId = cat.value;
                    const locked = !catId;

                    sub.disabled = locked;
                    if (hint) hint.classList.toggle('hidden', !locked);

                    let keepSelected = false;
                    options.forEach(opt => {
                        const match = locked || opt.dataset.category === catId;
                        opt.hidden = !match;
                        opt.disabled = !match;
                        if (match && opt.value === sub.value) keepSelected = true;
                    });

                    if (!locked && !keepSelected) sub.value = '';
                }

                cat.addEventListener('change', syncSubcategoryState);
                syncSubcategoryState();

                // Image live preview
                const input = document.getElementById('image');
                const previewWrap = document.getElementById('image-preview-wrap');
                const preview = document.getElementById('image-preview');
                const placeholder = document.getElementById('image-placeholder');

                input.addEventListener('change', () => {
                    const file = input.files && input.files[0];
                    if (!file) return;

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        preview.src = e.target.result;
                        previewWrap.classList.remove('hidden');
                        placeholder.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                });
            })();
        </script>
    @endpush
</x-app-layout>