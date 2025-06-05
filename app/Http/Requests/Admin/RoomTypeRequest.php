<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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

            'overview' => 'required|string',
            'description' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (trim(strip_tags($value)) === '') {
                        $fail('Mô tả chi tiết không được để trống.');
                    }
                },
            ],
            'uploaded_images' => [
                function ($attribute, $value, $fail) {
                    $images = json_decode($value, true);
                    if (!is_array($images) || count($images) === 0) {
                        $fail('Bạn phải tải lên ít nhất một ảnh chi tiết.');
                    }
                }
            ],
            'size' => 'required',
            'bed_type' => 'required',

        'image' => $roomtypeId 
            ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            : 'required|image|mimes:jpeg,png,jpg,gif|max:2048',

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

            'overview.required' => 'Mô tả không được để trống.',
            'overview.string' => 'Mô tả phải là chuỗi',
            'overview.max' => 'Mô tả không được vượt quá 255 ký tự',
            'description.required' => 'Mô tả chi tiết không được để trống.',
            'description.string' => 'Mô tả chi tiết phải là chuỗi',

            'image.required' => 'Ảnh đại diện không được để trống',
            'image.image' => 'Ảnh đại diện không đúng định dạng',
            'image.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg, gif',
            'image.max' => 'Ảnh đại diện không được vượt quá 2MB',

            'images.*.image' => 'Ảnh bổ sung không đúng định dạng',
            'images.*.mimes' => 'Ảnh bổ sung phải có định dạng jpeg, png, jpg, gif',
            'images.*.max' => 'Ảnh bổ sung không được vượt quá 2MB',
            'uploaded_images.required' => 'Bạn phải tải lên ít nhất một ảnh chi tiết.',

            'price.required' => 'Giá không được để trống',
            'price.numeric' => 'Giá phải là số',
            'price.min' => 'Giá không được nhỏ hơn 0',
            'size.required' => 'Diện tích không được để trống.',
            'bed_type.required' => 'Loại giường không được để trống.',

            'status.required' => 'Trạng thái không được để trống',
            'status.boolean' => 'Trạng thái phải là true hoặc false',
        ];
    }
}
