<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiaChiRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'thanh_pho_id' => 'required|exists:thanhpho,id',
            'quan_huyen_id' => 'required|exists:quanhuyen,id',
            'phuong_xa_id' => 'required|exists:phuongxa,id',
            'dia_chi_chi_tiet' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\s\.,\-\/]+$/'
            ],
            'so_dien_thoai' => [
                'required',
                'regex:/^0[0-9]{10}$/'
            ],
        ];
    }

    public function messages()
    {
        return [
            'thanh_pho_id.required' => 'Vui lòng chọn thành phố.',
            'thanh_pho_id.exists' => 'Thành phố không hợp lệ.',

            'quan_huyen_id.required' => 'Vui lòng chọn quận/huyện.',
            'quan_huyen_id.exists' => 'Quận/huyện không hợp lệ.',

            'phuong_xa_id.required' => 'Vui lòng chọn phường/xã.',
            'phuong_xa_id.exists' => 'Phường/xã không hợp lệ.',

            'dia_chi_chi_tiet.required' => 'Vui lòng nhập địa chỉ chi tiết.',
            'dia_chi_chi_tiet.string' => 'Địa chỉ chi tiết phải là chuỗi.',
            'dia_chi_chi_tiet.max' => 'Địa chỉ chi tiết không được vượt quá 255 ký tự.',
            'dia_chi_chi_tiet.regex' => 'Địa chỉ chi tiết chỉ được chứa chữ cái, số, khoảng trắng và các ký tự . , - /',

            'so_dien_thoai.required' => 'Vui lòng nhập số điện thoại.',
            'so_dien_thoai.regex' => 'Số điện thoại không hợp lệ. Phải bắt đầu bằng 0 và đủ 10 chữ số.',
        ];
    }
}
