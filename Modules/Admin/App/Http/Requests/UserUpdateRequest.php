<?php

namespace Modules\Admin\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'delivery_city_id' => [
                'required',
                'integer'
            ],
            'delivery_district_id' => [
                'required',
                'integer'
            ],
            'delivery_ward_id' => [
                'required',
                'integer'
            ],
            'billing_city_id' => [
                'nullable',
                'integer'
            ],
            'billing_district_id' => [
                'nullable',
                'integer'
            ],
            'billing_ward_id' => [
                'nullable',
                'integer'
            ],
            'name' => [
                'required',
                'min:6',
                'max:100',
                'unique:users,name,' . request()->id . ',user_id'
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email,' . request()->id . ',user_id'
            ],
            'nickname' => [
                'required',
                'min:6',
                'max:100'
            ],
            'birthday' => [
                'required',
                'date_format:Y-m-d'
            ],
            'gender' => [
                'required',
            ],
            'delivery_fullname' => [
                'required',
                'min:6',
                'max:100'
            ],
            'delivery_address' => [
                'required',
                'min:6',
                'max: 150'
            ],
            'delivery_zipcode' => [
                'required',
                'numeric'
            ],
            'delivery_phone_number' => [
                'required',
                'phone:VN'
            ],
            'billing_fullname' => [
                'nullable',
                'min:6',
                'max:100'
            ],
            'billing_address' => [
                'nullable',
                'min:6',
                'max:150'
            ],
            'billing_zipcode' => [
                'nullable',
                'numeric',
            ],
            'billing_phone_number' => [
                'nullable',
                'phone:VN'
            ],
            'billing_tax_id_number' => [
                'nullable',
                'numeric'
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
            'delivery_city_id' => 'Delivery city address',
            'delivery_district_id' => 'Delivery district address',
            'delivery_ward_id' => 'Delivery ward address',
            'billing_city_id' => 'Billing city address',
            'billing_district_id' => 'Billing district address',
            'billing_ward_id' => 'Billing ward address',
            'name' => 'Name',
            'email' => "Customer's email",
            'nickname' => 'Nickname',
            'birthday' => 'Birthday',
            'gender' => 'Gender',
            'delivery_fullname' => 'Fullname',
            'delivery_address' => 'Delivery address',
            'delivery_zipcode' => 'Delivery zipcode',
            'delivery_phone_number' => 'Delivery phone number',
            'billing_fullname' => 'Fullname',
            'billing_address' => 'Billing address',
            'billing_zipcode' => 'Billing zipcode',
            'billing_phone_number' => 'Billing phone number',
            'billing_tax_id_number' => 'Tax ID Number',
        ];
    }
}
