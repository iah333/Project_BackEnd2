<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\File;

class LoginController extends Controller
{
    public function showlogin()
    {
        return view(view: 'auth.login');
    }
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $status = Auth::attempt(['email' => $email, 'password' => $password]);
        if ($status) {
            $user = Auth::user();
            $urlRedirect = "/";
            if ($user->is_admin) {
                $urlRedirect = "/admin";
            };
            return redirect($urlRedirect);
        }
        return back()->with('msg', 'Email hoặc mật khẩu không chính xác');
    }

    public function showregister()
    {
        return view('auth.Register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $data = $request->all();
        $check = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => false,
        ]);
        // Chuyển hướng sau khi đăng ký thành công
        return redirect()->route(route: 'login')->with('msg', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }

    // Xử lí đăng xuất
    public function logout()
    {
        Session::flush();
        Auth::logout();
        // Khi users bấm đăng xuất trả về trang chủ
        return Redirect('/');
    }
}