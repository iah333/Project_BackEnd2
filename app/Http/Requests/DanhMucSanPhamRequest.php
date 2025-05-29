<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DanhMucSanPhamRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Cho phép tất cả người dùng gửi request
    }

    public function rules()
    {
        $id = $this->route('id'); // Lấy ID từ route (dùng cho update)

        return [
            'ten_danh_muc' => [
                'required',
                'string',
                'max:255',
                 'regex:/^[a-zA-Z0-9\s-]+$/',
                Rule::unique('danhmuc', 'ten_danh_muc')->ignore($id),
            ],
        ];
    }

    public function messages()
    {
        return [
            'ten_danh_muc.required' => 'Tên danh mục là bắt buộc.',
            'ten_danh_muc.string' => 'Tên danh mục phải là chuỗi ký tự.',
            'ten_danh_muc.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            'ten_danh_muc.unique' => 'Tên danh mục đã tồn tại.',
            'ten_danh_muc.regex' => 'Tên danh mục chỉ được chứa chữ cái, số, khoảng trắng và dấu gạch ngang.',

        ];
    }
}