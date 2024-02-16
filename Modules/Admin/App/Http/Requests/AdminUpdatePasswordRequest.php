<?php

namespace Modules\Admin\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Admin\App\Models\Role;

class AdminUpdatePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'old_password' => [
                'required',
                'min:6',
            ],
            'new_password' => [
                'required',
                'min:6',
            ],
            'confirm_new_password' => [
                'required',
                'min:6',
                'same:new_password'
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
            'old_password' => 'Old password',
            'new_password' => 'New password',
            'confirm_new_password' => 'Confirm new password',
        ];
    }
}
