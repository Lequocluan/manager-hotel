<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EditAccountRequest;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\UpdatePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function form_login()
    {
        if (auth()->guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $cre = $request->only('email', 'password');
        if (auth()->guard('admin')->attempt($cre)) {
            Session::flash('success', 'Đăng nhập thành công.');
            return redirect()->route('admin.dashboard');
        }
        Session::flash('error', 'Email hoặc mật khẩu không đúng');
        return redirect()->back();
    }
    
    public function logout()
    {
        auth()->guard('admin')->logout();
        Session::flash('success', 'Đã đăng xuất thành công.');
        return redirect()->route('login');
    }

    public function profile()
    {
        $title = 'Thông tin thành viên quản trị';
        return view('admin.auth.profile', compact('title'));
    }

    public function update_avatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $admin = Auth::guard('admin')->user();
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = time() . '_' . Str::slug($originalName) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/avatars'), $filename);

            if ($admin->avatar && file_exists(public_path($admin->avatar))) {
                unlink(public_path($admin->avatar));
            }
            $admin->avatar = '/uploads/avatars/' . $filename;
            $admin->save();

            return response()->json(['success' => true, 'avatar_url' => $admin->avatar]);
        }

        return response()->json(['success' => false], 500);
    }

    public function update_password()
    {
        $title = 'Đổi mật khẩu';
        return view('admin.auth.update_password', compact('title'));
    }

    // Xử lý đổi mật khẩu
    public function handle_update_password(UpdatePasswordRequest $request)
    {
        $admin = auth()->guard('admin')->user();

        // Kiểm tra mật khẩu hiện tại
        if (!Hash::check($request->current_password, $admin->password)) {
            return redirect()->back()->with('error', 'Mật khẩu hiện tại không đúng!');
        }

        // Cập nhật mật khẩu mới
        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Đổi mật khẩu thành công!');
    }
    
    public function edit_account()
    {
        $title = 'Chỉnh sửa thông tin cá nhân';
        $data = auth()->guard('admin')->user();
        return view('admin.auth.edit_account', compact('title', 'data'));
    }
    public function handle_edit_account(EditAccountRequest $request){
        try{
            $admin = auth()->guard('admin')->user();
            $data = array_filter([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'gender' => $request->gender,
            ]);
            $admin->update($data);
            Session::flash('success', 'Cập nhật thông tin thành công!');
            return redirect()->route('admin.profile');
        }catch(\Exception $e){
            Session::flash('error', 'Có lỗi xảy ra, vui lòng thử lại sau!');
            return redirect()->back();
        }
    }
}
