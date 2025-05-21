<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }


    private function uploadAvatar(Request $request, $oldAvatar = null)
    {
        if ($oldAvatar) {
            File::delete(public_path('avatar/' . $oldAvatar));
        }
        $file = $request->file('avatar');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('avatar'), $filename);
        return $filename;
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        if ($request->hasFile('avatar')) {
            $user->avatar = $this->uploadAvatar($request, $user->avatar);
        }
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật người dùng thành công!');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        if ($user->is_admin) {
            return back()->with('error', 'Không thể xóa tài khoản admin.');
        }
        $user->delete();
        return back()->with('success', 'Xóa người dùng thành công!');
    }
    public function detailsUser()
    {
        $user = Auth::user();
        return view('admin.users.account', ['user' => $user]);
    }
    public function userAddresses()
    {
        $user = Auth::user();
        $addresses = $user->diachis;
        return view('user.addresses', compact('user', 'addresses'));
    }
}