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
    public function Showlogin()
    {
        return view('auth.login');
    }
    public function Login(Request $request)
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
    public function Register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone'    => 'required|string|max:20',
        ]);

        $data = $request->all();
        $check = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'phone'    =>$data['phone'],
            'is_admin' => false,
        ]);

       // Chuyển hướng sau khi đăng ký thành công
       return redirect()->route('showlogin')->with('msg', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }
    public function detailsUser(Request $request){
        $user_id = $request->get('id');
        $user = User::find($user_id);

        return view('admin.detailUser',  ['user' => $user]);
    }
    public function listUser(Request $request){
        if(Auth::check()){
            $users = User::paginate(12);
            return view('admin.listclients', ['users' => $users]);
        }
    }
    public function showupdateA(){
        return view('admin.updateadmin');
    }
    public function updateAdmin(Request $request){

        $input = $request->all();
        //Kiểm tra dữ liệu đầu vào
        $fileName = $this->AvatarUpload($request);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $input['id'],
            'password' => 'required|min:6',
            'phone' => 'required',
            'address' => 'required',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

       
        $user = User::find($input['id']);
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = Hash::make($input['password']);

        $user->phone = $input['phone'];
        $user->address = $input['address'];
        $user->picture = $this->AvatarUpload($request, $user->picture);

        $user->update();

        return redirect("detailUser")->withSuccess('You have signed-in');
    }

    public function AvatarUpload(Request $request, $oldAvatar = null)
    {
        if ($request->hasFile('picture')) {
            // Xóa ảnh cũ nếu có
            if ($oldAvatar) {
                $oldPath = public_path('uploads/' . $oldAvatar);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $file = $request->file('picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            return $filename;
        }

        return $oldAvatar; // Trường hợp không upload mới, giữ lại ảnh cũ
    }
    public function signOut()
    {
        Session::flush();
        Auth::logout();
        return Redirect('/');
    }
}
