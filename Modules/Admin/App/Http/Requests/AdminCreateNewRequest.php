<?php

namespace Modules\Admin\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Admin\App\Models\Role;

class AdminCreateNewRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:2',
                'max:100',
                'unique:admins,name,' . request()->id . ',admin_id'
            ],
            'nickname' => [
                'required',
                'min:2',
                'max:100'
            ],
            'email' => [
                'required',
                'email',
                'unique:admins,email,' . request()->id . ',admin_id'
            ],
            // 'password' => [
            //     'required',
            //     'min:6',
            // ],
            'birthday' => [
                'required',
                'date_format:Y-m-d'
            ],
            'gender' => [
                'required',
                Rule::in([0, 1])
            ],
            'is_active' => [
                'required',
                Rule::in([0, 1])
            ],
            'role_id' => [
                'required',
                Rule::in(Role::getList()->pluck('role_id')->toArray())
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
            'name' => 'Name',
            'nickname' => 'Nickname',
            'email' => 'Email',
            // 'password' => 'Mật khẩu',
            'birthday' => 'Birthday',
            'gender' => 'Gender',
            'is_active' => 'Status',
            'role_id' => 'Role',
        ];
    }
}
