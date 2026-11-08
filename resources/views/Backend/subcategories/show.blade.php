<x-app-layout>
    <div class="min-h-screen bg-slate-50/70 py-4">
        <div class="mx-auto max-w-6xl">
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-800">
                    <ul class="list-inside list-disc space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex flex-col gap-3 border-b border-slate-100 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex min-w-0 items-center gap-3">
                        <a href="{{ route('backend.subcategories.index') }}"
                           class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                            </svg>
                        </a>
                        <div class="min-w-0">
                            <h2 class="truncate text-base font-bold text-slate-900 leading-tight">Subcategory Details</h2>
                            <p class="truncate font-mono text-xs text-slate-600">/{{ $subcategory->slug }}</p>
                        </div>
                    </div>

                    <div class="flex shrink-0 items-center gap-2">
                        <a href="{{ route('backend.subcategories.edit', $subcategory) }}"
                           class="inline-flex items-center gap-2 rounded-xl bg-amber-500 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-amber-500/20 transition hover:-translate-y-0.5 hover:bg-amber-600">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="m16.862 4.487 2.651 2.651M4 20l4.5-1 11.013-11.013a1.875 1.875 0 0 0-2.652-2.652L5.848 16.348 4 20z"/>
                            </svg>
                            Edit
                        </a>

                        <form action="{{ route('backend.subcategories.destroy', $subcategory) }}"
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this subcategory?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg bg-red-600 px-3 py-2 text-sm font-bold text-white shadow-lg shadow-red-600/20 transition hover:-translate-y-0.5 hover:bg-red-700">
                                <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M6 7h12m-11 0 .7 12h7.6l.7-12M9 7V4h6v3m-4 4v5m2-5v5"/>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <div class="border-b border-slate-100">
                    <div class="border-b border-slate-100 bg-slate-50/80 px-6 py-3">
                        <h3 class="text-xs font-bold uppercase text-slate-700">Basic Information</h3>
                    </div>
                    <table class="w-full text-left">
                        <tbody class="divide-y divide-slate-100">
                            <tr>
                                <td class="w-[180px] px-6 py-4 text-xs font-bold uppercase text-slate-700 align-top">
                                    Name
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-slate-900">
                                    {{ $subcategory->name }}
                                </td>
                            </tr>

                            <tr>
                                <td class="w-[180px] px-6 py-4 text-xs font-bold uppercase text-slate-700 align-top">
                                    Parent Category
                                </td>
                                <td class="px-6 py-4">
                                    @if($subcategory->category)
                                        <a href="{{ route('backend.categories.show', $subcategory->category) }}"
                                           class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-3 py-1.5 text-xs font-bold text-indigo-800 ring-1 ring-inset ring-indigo-300 transition hover:bg-indigo-100">
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M3.75 6.75h16.5v12.5H3.75zM3.75 10.5h16.5M8 6.75V4.5h8v2.25"/>
                                            </svg>
                                            {{ $subcategory->category->name }}
                                        </a>
                                    @else
                                        <span class="text-sm italic text-slate-500">— None —</span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td class="w-[180px] px-6 py-4 text-xs font-bold uppercase text-slate-700 align-top">
                                    Slug
                                </td>
                                <td class="px-6 py-4">
                                    <span class="rounded-lg bg-slate-100 px-2.5 py-1.5 font-mono text-xs font-semibold text-slate-800">
                                        {{ $subcategory->slug }}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td class="w-[180px] px-6 py-4 text-xs font-bold uppercase text-slate-700 align-top">
                                    Status
                                </td>
                                <td class="px-6 py-4">
                                    @if($subcategory->status)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-800 ring-1 ring-inset ring-emerald-300">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-700 ring-1 ring-inset ring-slate-300">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-500"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td class="w-[180px] px-6 py-4 text-xs font-bold uppercase text-slate-700 align-top">
                                    Subcategory ID
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-slate-900">
                                    #{{ $subcategory->id }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- DESCRIPTION --}}
                <div class="border-b border-slate-100">
                    <div class="border-b border-slate-100 bg-slate-50/80 px-6 py-3">
                        <h3 class="text-xs font-bold uppercase text-slate-700">Description</h3>
                    </div>

                    <div class="px-6 py-4">
                        @if($subcategory->description)
                            <p class="text-sm leading-relaxed text-slate-800 whitespace-pre-line">{{ $subcategory->description }}</p>
                        @else
                            <p class="text-sm italic text-slate-500">No description provided.</p>
                        @endif
                    </div>
                </div>

                {{-- STATISTICS --}}
                <div class="border-b border-slate-100">
                    <div class="border-b border-slate-100 bg-slate-50/80 px-6 py-3">
                        <h3 class="text-xs font-bold uppercase text-slate-700">Statistics</h3>
                    </div>

                    <table class="w-full text-left">
                        <tbody class="divide-y divide-slate-100">
                            <tr>
                                <td class="w-[180px] px-6 py-4 text-xs font-bold uppercase text-slate-700">
                                    Products
                                </td>

                                <td class="px-6 py-4 text-sm font-semibold text-slate-900">
                                    {{ $subcategory->products()->count() }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- TIMELINE --}}
                <div>
                    <div class="border-b border-slate-100 bg-slate-50/80 px-6 py-3">
                        <h3 class="text-xs font-bold uppercase text-slate-700">Timeline</h3>
                    </div>
                    <table class="w-full text-left">
                        <tbody class="divide-y divide-slate-100">
                            <tr>
                                <td class="w-[180px] px-6 py-4 text-xs font-bold uppercase text-slate-700">
                                    Created
                                </td>

                                <td class="px-6 py-4">
                                    <p class="text-sm font-semibold text-slate-800">{{ $subcategory->created_at->format('d M, Y') }}</p>
                                    <p class="mt-1 text-xs text-slate-500">{{ $subcategory->created_at->format('h:i A') }} · {{ $subcategory->created_at->diffForHumans() }}</p>
                                </td>
                            </tr>

                            <tr>
                                <td class="w-[180px] px-6 py-4 text-xs font-bold uppercase text-slate-700">
                                    Last Updated
                                </td>

                                <td class="px-6 py-4">
                                    <p class="text-sm font-semibold text-slate-800">{{ $subcategory->updated_at->format('d M, Y') }}</p>
                                    <p class="mt-1 text-xs text-slate-500">{{ $subcategory->updated_at->format('h:i A') }} · {{ $subcategory->updated_at->diffForHumans() }}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>