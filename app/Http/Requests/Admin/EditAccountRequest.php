<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EditAccountRequest extends FormRequest
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
            'phone' => 'nullable|numeric|digits_between:10,12',
            'address' => 'nullable|string|max:255',
            'gender' => 'required|in:1,2',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên!',
            'name.string' => 'Tên phải là chuỗi ký tự!',
            'name.max' => 'Tên không được vượt quá 255 ký tự!',
            'phone.numeric' => 'Số điện thoại phải là số!',
            'phone.digits_between' => 'Số điện thoại phải có từ 10 đến 12 số!',
            'address.string' => 'Địa chỉ phải là chuỗi ký tự!',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự!',
            'gender.required' => 'Vui lòng chọn giới tính!',
            'gender.in' => 'Giới tính không hợp lệ!',
        ];
    }
}
