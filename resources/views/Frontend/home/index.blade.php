@extends('layouts.frontend')
@section('title', config('app.name', 'eCommerce') . ' — Discover Products')
@section('content')
    <section class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-indigo-700 to-violet-700">
        <div class="absolute inset-0 opacity-20"
            style="background-image: radial-gradient(circle at 20% 20%, #fff 0, transparent 40%), radial-gradient(circle at 80% 0%, #a5b4fc 0, transparent 35%);"></div>
        <div class="relative mx-auto max-w-6xl px-4 py-16 sm:px-6 sm:py-24">
            <div class="max-w-2xl">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-indigo-100 ring-1 ring-inset ring-white/20">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                    New arrivals every week
                </span>

                <h1 class="mt-4 text-4xl font-extrabold leading-tight tracking-tight text-white sm:text-5xl">
                    Discover products<br>you'll actually love.
                </h1>

                <p class="mt-4 max-w-xl text-base text-indigo-100">
                    Curated picks across every category — fast delivery, honest prices, no surprises.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#products"
                       class="rounded-xl bg-white px-5 py-3 text-sm font-bold text-indigo-700 shadow-lg shadow-indigo-900/20 transition hover:-translate-y-0.5 hover:bg-slate-50">
                        Browse Products
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Products grouped by subcategory --}}
    <section id="products" class="mx-auto max-w-6xl px-4 py-14 sm:px-6">
        @forelse($subcategories as $subcategory)
            <div class="{{ $loop->first ? '' : 'mt-16' }}">
                <div class="mb-6 flex flex-wrap items-end justify-between gap-3 border-b border-slate-200 pb-3">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-indigo-600">
                            {{ $subcategory->category?->name ?? 'Category' }}
                        </p>
                        
                        <h2 class="mt-1 text-2xl font-extrabold tracking-tight text-slate-900">
                            {{ $subcategory->name }}
                        </h2>
                    </div>

                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                        {{ $subcategory->products_count }}
                        {{ str()->plural('item', $subcategory->products_count) }}
                    </span>
                </div>

                {{-- Product grid --}}
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                    @foreach($subcategory->products as $product)
                        @include('frontend.partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        @empty
            {{-- Empty state --}}
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white py-20 text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"/>
                    </svg>
                </div>
                <h3 class="mt-5 text-lg font-bold text-slate-800">No products yet</h3>
                <p class="mt-2 text-sm text-slate-500">
                    Check back soon — new items are on the way.
                </p>
            </div>
        @endforelse

        @if($subcategories->hasPages())
            <div class="mt-12">
                {{ $subcategories->links() }}
            </div>
        @endif
    </section>
@endsection