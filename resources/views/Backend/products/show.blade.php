<x-app-layout>
    <div class="min-h-screen bg-slate-50/70 py-4">
        <div class="mx-auto max-w-6xl">
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <a href="{{ route('backend.products.index') }}"
                       class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:bg-slate-50 hover:text-slate-800"
                       title="Back to list">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                        </svg>
                    </a>

                    <div>
                        <h1 class="text-lg font-bold text-slate-800">Product Details</h1>
                        <p class="text-xs text-slate-500">Viewing information about this product</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('backend.products.edit', $product) }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-amber-500 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-amber-500/20 transition hover:-translate-y-0.5 hover:bg-amber-600">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="m16.862 4.487 2.651 2.651M4 20l4.5-1 11.013-11.013a1.875 1.875 0 0 0-2.652-2.652L5.848 16.348 4 20z"/>
                        </svg>
                        Edit
                    </a>

                    <form action="{{ route('backend.products.destroy', $product) }}"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this product?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-red-600/20 transition hover:-translate-y-0.5 hover:bg-red-700">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M6 7h12m-11 0 .7 12h7.6l.7-12M9 7V4h6v3m-4 4v5m2-5v5"/>
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="grid grid-cols-1 gap-0 lg:grid-cols-5">
                    <div class="lg:col-span-2 border-b border-slate-100 bg-slate-50/60 p-6 lg:border-b-0 lg:border-r">
                        <div class="sticky top-6">
                            @if($product->image)
                                {{-- FIXED: full image visible, no crop --}}
                                <div class="flex aspect-square w-full items-center justify-center overflow-hidden rounded-2xl bg-slate-100 ring-1 ring-slate-200">
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         alt="{{ $product->name }}"
                                         class="max-h-full max-w-full object-contain">
                                </div>
                            @else
                                <div class="flex aspect-square w-full items-center justify-center rounded-2xl bg-white text-slate-300 ring-1 ring-slate-200">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="h-14 w-14" fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor" stroke-width="1.2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M4.5 19.5h15a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5h-15A1.5 1.5 0 0 0 3 6v12a1.5 1.5 0 0 0 1.5 1.5z"/>
                                        </svg>
                                        <span class="text-xs font-medium text-slate-400">No image uploaded</span>
                                    </div>
                                </div>
                            @endif

                            <div class="mt-4 rounded-2xl border border-slate-200 bg-white p-4">
                                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Price</p>

                                <div class="mt-2 flex items-baseline gap-2">
                                    <span class="text-2xl font-bold text-emerald-600">
                                        ৳ {{ number_format($product->new_price, 2) }}
                                    </span>
                                    @if($product->old_price > 0)
                                        <span class="text-sm text-slate-400 line-through">
                                            ৳ {{ number_format($product->old_price, 2) }}
                                        </span>
                                    @endif
                                </div>

                                @if($product->old_price > 0 && $product->new_price < $product->old_price)
                                    @php
                                        $discount = round((($product->old_price - $product->new_price) / $product->old_price) * 100);
                                    @endphp
                                    <span class="mt-2 inline-flex items-center gap-1 rounded-full bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700 ring-1 ring-inset ring-rose-200">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor" stroke-width="2.2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3"/>
                                        </svg>
                                        {{ $discount }}% off
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-3 p-6">
                        {{-- Name & status --}}
                        <div class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-100 pb-5">
                            <div class="min-w-0">
                                <h2 class="text-2xl font-bold text-slate-800">{{ $product->name }}</h2>
                                <p class="mt-1 font-mono text-xs text-slate-400">
                                    slug: {{ $product->slug }}
                                </p>
                            </div>

                            @if($product->status)
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600 ring-1 ring-inset ring-slate-200">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                    Inactive
                                </span>
                            @endif
                        </div>

                        <dl class="grid grid-cols-1 gap-4 py-5 sm:grid-cols-2">
                            <div>
                                <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Category</dt>
                                <dd class="mt-1.5">
                                    <a href="{{ $product->category ? route('backend.categories.show', $product->category) : '#' }}"
                                       class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-200 transition hover:bg-indigo-100">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M3.75 6.75h16.5v12.5H3.75zM3.75 10.5h16.5M8 6.75V4.5h8v2.25"/>
                                        </svg>
                                        {{ $product->category?->name ?? '—' }}
                                    </a>
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Subcategory</dt>
                                <dd class="mt-1.5">
                                    <a href="{{ $product->subcategory ? route('backend.subcategories.show', $product->subcategory) : '#' }}"
                                       class="inline-flex items-center gap-1.5 rounded-full bg-sky-50 px-3 py-1.5 text-xs font-semibold text-sky-700 ring-1 ring-inset ring-sky-200 transition hover:bg-sky-100">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M3.75 6.75h16.5v12.5H3.75zM3.75 10.5h16.5M8 6.75V4.5h8v2.25"/>
                                        </svg>
                                        {{ $product->subcategory?->name ?? '—' }}
                                    </a>
                                </dd>
                            </div>
                        </dl>

                        <div class="border-t border-slate-100 py-5">
                            <dt class="mb-2 text-xs font-bold uppercase tracking-wider text-slate-500">Description</dt>
                            <dd class="whitespace-pre-line text-sm leading-relaxed text-slate-700">
                                {{ $product->description ?: '— No description provided.' }}
                            </dd>
                        </div>

                        <div class="border-t border-slate-100 pt-5">
                            <dt class="mb-3 text-xs font-bold uppercase tracking-wider text-slate-500">Metadata</dt>

                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                <div class="flex items-center justify-between rounded-xl bg-slate-50 px-4 py-3 text-sm ring-1 ring-slate-100">
                                    <span class="text-slate-500">Product ID</span>
                                    <span class="font-mono text-xs font-semibold text-slate-700">#{{ $product->id }}</span>
                                </div>

                                <div class="flex items-center justify-between rounded-xl bg-slate-50 px-4 py-3 text-sm ring-1 ring-slate-100">
                                    <span class="text-slate-500">Created</span>
                                    <span class="text-slate-700">
                                        {{ $product->created_at->format('d M, Y · h:i A') }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between rounded-xl bg-slate-50 px-4 py-3 text-sm ring-1 ring-slate-100 sm:col-span-2">
                                    <span class="text-slate-500">Last updated</span>
                                    <span class="text-slate-700">
                                        {{ $product->updated_at->format('d M, Y · h:i A') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-3">
                <a href="{{ route('backend.products.index') }}"
                   class="rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    Back to List
                </a>

                <a href="{{ route('backend.products.edit', $product) }}"
                   class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/20 transition hover:bg-indigo-700">
                    Edit Product
                </a>
            </div>
        </div>
    </div>
</x-app-layout>