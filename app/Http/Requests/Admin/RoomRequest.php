<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomRequest extends FormRequest
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
        $roomId = $this->route('room');
        return [
            'name' => [
            'required',
            'string',
            'max:100',
            $roomId
                ? Rule::unique('rooms', 'name')->ignore($roomId)
                : Rule::unique('rooms', 'name'),
        ],
            'room_type_id' => 'required|exists:room_types,id',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|integer|in:0,1,2',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên phòng.',
            'name.unique' => 'Tên phòng đã tồn tại.',
            'room_type_id.required' => 'Vui lòng chọn loại phòng.',
            'room_type_id.exists' => 'Loại phòng không hợp lệ.',
            'status.required' => 'Vui lòng chọn trạng thái phòng.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ];
    }
}
