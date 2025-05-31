<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:50', 'regex:/^[\pL\s0-9]+$/u'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'numeric', 'regex:/^\d{10}$/'],
            'cccd' => ['required', 'numeric', 'regex:/^\d{12}$/'],
        ], [
            // Name
            'name.required' => 'Vui lòng nhập tên!',
            'name.string' => 'Tên phải là chuỗi ký tự!',
            'name.max' => 'Tên không được vượt quá :max ký tự!',
            'name.regex' => 'Tên chỉ được chứa chữ cái và không được có ký tự đặc biệt!',

            // Email
            'email.required' => 'Vui lòng nhập email!',
            'email.string' => 'Email phải là chuỗi ký tự!',
            'email.email' => 'Email không đúng định dạng!',
            'email.max' => 'Email không được vượt quá :max ký tự!',
            'email.unique' => 'Email đã được sử dụng!',

            // Password
            'password.required' => 'Mật khẩu là bắt buộc!',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự!',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự!',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp!',

            // Phone
            'phone.required' => 'Vui lòng nhập số điện thoại!',
            'phone.numeric' => 'Số điện thoại phải là số!',
            'phone.regex' => 'Số điện thoại phải gồm 10 số!',

            // CCCD
            'cccd.required' => 'Vui lòng nhập số CCCD!',
            'cccd.numeric' => 'CCCD phải là số!',
            'cccd.regex' => 'CCCD phải gồm 12 chữ số!',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'cccd' => $data['cccd'],
        ]);
    }
}
