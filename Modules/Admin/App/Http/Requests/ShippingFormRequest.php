<?php

namespace Modules\Admin\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShippingFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'shipping_method_name' => [
                'required',
                'min:6',
                'max:100',
                'unique:shipping_methods,shipping_method_name,' . request()->id . ',shipping_method_id'
            ],
            'shipping_price' => [
                'required',
                'numeric',
                'between:0, 200'
            ],
            'shipping_sale_price' => [
                'numeric',
                'gt:0',
                'lte:shipping_price'
            ],
            'shipping_sale_price_percent' => [
                'numeric',
                'gte:0'
            ],
            'estimate_shipping_days' => [
                'required',
                'numeric',
                'gt:0',
                'lte:60'
            ],
            'shipping_type' => [
                'required',
                'numeric'
            ],
            'city_id' => [
                'required_if:shipping_type, =,1',
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
            'shipping_method_name' => 'Vendor name',
            'shipping_price' => 'Shipping fee',
            'shipping_sale_price' => 'Shipping sale fee',
            'shipping_sale_price_percent' => 'Shipping sale fee (based on percent)',
            'estimate_shipping_days' => 'Estimated time delivery (days)',
            'shipping_type' => 'Areas Delivery',
            'city_id' => 'Cities apply',
        ];
    }
}
