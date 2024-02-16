<?php

namespace Modules\Frontend\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MinAge;

class ChangeUserPasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed|different:current_password',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
            'confirmed' => 'The :attribute field does not match.',
            'new_password.min' => 'The new password must be at least 8 characters.',
        ];
    }
}
