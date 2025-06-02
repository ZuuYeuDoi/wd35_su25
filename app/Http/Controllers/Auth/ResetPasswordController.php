<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
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
}
