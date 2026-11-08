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
                    <a href="{{ route('backend.subcategories.create') }}"
                       class="rounded-lg bg-emerald-600 px-3 py-2 text-sm font-semibold text-white shadow-lg shadow-emerald-600/20 transition hover:-translate-y-0.5 hover:bg-emerald-700">
                        Add Subcategory
                    </a>
                </div>

                {{-- Subcategories Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[900px] text-left">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/80">
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Subcategory
                                </th>

                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Category
                                </th>

                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Slug
                                </th>

                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Description
                                </th>

                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Created
                                </th>

                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse($subcategories as $subcategory)
                                <tr class="group transition hover:bg-slate-50/80">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="font-medium text-slate-800">
                                                {{ $subcategory->name }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-200">
                                            {{ $subcategory->category?->name ?? '—' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="rounded-lg px-2.5 py-1.5 font-mono text-xs text-slate-600">
                                            {{ $subcategory->slug }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="rounded-lg px-2.5 py-1.5 font-mono text-xs text-slate-600">
                                            {{ $subcategory->description ?? '—' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($subcategory->status)
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
                                            {{ $subcategory->created_at->format('d M, Y') }}
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            {{ $subcategory->created_at->format('h:i A') }}
                                        </p>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('backend.subcategories.show', $subcategory) }}"
                                               title="View subcategory"
                                               class="inline-flex h-6 w-6 items-center justify-center rounded-lg text-slate-500 transition hover:bg-indigo-50 hover:text-indigo-600">
                                                <svg class="h-4.5 w-4.5" fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor"
                                                     stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M2.25 12s3.5-7 9.75-7 9.75 7 9.75 7-3.5 7-9.75 7-9.75-7-9.75-7z"/>
                                                    <circle cx="12" cy="12" r="3"/>
                                                </svg>
                                            </a>

                                            <a href="{{ route('backend.subcategories.edit', $subcategory) }}"
                                               title="Edit subcategory"
                                               class="inline-flex h-6 w-6 items-center justify-center rounded-lg text-slate-500 transition hover:bg-amber-50 hover:text-amber-600">
                                                <svg class="h-4.5 w-4.5" fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor"
                                                     stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="m16.862 4.487 2.651 2.651M4 20l4.5-1 11.013-11.013a1.875 1.875 0 0 0-2.652-2.652L5.848 16.348 4 20z"/>
                                                </svg>
                                            </a>

                                            <form action="{{ route('backend.subcategories.destroy', $subcategory) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this subcategory?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        title="Delete subcategory"
                                                        class="inline-flex h-6 w-6 items-center justify-center rounded-lg text-slate-500 transition hover:bg-red-50 hover:text-red-600">
                                                    <svg class="h-4.5 w-4.5" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor"
                                                         stroke-width="1.8">
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
                                            <svg class="h-8 w-8" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor"
                                                 stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M3.75 6.75h16.5v12.5H3.75zM3.75 10.5h16.5M8 6.75V4.5h8v2.25"/>
                                            </svg>
                                        </div>

                                        <h3 class="mt-5 text-base font-bold text-slate-800">
                                            No subcategories yet
                                        </h3>
                                        <p class="mt-2 text-sm text-slate-500">
                                            Get started by creating your first subcategory.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($subcategories->hasPages())
                    <div class="border-t border-slate-100 px-6 py-4">
                        {{ $subcategories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>