<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
        $adminId = $this->route('manager');
        return [
            'name' => 'required|string|min:2',
            'email' => $adminId
                ? "required|email|unique:admins,email,$adminId"
                : 'required|email|unique:admins,email',
            'password' => 'nullable|min:5|confirmed',
            'role_id' => 'required|exists:roles,id',
            'phone' => ['nullable', 'unique:admins,phone,' .  $adminId, 'regex:/^(0|\+84)(3[2-9]|5[2689]|7[0-9]|8[1-9]|9[0-9])[0-9]{7}$/'],
            'address' => 'nullable|string',
            'gender' => 'nullable|in:1,2'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên.',
            'name.string' => 'Tên phải là một chuỗi ký tự.',
            'name.min' => 'Tên phải có ít nhất :min ký tự.',

            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email này đã được sử dụng.',

            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',

            'phone.unique' => 'Số điện thoại đã tồn tại.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',

            'gender.in' => 'Giới tính không hợp lệ.'
        ];
    }
}
