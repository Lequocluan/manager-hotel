<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RoomTypeRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $roomtypeId = $this->route('room_type');

        return [
            'name' => $roomtypeId 
                ? 'required|min:2|string|unique:room_types,name,' . $roomtypeId 
                : 'required|min:2|string|unique:room_types,name',

            'overview' => 'nullable|string',
            'description' => 'nullable|string',

            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'price' => 'required|numeric|min:0',
            'status' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên loại phòng không được để trống',
            'name.min' => 'Tên loại phòng phải có ít nhất 2 ký tự',
            'name.string' => 'Tên loại phòng phải là chuỗi',
            'name.unique' => 'Tên loại phòng đã tồn tại',

            'overview.string' => 'Mô tả phải là chuỗi',
            'overview.max' => 'Mô tả không được vượt quá 255 ký tự',
            'description.string' => 'Mô tả chi tiết phải là chuỗi',

            'image.image' => 'Ảnh đại diện không đúng định dạng',
            'image.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg, gif',
            'image.max' => 'Ảnh đại diện không được vượt quá 2MB',

            'images.*.image' => 'Ảnh bổ sung không đúng định dạng',
            'images.*.mimes' => 'Ảnh bổ sung phải có định dạng jpeg, png, jpg, gif',
            'images.*.max' => 'Ảnh bổ sung không được vượt quá 2MB',

            'price.required' => 'Giá không được để trống',
            'price.numeric' => 'Giá phải là số',
            'price.min' => 'Giá không được nhỏ hơn 0',

            'status.required' => 'Trạng thái không được để trống',
            'status.boolean' => 'Trạng thái phải là true hoặc false',
        ];
    }
}
