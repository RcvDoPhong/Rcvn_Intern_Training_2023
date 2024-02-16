<?php

namespace Modules\Admin\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'category_name' => [
                'required',
                'min:6',
                'max:50',
                'unique:categories,category_name,' . request()->id . ',category_id'
            ],
            'parent_flag' => [
                'required',
                'integer'
            ],
            'parent_categories_id' => [
                'required_if:parent_flag, =, 1'
            ]
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function messages()
    {
        return [
            'required_if' => ':attribute is required when category is child'
        ];
    }

    public function attributes()
    {
        return [
            'category_name' => 'Category name',
            'parent_flag' => 'Type category',
            'parent_categories_id' => 'Parent category name',
        ];
    }
}
