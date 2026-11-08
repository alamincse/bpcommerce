@php
    $hasDiscount = $product->old_price > 0 && $product->new_price < $product->old_price;
    $discount = $hasDiscount
        ? round((($product->old_price - $product->new_price) / $product->old_price) * 100)
        : 0;
@endphp

<a href="{{ route('home.products.show', $product->slug) }}"
   class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-indigo-200 hover:shadow-lg">
    <div class="relative flex aspect-square w-full items-center justify-center overflow-hidden bg-slate-100">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}"
                 alt="{{ $product->name }}"
                 loading="lazy"
                 class="max-h-full max-w-full object-contain transition duration-300 group-hover:scale-105">
        @else
            <div class="flex h-full w-full items-center justify-center text-slate-300">
                <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="1.2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M4.5 19.5h15a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5h-15A1.5 1.5 0 0 0 3 6v12a1.5 1.5 0 0 0 1.5 1.5z"/>
                </svg>
            </div>
        @endif

        @if($hasDiscount)
            <span class="absolute left-3 top-3 inline-flex items-center gap-1 rounded-full bg-rose-600 px-2.5 py-1 text-[11px] font-bold text-white shadow-lg shadow-rose-600/30">
                -{{ $discount }}%
            </span>
        @endif
    </div>

    {{-- Info --}}
    <div class="flex flex-1 flex-col gap-1 p-4">
        <p class="text-[11px] font-semibold uppercase tracking-wider text-indigo-600">
            {{ $product->subcategory?->name ?? $product->category?->name ?? 'Product' }}
        </p>

        <h3 class="line-clamp-2 text-sm font-semibold text-slate-800 transition group-hover:text-indigo-600">
            {{ $product->name }}
        </h3>

        <div class="mt-auto flex items-baseline gap-2 pt-2">
            <span class="text-base font-extrabold text-emerald-600">
                ৳ {{ number_format($product->new_price, 0) }}
            </span>

            @if($hasDiscount)
                <span class="text-xs text-slate-400 line-through">
                    ৳ {{ number_format($product->old_price, 0) }}
                </span>
            @endif
        </div>
    </div>
</a>