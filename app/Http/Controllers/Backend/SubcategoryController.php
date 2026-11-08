<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\SubcategoryRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Subcategory;
use Illuminate\View\View;
use App\Models\Category;
use Throwable;

class SubcategoryController extends Controller
{
    public function index(): View
    {
        $pager = config('settings.pager');

        $subcategories = Subcategory::with('category')
                            ->withCount('products')
                            ->latest()
                            ->paginate($pager);

        return view('backend.subcategories.index', compact('subcategories'));
    }

    public function create(): View
    {
        $categories = Category::active()->orderBy('name')->get();

        return view('backend.subcategories.create', compact('categories'));
    }

    public function store(SubcategoryRequest $request): RedirectResponse 
    {
        try {
            $categoryId = data_get($request, 'category_id');
            $slug = data_get($request, 'slug');
            $name = data_get($request, 'name');
            $description = data_get($request, 'description');
            $status = data_get($request, 'status');

            $data = [
                'category_id' => $categoryId,
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'status' => $status,
            ];

            Subcategory::create($data);

            return redirect()
                ->route('backend.subcategories.index')
                ->with('success', 'Subcategory created successfully.');
        } catch (Throwable $e) {
            Log::error('Subcategory create error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Failed to created Subcategory. Please try again.');
        }
    }

    public function show(Subcategory $subcategory): View
    {
        $subcategory->load([
            'category',
            'products',
        ]);

        return view('backend.subcategories.show', compact('subcategory'));
    }

    public function edit(Subcategory $subcategory): View
    {
        $categories = Category::active()->orderBy('name')->get();

        return view('backend.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(SubcategoryRequest $request, Subcategory $subcategory): RedirectResponse 
    {
        try {
            $categoryId = data_get($request, 'category_id');
            $slug = data_get($request, 'slug');
            $name = data_get($request, 'name');
            $description = data_get($request, 'description');
            $status = data_get($request, 'status');

            $data = [
                'category_id' => $categoryId,
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'status' => $status,
            ];

            $subcategory->update($data);

            return redirect()
                ->route('backend.subcategories.index')
                ->with('success', 'Subcategory updated successfully.');
        } catch (Throwable $e) {
            Log::error('Subcategory update error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Failed to updated Subcategory. Please try again.');
        }
    }

    public function destroy(Subcategory $subcategory): RedirectResponse 
    {
        try {
            return DB::transaction(function () use ($subcategory) {
                $subcategory = Subcategory::lockForUpdate()->find($subcategory->id);

                if ($subcategory->products()->exists()) {
                    return back()->with('error', 'Cannot delete: subcategory has products.');
                }

                $subcategory->delete();

                return redirect()
                    ->route('backend.subcategories.index')
                    ->with('success', 'Subcategory deleted successfully.');
            });
        } catch (Throwable $e) {
            Log::error('Subcategory delete error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Failed to deleted Subcategory. Please try again.');
        }
    }
}
