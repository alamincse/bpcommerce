<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\View\View;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(): View
    {
        $pager = config('settings.pager');

        $subcategories = Subcategory::active()
                            ->whereHas('products', fn ($q) => $q->active())
                            ->withCount(['products' => fn ($q) => $q->active()])
                            ->with([
                                'category:id,name,slug',
                                'products' => fn ($q) => $q->active()->latest(),
                            ])
                            ->orderBy('name')
                            ->paginate($pager);

        return view('frontend.home.index', compact('subcategories'));
    }

    public function show(Product $product): View
    {
        abort_unless($product->status, 404);

        $product->load([
            'category:id,name,slug',
            'subcategory:id,name,slug,category_id',
        ]);

        $related = Product::active()
                    ->where('subcategory_id', $product->subcategory_id)
                    ->where('id', '!=', $product->id)
                    ->latest()
                    ->take(4)
                    ->get();

        return view('frontend.products.show', compact('product', 'related'));
    }
}