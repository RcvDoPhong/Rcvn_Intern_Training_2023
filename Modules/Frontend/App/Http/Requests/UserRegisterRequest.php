<?php

namespace Modules\Frontend\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6|max:30|confirmed"
        ];
    }

    public function messages(): array
    {
        return [
            "email.unique" => "Email đã tồn tại",
            "email.required" => "Email không được để trống",
            "email.email" => "Email không đúng định dạng",
            "password.required" => "Mật khẩu không được để trống",
            "password.min" => "Mật khẩu phải có độ dài từ 6 đến 30 ký tự",
            "password.max" => "Mật khẩu phải có độ dài từ 6 đến 30 ký tự",
            "password.confirmed" => "Xác nhận mật khẩu không đúng"
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
