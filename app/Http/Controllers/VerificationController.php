<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function verify(Request $request)
    {
        // Xác thực dữ liệu nhập
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|numeric',
        ]);

        // Tìm người dùng theo email
        $user = User::where('email', $request->email)->first();

        if ($user && $user->verification_code == $request->code) {
            // Đánh dấu tài khoản là đã xác nhận
            $user->email_verified_at = now(); // Hoặc tạo cột email_verified_at nếu cần
            $user->save();

            // Đăng nhập người dùng
            Auth::login($user);

            return redirect()->route('page.home')->with('success', 'Tài khoản đã được xác minh!');
        }

        return back()->with('error', 'Mã xác nhận không hợp lệ.');
    }
}
