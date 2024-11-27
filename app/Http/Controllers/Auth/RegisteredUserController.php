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

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return Inertia::render('Auth/Register');
    }
    public function store(Request $request)
    {
        // Validate input fields với thông báo lỗi bằng tiếng Việt
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
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

            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ]);

        // Generate verification token
        $verificationToken = Str::random(40);

        // Create the user record
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => null,
            'verification_code' => $verificationToken,
        ]);

        // Generate verification URL
        $verificationUrl = route('verification.verify', [
            'id' => $user->id,
            'hash' => sha1($user->email),
            'token' => $verificationToken,
            'email' => $user->email
        ]);

        // Send verification email
        Mail::to($user->email)->send(new Verification($verificationUrl));

        // Return success response with a message
        return Inertia::render('Auth/Register', [
            'alert' => 'Một email xác minh đã được gửi đến địa chỉ email của bạn.'
        ]);
    }
}
