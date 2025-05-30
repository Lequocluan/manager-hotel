<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GuestsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => ['required', 'regex:/^(\+?[0-9]{7,15}|0[0-9]{9})$/'],
            'identity_number' => 'nullable|string|max:12',
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'google_id' => 'nullable|string|max:255',
            'token_reset_password' => 'nullable|string|max:255',
            'token_duration' => 'nullable|date',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'email.required' => 'Email không được để trống',
            'phone.required' => 'Số điện thoại không được để trống',
            'identity_number.max' => 'Số chứng minh nhân dân không được quá 12 ký tự',
            'address.max' => 'Địa chỉ không được quá 255 ký tự',
            'avatar.image' => 'Avatar phải là một hình ảnh',
            'avatar.mimes' => 'Avatar phải có định dạng jpeg, png, jpg, gif',
            'avatar.max' => 'Avatar không được lớn hơn 2MB',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp',
        ];
    }
}
