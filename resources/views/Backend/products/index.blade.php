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

            @if($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <ul class="list-inside list-disc space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex items-center justify-end border-b border-slate-100 px-6 py-4">
                    <a href="{{ route('backend.products.create') }}"
                       class="rounded-lg bg-emerald-600 px-3 py-2 text-sm font-semibold text-white shadow-lg shadow-emerald-600/20 transition hover:-translate-y-0.5 hover:bg-emerald-700">
                        Add Product
                    </a>
                </div>

                {{-- Products Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[1000px] text-left">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/80">
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Product</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Category</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Subcategory</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Price</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Status</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Created</th>
                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse($products as $product)
                                <tr class="group transition hover:bg-slate-50/80">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}"
                                                     alt="{{ $product->name }}"
                                                     class="h-11 w-11 shrink-0 rounded-lg object-cover ring-1 ring-slate-200">
                                            @else
                                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-400 ring-1 ring-slate-200">
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor" stroke-width="1.6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M4.5 19.5h15a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5h-15A1.5 1.5 0 0 0 3 6v12a1.5 1.5 0 0 0 1.5 1.5z"/>
                                                    </svg>
                                                </div>
                                            @endif

                                            <div class="min-w-0">
                                                <p class="truncate font-medium text-slate-800">{{ $product->name }}</p>
                                                <p class="mt-0.5 truncate font-mono text-xs text-slate-400">{{ $product->slug }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-200">
                                            {{ $product->category?->name ?? '—' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-50 px-3 py-1.5 text-xs font-semibold text-sky-700 ring-1 ring-inset ring-sky-200">
                                            {{ $product->subcategory?->name ?? '—' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            @if($product->old_price > 0)
                                                <span class="text-xs text-slate-400 line-through">
                                                    ৳ {{ number_format($product->old_price, 2) }}
                                                </span>
                                            @endif
                                            <span class="text-sm font-semibold text-emerald-600">
                                                ৳ {{ number_format($product->new_price, 2) }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
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
                                    </td>

                                    <td class="px-6 py-4">
                                        <p class="text-sm font-medium text-slate-700">
                                            {{ $product->created_at->format('d M, Y') }}
                                        </p>
                                        <p class="mt-1 text-xs text-slate-400">
                                            {{ $product->created_at->format('h:i A') }}
                                        </p>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('backend.products.show', $product) }}"
                                               title="View product"
                                               class="inline-flex h-6 w-6 items-center justify-center rounded-lg text-slate-500 transition hover:bg-indigo-50 hover:text-indigo-600">
                                                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                                                     stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M2.25 12s3.5-7 9.75-7 9.75 7 9.75 7-3.5 7-9.75 7-9.75-7-9.75-7z"/>
                                                    <circle cx="12" cy="12" r="3"/>
                                                </svg>
                                            </a>

                                            <a href="{{ route('backend.products.edit', $product) }}"
                                               title="Edit product"
                                               class="inline-flex h-6 w-6 items-center justify-center rounded-lg text-slate-500 transition hover:bg-amber-50 hover:text-amber-600">
                                                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                                                     stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="m16.862 4.487 2.651 2.651M4 20l4.5-1 11.013-11.013a1.875 1.875 0 0 0-2.652-2.652L5.848 16.348 4 20z"/>
                                                </svg>
                                            </a>

                                            <form action="{{ route('backend.products.destroy', $product) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        title="Delete product"
                                                        class="inline-flex h-6 w-6 items-center justify-center rounded-lg text-slate-500 transition hover:bg-red-50 hover:text-red-600">
                                                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor" stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M6 7h12m-11 0 .7 12h7.6l.7-12M9 7V4h6v3m-4 4v5m2-5v5"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-20 text-center">
                                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M4.5 19.5h15a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5h-15A1.5 1.5 0 0 0 3 6v12a1.5 1.5 0 0 0 1.5 1.5z"/>
                                            </svg>
                                        </div>

                                        <h3 class="mt-5 text-base font-bold text-slate-800">
                                            No products yet
                                        </h3>
                                        <p class="mt-2 text-sm text-slate-500">
                                            Get started by creating your first product.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($products->hasPages())
                    <div class="border-t border-slate-100 px-6 py-4">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>