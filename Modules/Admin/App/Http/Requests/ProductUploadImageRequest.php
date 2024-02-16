<?php

namespace Modules\Admin\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUploadImageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'product_images.*' => [
                'required',
                'file',
                'image',
                'mimes:png,jpg',
            ],
        ];
    }

    public function attributes()
    {
        return [
            'product_images.*' => "Product's images"
        ];
    }
}
