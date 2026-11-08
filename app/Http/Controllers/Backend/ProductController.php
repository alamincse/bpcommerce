<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\ProductRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Services\FileService;
use App\Models\Subcategory;
use Illuminate\View\View;
use App\Models\Category;
use App\Models\Product;
use Throwable;

class ProductController extends Controller
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function index(): View
    {
        $pager = config('settings.pager');

        $products = Product::with([
                        'category:id,name',
                        'subcategory:id,name,category_id',
                    ])
                    ->latest()
                    ->paginate($pager);

        return view('backend.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::active()->orderBy('name')->get();

        $subcategories = Subcategory::active()->orderBy('name')->get();

        return view('backend.products.create', compact('categories', 'subcategories'));
    }

    public function store(ProductRequest $request): RedirectResponse 
    {
        DB::beginTransaction();

        try {
            $categoryId = data_get($request, 'category_id');
            $subcategoryId = data_get($request, 'subcategory_id');
            $name = data_get($request, 'name');
            $slug = data_get($request, 'slug');
            $description = data_get($request, 'description');
            $oldPrice = (float)data_get($request, 'old_price');
            $newPrice = (float)data_get($request, 'new_price');
            $status = data_get($request, 'status');
            $image = $request->file('image');

            $data = [
                'category_id' => $categoryId,
                'subcategory_id' => $subcategoryId,
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'old_price' => $oldPrice,
                'new_price' => $newPrice,
                'status' => $status,
            ];

            if (! empty($image)) {
                $data['image'] = $this->fileService->upload($image, 'products');
            }

            Product::create($data);
            
            DB::commit();

            return redirect()
                ->route('backend.products.index')
                ->with('success', 'Product created successfully.');
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Product store error: ' . $e->getMessage());

            if (! empty($data['image'] ?? null)) {
                $this->fileService->delete($data['image']);
            }

            return back()
                ->withInput()
                ->with('error', 'Failed to create Product. Please try again.');
        }
    }

    public function show(Product $product): View
    {
        $product->load([
            'category',
            'subcategory',
        ]);

        return view('backend.products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $categories = Category::active()->orderBy('name')->get();

        $subcategories = Subcategory::active()->orderBy('name')->get();

        return view('backend.products.edit', compact('product', 'categories', 'subcategories'));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse 
    {
        DB::beginTransaction();

        try {
            $categoryId = data_get($request, 'category_id');
            $subcategoryId = data_get($request, 'subcategory_id');
            $name = data_get($request, 'name');
            $slug = data_get($request, 'slug');
            $description = data_get($request, 'description');
            $oldPrice = (float)data_get($request, 'old_price');
            $newPrice = (float)data_get($request, 'new_price');
            $status = data_get($request, 'status');
            $image = $request->file('image');

            $oldImage = $product->image;

            $data = [
                'category_id' => $categoryId,
                'subcategory_id' => $subcategoryId,
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'old_price' => $oldPrice,
                'new_price' => $newPrice,
                'status' => $status,
            ];

            if (! empty($image)) {
                $data['image'] = $this->fileService->upload($image, 'products');
            }

            $product->update($data);

            DB::commit();

            if ($image && $oldImage) {
                try {
                    $this->fileService->delete($oldImage);
                } catch (Throwable $e) {
                    Log::warning('Old image delete failed: ' . $e->getMessage());
                }
            }

            return redirect()
                ->route('backend.products.index')
                ->with('success', 'Product updated successfully.');
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Product update error: ' . $e->getMessage());

            if (! empty($data['image'] ?? null)) {
                $this->fileService->delete($data['image']);
            }

            return back()
                ->withInput()
                ->with('error', 'Failed to updated Product. Please try again.');
        }
    }

    public function destroy(Product $product): RedirectResponse
    {
        $image = $product->image;

        try {
            $product->delete();
        } catch (Throwable $e) {
            Log::error('Product delete error: ' . $e->getMessage());

            return back()->with('error', 'Failed to delete Product. Please try again.');
        }

        if ($image) {
            try {
                $this->fileService->delete($image);
            } catch (Throwable $e) {
                Log::warning('Product image delete failed: ' . $e->getMessage());
            }
        }

        return redirect()
                ->route('backend.products.index')
                ->with('success', 'Product deleted successfully.');
    }
}
