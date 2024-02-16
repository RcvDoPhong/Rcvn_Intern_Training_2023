<?php

namespace Modules\Frontend\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MinAge;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'birthday' => 'required|date|before:' . now()->subYears(10)->toDateString(),
            'gender' => 'nullable|in:0,1',
            'billing_fullname' => 'required|string|max:25',
            'billing_city_id' => 'nullable|integer|max:255',
            'billing_district_id' => 'nullable|integer|max:255',
            'billing_ward_id' => 'nullable|integer|max:255',
            'billing_address' => 'required|string|max:127',
            'billing_phone_number' => 'required|string|regex:/^[0-9]{10}$/',
            'billing_tax_id_number' => 'nullable|string|max:20',
            'delivery_fullname' => 'required|string|max:127',
            'delivery_city_id' => 'nullable|integer|max:255',
            'delivery_district_id' => 'nullable|integer|max:255',
            'delivery_ward_id' => 'nullable|integer|max:255',
            'delivery_address' => 'required|string|max:127',
            'delivery_phone_number' => 'required|string|regex:/^[0-9]{10}$/',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
            'date' => 'The :attribute must be a valid date.',
            'in' => 'The selected :attribute is invalid.',
            'boolean' => 'The :attribute field must be true or false.',
            'regex' => 'The :attribute field must be exactly 10 digits long and contain only numbers.',
        ];
    }
}
