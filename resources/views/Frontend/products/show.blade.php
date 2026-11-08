@extends('layouts.frontend')

@section('title', $product->name . ' — ' . config('app.name', 'Shop'))
@section('description', \Illuminate\Support\Str::limit(strip_tags($product->description ?? $product->name), 155))

@section('content')
    @php
        $hasDiscount = $product->old_price > 0 && $product->new_price < $product->old_price;
        $discount = $hasDiscount
            ? round((($product->old_price - $product->new_price) / $product->old_price) * 100)
            : 0;
    @endphp

    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6">

        {{-- Breadcrumb --}}
        <nav class="mb-6 flex items-center gap-2 text-sm text-slate-500">
            <a href="{{ route('home.index') }}" class="transition hover:text-indigo-600">Home</a>
            <span class="text-slate-300">/</span>
            <span class="text-slate-500">{{ $product->category?->name ?? 'Category' }}</span>
            <span class="text-slate-300">/</span>
            <span class="text-slate-500">{{ $product->subcategory?->name ?? 'Subcategory' }}</span>
            <span class="text-slate-300">/</span>
            <span class="truncate font-semibold text-slate-800">{{ $product->name }}</span>
        </nav>

        {{-- Product main --}}
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
            {{-- Image — FIXED: full image visible, no crop --}}
            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                @if($product->image)
                    <div class="flex aspect-square w-full items-center justify-center overflow-hidden bg-slate-100">
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="max-h-full max-w-full object-contain">
                    </div>
                @else
                    <div class="flex aspect-square w-full items-center justify-center bg-slate-100 text-slate-300">
                        <svg class="h-20 w-20" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="1.2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M4.5 19.5h15a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5h-15A1.5 1.5 0 0 0 3 6v12a1.5 1.5 0 0 0 1.5 1.5z"/>
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Details --}}
            <div class="flex flex-col">
                {{-- Category pill --}}
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-200">
                        {{ $product->category?->name ?? '—' }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-700 ring-1 ring-inset ring-sky-200">
                        {{ $product->subcategory?->name ?? '—' }}
                    </span>
                </div>

                {{-- Name --}}
                <h1 class="mt-4 text-3xl font-extrabold leading-tight tracking-tight text-slate-900">
                    {{ $product->name }}
                </h1>

                {{-- Price --}}
                <div class="mt-5 flex flex-wrap items-baseline gap-3">
                    <span class="text-4xl font-extrabold text-emerald-600">
                        ৳ {{ number_format($product->new_price, 2) }}
                    </span>

                    @if($hasDiscount)
                        <span class="text-lg text-slate-400 line-through">
                            ৳ {{ number_format($product->old_price, 2) }}
                        </span>
                        <span class="inline-flex items-center gap-1 rounded-full bg-rose-50 px-2.5 py-1 text-xs font-bold text-rose-700 ring-1 ring-inset ring-rose-200">
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2.4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3"/>
                            </svg>
                            {{ $discount }}% OFF
                        </span>
                    @endif
                </div>

                {{-- Description --}}
                <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-5">
                    <h2 class="mb-2 text-xs font-bold uppercase tracking-wider text-slate-500">
                        Description
                    </h2>

                    @if($product->description)
                        <p class="whitespace-pre-line text-sm leading-relaxed text-slate-700">
                            {{ $product->description }}
                        </p>
                    @else
                        <p class="text-sm italic text-slate-500">No description provided.</p>
                    @endif
                </div>

                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('home.index') }}"
                       class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                        </svg>
                        Back to Shop
                    </a>
                </div>
            </div>
        </div>

        {{-- Related products --}}
        @if($related->isNotEmpty())
            <section class="mt-16">
                <div class="mb-6 flex flex-wrap items-end justify-between gap-3 border-b border-slate-200 pb-3">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-indigo-600">You may also like</p>
                        <h2 class="mt-1 text-2xl font-extrabold tracking-tight text-slate-900">
                            More from {{ $product->subcategory?->name ?? 'this category' }}
                        </h2>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                    @foreach($related as $relatedProduct)
                        @include('frontend.partials.product-card', ['product' => $relatedProduct])
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection