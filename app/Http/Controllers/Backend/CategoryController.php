<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\CategoryRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\Category;
use Throwable;

class CategoryController extends Controller
{
    public function index(): View
    {
        $pager = config('settings.pager');

        $categories = Category::withCount([
                        'subcategories',
                        'products',
                    ])
                    ->latest()
                    ->paginate($pager);

        return view('backend.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('backend.categories.create');
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        try {
            $slug = data_get($request, 'slug');
            $name = data_get($request, 'name');
            $description = data_get($request, 'description');
            $status = data_get($request, 'status');

            $data = [
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'status' => $status,
            ];

            Category::create($data);

            return redirect()
                ->route('backend.categories.index')
                ->with('success', 'Category created successfully.');
        } catch (Throwable $e) {
            Log::error('Category create error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Failed to create Category. Please try again.');
        }
    }

    public function show(Category $category): View
    {
        $category->load([
            'subcategories' => function ($query) {
                $query->withCount('products');
            },
        ]);

        return view('backend.categories.show', compact('category'));
    }

    public function edit(Category $category): View
    {
        return view('backend.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse 
    {
        try {
            $slug = data_get($request, 'slug');
            $name = data_get($request, 'name');
            $description = data_get($request, 'description');
            $status = data_get($request, 'status');

            $data = [
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'status' => $status,
            ];

            $category->update($data);

            return redirect()
                ->route('backend.categories.index')
                ->with('success', 'Category updated successfully.');
        } catch (Throwable $e) {
            Log::error('Category update error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Failed to update Category. Please try again.');
        }
    }

    public function destroy(Category $category): RedirectResponse
    {
        try {
            return DB::transaction(function () use ($category) {
                $category = Category::lockForUpdate()->findOrFail($category->id);

                if ($category->subcategories()->exists()) {
                    return back()->with('error', 'Cannot delete: category has subcategories.');
                }

                if ($category->products()->exists()) {
                    return back()->with('error', 'Cannot delete: category has products.');
                }

                $category->delete();

                return redirect()
                    ->route('backend.categories.index')
                    ->with('success', 'Category deleted successfully.');
            });
        } catch (Throwable $e) {
            Log::error('Category delete error: ' . $e->getMessage());

            return back()->with('error', 'Failed to delete Category. Please try again.');
        }
    }
}
