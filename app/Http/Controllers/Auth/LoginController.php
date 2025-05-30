<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Laravel\Socialite\Facades\Socialite;


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

	  // Google
	public function redirectToGoogle()
	{
	    return Socialite::driver('google')->redirect();
	}

	public function handleGoogleCallback()
	{
	    // Lấy user trực tiếp, không dùng stateless()
	    $socialUser = Socialite::driver('google')->user();

	    return $this->handleSocialUser($socialUser);
	    Log::info(Socialite::driver('google')->redirect());

	}

	// Facebook
	public function redirectToFacebook()
	{
	    return Socialite::driver('facebook')->redirect();
	}

	public function handleFacebookCallback()
	{
	    // Lấy user trực tiếp, không dùng stateless()
	    $socialUser = Socialite::driver('facebook')->user();

	    return $this->handleSocialUser($socialUser);
	}

	// Xử lý user
	protected function handleSocialUser($socialUser)
	{
	    $user = User::where('email', $socialUser->getEmail())->first();

	    if (!$user) {
	        $user = User::create([
	            'name' => $socialUser->getName(),
	            'email' => $socialUser->getEmail(),
	            'password' => Hash::make(uniqid()),
	            'is_admin' => false,
	        ]);
	    }

	    Auth::login($user);

	    return redirect('/');
	}


    // Kiểm tra quyền để có thể đổi mật khẩu
    private function hasPermissionToChangePassword($currentUser, $targetUser)
    {
        // Superadmin có quyền đổi mật khẩu của bất kỳ ai
        if ($currentUser->is_superadmin) {
            return true;
        }

        // Admin chỉ có thể đổi mật khẩu của chính mình hoặc user không phải admin
        if ($currentUser->is_admin && !$currentUser->is_superadmin) {
            return $currentUser->id === $targetUser->id || !$targetUser->is_admin;
        }

        // User chỉ có thể đổi mật khẩu của chính mình
        return $currentUser->id === $targetUser->id;
    }
    public function changePassword(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'user_id' => 'required|exists:users,id', // ID của user cần đổi mật khẩu
            'old_password' => 'required|string', // Mật khẩu cũ
            'new_password' => 'required|string|min:6|confirmed', // Mật khẩu mới và xác nhận
        ]);

        // Lấy user hiện tại và user cần đổi mật khẩu
        $currentUser = Auth::user();
        $targetUser = User::find($request->user_id);

        // Kiểm tra quyền hạn
        if (!$this->hasPermissionToChangePassword($currentUser, $targetUser)) {
            return back()->with('error', 'Bạn không có quyền đổi mật khẩu cho người dùng này.');
        }

        // Kiểm tra mật khẩu cũ
        if (!Hash::check($request->old_password, $targetUser->password)) {
            return back()->with('error', 'Mật khẩu cũ không chính xác.');
        }

        // Cập nhật mật khẩu mới
        $targetUser->password = Hash::make($request->new_password);
        $targetUser->save();

        // Thông báo thành công
        return back()->with('success', 'Đổi mật khẩu thành công!');
    }
    public function showChangePassword()
    {
        $user = Auth::user();
        return view($user->is_admin || $user->super_admin ? 'admin.users.change-password'
            : 'admin.users.user-change-password');
    }
}