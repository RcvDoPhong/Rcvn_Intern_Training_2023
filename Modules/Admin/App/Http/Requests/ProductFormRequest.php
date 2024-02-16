<?php

namespace Modules\Admin\App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'product_name' => [
                'bail',
                'required',
                'min:1',
                'max:100',
                'unique:products,product_name,' . request()->id . ',product_id'
            ],
            'base_price' => [
                'bail',
                'required',
                'numeric',
                'between:10,900000',
                'gt:0'
            ],
            'sale_price' => [
                'bail',
                'numeric',
                'gte:0',
                'lte:base_price',
                'required_if:is_sale, =, 0',
            ],
            'sale_price_percent' => [
                'bail',
                'numeric',
                'gte:0',
                'lte:1'
            ],
            'stock' => [
                'bail',
                'required',
                'numeric'
            ],
            'brand_id' => [
                'nullable',
                'integer'
            ],
            'category_id' => [
                'nullable',
                'integer'
            ],
            'status' => [
                'required'
            ],
            'is_sale' => [
                'required',
            ],
            'sale_type' => [
                'required_if:is_sale,true'
            ],
            'brief_description' => [
                'bail',
                'required',
                'min:6',
                'max:200'
            ],
            'product_description' => [
                'required'
            ],
            'product_thumbnail' => [
                'bail',
                'file',
                'image',
                'mimes:png,jpg',
                'dimensions:max_width=1024,max_height=1024'
            ],
            'parent_flag' => [
                'required'
            ],
            'has_children' => [
                'required'
            ],
            'options.*.option_id' => [
                'bail',
                'distinct',
                'required'
            ],
            'options.*.option_name' => [
                'bail',
                'min:3',
                'max:100',
                'required'
            ],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function attributes()
    {
        return [
            'product_name' => 'Product name',
            'base_price' => 'Price',
            'sale_price' => 'Sale price',
            'sale_price_percent' => 'Sale price (based on percent)',
            'stock' => 'Stock',
            'brand_id' => 'Brand',
            'category_id' => 'Category',
            'status' => 'Status',
            'sale_type' => 'Display sale price method',
            'brief_description' => 'Brief description',
            'product_description' => 'Description',
            'product_thumbnail' => 'Thumbnail product',
            'parent_flag' => 'Product relationship',
            'has_children' => 'Product parent options',
            'options.*.option_id' => 'Option UUID #:position',
            'options.*.option_name' => 'Option name #:position',
        ];
    }
}
