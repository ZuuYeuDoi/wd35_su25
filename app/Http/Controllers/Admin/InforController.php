<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class InforController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();
        return view('admin.customers.staff-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['nullable', 'string', 'max:50', 'regex:/^[\pL\s0-9]+$/u'],
            // 'email' => ['nullable', 'string', 'email', 'max:100', Rule::unique('users')->ignore(Auth::id()),],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'current_password' => ['required_with:password'],
            'phone' => ['nullable', 'numeric', 'regex:/^\d{10}$/'],
            'cccd' => ['nullable'],
        ], [
            // Name
            'name.required' => 'Vui lòng nhập tên!',
            'name.string' => 'Tên phải là chuỗi ký tự!',
            'name.max' => 'Tên không được vượt quá :max ký tự!',
            'name.regex' => 'Tên chỉ được chứa chữ cái và không được có ký tự đặc biệt!',

            // Email
            // 'email.required' => 'Vui lòng nhập email!',
            // 'email.string' => 'Email phải là chuỗi ký tự!',
            // 'email.email' => 'Email không đúng định dạng!',
            // 'email.max' => 'Email không được vượt quá :max ký tự!',
            // 'email.unique' => 'Email đã được sử dụng!',

            // Password
            'password.string' => 'Mật khẩu phải là chuỗi ký tự!',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự!',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp!',
            'current_password.required_with' => 'Vui lòng nhập mật khẩu hiện tại trước khi đổi mật khẩu!',

            // Phone
            'phone.required' => 'Vui lòng nhập số điện thoại!',
            'phone.numeric' => 'Số điện thoại phải là số!',
            'phone.regex' => 'Số điện thoại phải gồm 10 số!',

            //cccd
            // 'cccd.regex' => 'Căn cước công dân phải gồm 9 hoặc 12 chữ số!',
        ]);

        try {
            $user = Auth::user();
            $user->update([
                'name'  => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'cccd'  => $request->cccd,
            ]);

            if ($request->filled('password')) {
                // Kiểm tra mật khẩu hiện tại
                if (!Hash::check($request->current_password, $user->password)) {
                    return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng!']);
                }

                //Lưu mật khẩu mới
                $user->password = Hash::make($request->password);
                $user->save();

                // Logout user và chuyển hướng về trang login
                Auth::logout();
                return redirect()->route('login')->with('success', 'Đổi mật khẩu thành công, vui lòng đăng nhập lại!');
            }

            return redirect()->back()->with('success', 'Cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cập nhật thất bại: ' . $e->getMessage());
        }
    }
}
