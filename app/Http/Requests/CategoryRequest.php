<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Category;

class CategoryRequest extends FormRequest
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
        $category = $this->route('category');

        $categoryId = $category?->id;

        $table = (new Category)->getTable();

        return [
            'name' => [
                'required', 
                'string', 
                'max:255',
                Rule::unique($table, 'name')->ignore($categoryId)
            ],
            'slug' => [
                'nullable', 
                'string', 
                'max:255', 
                Rule::unique($table, 'slug')->ignore($categoryId)
            ],
            'description' => [
                'nullable', 
                'string',
                'max:2000',
            ],
            'status' => [
                'required', 
                'boolean',
            ],
        ];
    }
}
