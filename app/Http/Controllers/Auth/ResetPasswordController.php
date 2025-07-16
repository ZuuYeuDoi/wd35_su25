<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/';

    protected function validationErrorMessages()
    {
        return [
            'email.required' => 'Bạn cần nhập địa chỉ email!',
            'email.email' => 'Địa chỉ email không hợp lệ!',
            'password.required' => 'Bạn cần nhập mật khẩu!',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp!',
        ];
    }

    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->setRememberToken(Str::random(60));
        $user->save();
    }

    protected function sendResetResponse(Request $request, $response)
    {
        Auth::logout();
        Session::flush();

        return redirect('/login')->with('status', trans($response) . ' Vui lòng đăng nhập lại!');
    }
}
