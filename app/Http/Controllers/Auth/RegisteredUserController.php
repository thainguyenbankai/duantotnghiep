<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use App\Mail\Verification;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;

class RegisteredUserController extends Controller
{

    public function create()
    {
        return Inertia::render('Auth/Register');
    }
   
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            'max:255',
            'unique:users,email',
            'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
        ],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ], [
        'name.required' => 'Tên là bắt buộc.',
        'name.string' => 'Tên phải là một chuỗi.',
        'name.max' => 'Tên không được vượt quá 255 ký tự.',

        'email.required' => 'Email là bắt buộc.',
        'email.string' => 'Email phải là một chuỗi.',
        'email.email' => 'Email phải là một địa chỉ email hợp lệ.',
        'email.max' => 'Email không được vượt quá 255 ký tự.',
        'email.unique' => 'Email này đã được đăng ký, vui lòng chọn email khác.',
        'email.regex' => 'Email phải có định dạng hợp lệ (ví dụ: user@example.com).',

        'password.required' => 'Mật khẩu là bắt buộc.',
        'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
    ]);

    $verificationToken = Str::random(40);
    
    $userData = [
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'email_verified_at' => null,
        'verification_code' => $verificationToken,
    ];

    $encryptedUserData = encrypt($userData);
    Cookie::queue('user_data', $encryptedUserData, 60);
    
    $verificationUrl = route('verification.verify', [
        'token' => $verificationToken,
        'email' => $request->email,
    ]);

    Mail::to($request->email)->send(new Verification($verificationUrl));
    return redirect()->route('login');
    
}

    
    
}
