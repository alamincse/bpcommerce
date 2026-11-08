<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Subcategory;
use App\Models\Category;

class SubcategoryRequest extends FormRequest
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
        $subcategory = $this->route('subcategory');

        $subcategoryId = $subcategory?->id;

        $subcategoryTable = (new Subcategory)->getTable();
        $categoryTable = (new Category)->getTable();

        return [
            'category_id' => [
                'required', 
                Rule::exists($categoryTable, 'id'),
            ],
            'name' => [
                'required', 
                'string', 
                'max:255',
                Rule::unique($subcategoryTable, 'name')
                    ->where(fn ($q) => $q->where('category_id', $this->input('category_id')))
                    ->ignore($subcategoryId),
            ],
            'slug' => [
                'nullable', 
                'string', 
                'max:255', 
                Rule::unique($subcategoryTable, 'slug')->ignore($subcategoryId)
            ],
            'description' => [
                'nullable', 
                'string', 
                'max:2000'
            ],
            'status' => [
                'required', 
                'boolean',
            ],
        ];
    }
}
