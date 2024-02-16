<?php

namespace Modules\Admin\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'brand_name' => [
                'required',
                'min:1',
                'max:100',
                'unique:brands,brand_name,' . request()->id . ',brand_id'
            ],
            'founded' => [
                'required',
                'date_format:Y-m-d'
            ],
            'brand_logo' => [
                'file',
                'image',
                'mimes:png,jpg',
                'dimensions:max_width=1024,max_height=1024'
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

    public function attributes()
    {
        return [
            'brand_name' => 'Brand name',
            'founded' => 'Founded',
            'brand_logo' => 'Logo',
        ];
    }
}
