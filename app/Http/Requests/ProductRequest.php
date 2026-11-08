<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Subcategory;
use App\Models\Category;
use App\Models\Product;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $product = $this->route('product');

        $subcategoryTable = (new Subcategory)->getTable();

        $categoryTable = (new Category)->getTable();

        $productTable = (new Product)->getTable();

        return [
            'category_id' => [
                'required',
                'integer',
                Rule::exists($categoryTable, 'id'),
            ],
            'subcategory_id' => [
                'required',
                'integer',
                Rule::exists($subcategoryTable, 'id')
                    ->where('category_id', $this->input('category_id')),
            ],
            'name' => [
                'required', 
                'string', 
                'max:255',
                Rule::unique($productTable, 'name')
                    ->where(fn ($q) => $q->where('subcategory_id', $this->input('subcategory_id')))
                    ->ignore($product?->id),
            ],
            'slug' => [
                'nullable', 
                'string', 
                'max:220', 
                Rule::unique($productTable, 'slug')->ignore($product?->id),
            ],
            'description' => [
                'nullable', 
                'string',
                'max:5000',
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:1024',
            ],
            'old_price' => [
                'nullable', 
                'numeric', 
                'min:0',
                'max:99999999.99',
            ],
            'new_price' => [
                'required',
                'numeric',
                'min:0',
                'max:99999999.99',
                function ($attr, $value, $fail) {
                    $oldPrice = $this->input('old_price');
                    
                    if ($oldPrice !== null && $oldPrice !== '' && $value > $oldPrice) {
                        $fail('New price must be less than or equal to old price.');
                    }
                },
            ],
            'status' => [
                'required', 
                'boolean',
            ],
        ];
    }
}
