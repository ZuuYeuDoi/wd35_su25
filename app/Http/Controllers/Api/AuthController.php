<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50', 'regex:/^[\pL\s0-9]+$/u'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'numeric', 'regex:/^\d{10}$/'],
            'cccd' => ['required', 'numeric', 'regex:/^\d{12}$/'],
        ], [
            'name.required' => 'Tên là bắt buộc!',
            'name.string' => 'Tên phải là chuỗi ký tự!',
            'name.max' => 'Tên không được vượt quá :max ký tự!',
            'name.regex' => 'Tên chỉ được chứa chữ cái, số và khoảng trắng!',

            'email.required' => 'Email là bắt buộc!',
            'email.string' => 'Email phải là chuỗi!',
            'email.email' => 'Email phải là địa chỉ email hợp lệ!',
            'email.max' => 'Email không được vượt quá :max ký tự!',
            'email.unique' => 'Email đã tồn tại!',

            'password.required' => 'Mật khẩu là bắt buộc!',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự!',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự!',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp!',

            'phone.required' => 'Số điện thoại là bắt buộc!',
            'phone.numeric' => 'Số điện thoại phải là số!',
            'phone.regex' => 'Số điện thoại phải đúng định dạng 10 chữ số!',

            'cccd.required' => 'CCCD là bắt buộc!',
            'cccd.numeric' => 'CCCD phải là số!',
            'cccd.regex' => 'CCCD phải đúng định dạng 12 chữ số!',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'cccd' => $request->cccd,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Đăng ký tài khoản thành công!',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email là bắt buộc!',
            'email.email' => 'Email phải là địa chỉ hợp lệ!',
            'password.required' => 'Mật khẩu là bắt buộc!',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự!',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email hoặc mật khẩu không đúng!'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Đăng nhập thành công!',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    // hàm quên mật khẩu (gửi yều cầu)
    public function forgotPassword(Request $request)
    {
        $request->validate(
            ['email' => 'required|email'],
            [
                'email.required' => 'Email là bắt buộc!',
                'email.email' => 'Email phải là địa chỉ hợp lệ!',
            ]
        );

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => __($status)]);
        } else {
            return response()->json(['message' => __($status)], 400);
        }
    }

    // hàm reset mật khẩu
    // Tạo API nhận request reset mật khẩu
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed|min:8',
        ], [
            'email.required' => 'Email là bắt buộc!',
            'email.email' => 'Email phải là địa chỉ hợp lệ!',

            'token.required' => 'Token là bắt buộc!',
            'token.string' => 'Token phải là chuỗi ký tự!',

            'password.required' => 'Mật khẩu là bắt buộc!',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự!',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp!',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự!',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->save();

                $user->tokens()->delete(); // Xóa tất cả token cũ (đăng xuất tất cả thiết bị)
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response()->json(['message' => __($status)]);
        } else {
            return response()->json(['message' => __($status)], 400);
        }
    }

    //đăng xuất
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Đăng xuất thành công']);
    }
}
