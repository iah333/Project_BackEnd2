<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SanPhamRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('id');

        return [
            'ten_san_pham' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\s-]+$/',
                Rule::unique('sanpham', 'ten_san_pham')->ignore($id),
            ],
            'gia' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999999.99',
            ],
            'so_luong_ton' => [
                'required',
                'integer',
                'min:0',
                'max:50',
            ],
            'danhmuc_id' => 'required|exists:danhmuc,id',
            'anh' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'ten_san_pham.required' => 'Tên sản phẩm là bắt buộc.',
            'ten_san_pham.string' => 'Tên sản phẩm phải là chuỗi ký tự.',
            'ten_san_pham.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
            'ten_san_pham.regex' => 'Tên sản phẩm chỉ được chứa chữ cái, số, khoảng trắng và dấu gạch ngang.',
            'ten_san_pham.unique' => 'Tên sản phẩm đã tồn tại.',
            'gia.required' => 'Giá sản phẩm là bắt buộc.',
            'gia.numeric' => 'Giá sản phẩm phải là số.',
            'gia.min' => 'Giá sản phẩm không được nhỏ hơn 0.',
            'gia.max' => 'Giá sản phẩm không được vượt quá 9,999,999,999.99.',
            'so_luong_ton.required' => 'Số lượng tồn là bắt buộc.',
            'so_luong_ton.integer' => 'Số lượng tồn phải là số nguyên.',
            'so_luong_ton.min' => 'Số lượng tồn không được nhỏ hơn 0.',
            'so_luong_ton.max' => 'Số lượng tồn không được vượt quá 50.',
            'danhmuc_id.required' => 'Vui lòng chọn danh mục.',
            'danhmuc_id.exists' => 'Danh mục được chọn không tồn tại.',
            'anh.image' => 'File ảnh phải là hình ảnh (jpg, jpeg, png).',
            'anh.mimes' => 'File ảnh phải có định dạng jpg, jpeg hoặc png.',
            'anh.max' => 'File ảnh không được lớn hơn 2MB.',
        ];
    }
}