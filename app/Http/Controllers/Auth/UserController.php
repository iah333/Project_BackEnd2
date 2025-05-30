<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\DiaChi;
use App\Models\GioHang;
use Illuminate\Http\Request;
use App\Models\GioHangSanPham;
use App\Http\Controllers\Controller;
use App\Models\ThanhPho; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

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

        // Kiểm tra nếu người dùng hiện tại là admin nhưng không phải super admin
        if (Auth::user()->is_admin && !Auth::user()->super_admin && $user->super_admin) {
            return redirect()->route('admin.users.index')->with('error', 'Bạn không có quyền chỉnh sửa tài khoản Super Admin.');
        }

        return view('admin.users.edit', compact('user'));
    }

    private function uploadAvatar(Request $request, $oldAvatar = null)
    {

        if ($oldAvatar) {
            // Xóa chính xác đường dẫn file cũ
            $oldPath = public_path($oldAvatar);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }

        $file = $request->file('avatar');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $path = 'avatar/' . $filename;
        $file->move(public_path('avatar'), $filename);

        return $path;
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Kiểm tra nếu người dùng hiện tại là admin nhưng không phải super admin
        if (Auth::user()->is_admin && !Auth::user()->super_admin && $user->super_admin) {
            return redirect()->route('admin.users.index')->with('error', 'Bạn không có quyền chỉnh sửa tài khoản Super Admin.');
        }
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

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Bạn không thể tự xóa chính mình');
        }
        if ($user->is_admin && !$user->super_admin) {
            if (!Auth::user()->super_admin) {
                return back()->with('error', 'Bạn không có quyền xóa tài khoản admin.');
            }
        }

        if ($user->super_admin) {
            return back()->with('error', value: 'Không có quyền xóa tài khoản super Admin.');
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
    //Hiển thị form tạo admin
    public function create()
    {
        return view(view: 'admin.users.create');
    }
    //Tạo thêm admin mới
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only('name', 'email');
        $data['password'] = Hash::make($request->password);
        $data['is_admin'] = true;

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('avatar'), $filename);
            $data['avatar'] = 'avatar/' . $filename;
        }

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Tạo admin mới thành công!');
    }
    /**
     * Hiển thị trang hồ sơ người dùng
     */
    public function profile()
    {
        $user = Auth::user();
        $addresses = DiaChi::where('user_id', Auth::id())->get();
        $gioHang = GioHang::where('user_id', Auth::id())->first();
        $thanhPhos = ThanhPho::all(); 

        $cartItems = $gioHang ? $gioHang->sanPhams()->get() : collect([]);
        $tongSoLuong = $cartItems->sum(function ($item) {
            return $item->pivot->so_luong;
        });
        $tongGia = $cartItems->sum(function ($item) {
            return $item->gia * $item->pivot->so_luong;
        });

        return view('admin.users.profile', compact('user', 'addresses', 'cartItems', 'tongSoLuong', 'tongGia','thanhPhos'));
    }

    /**
     * Hiển thị form chỉnh sửa thông tin người dùng (cho người dùng thường)
     */
    public function editUser()
    {
        $user = Auth::user();
        return view('admin.users.edit-users', compact('user'));
    }

    /**
     * Cập nhật thông tin người dùng (cho người dùng thường)
     */
    public function updateUser(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
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

        return redirect()->route('users.profile')->with('success', 'Cập nhật hồ sơ thành công!');
    }
}
