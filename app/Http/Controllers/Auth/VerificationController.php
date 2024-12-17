<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VerificationController extends Controller
{
    public function verify($token, $email)
    {
        $user = User::where('email', $email)->where('verification_code', $token)->first();

        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'Email xác minh không hợp lệ hoặc đã hết hạn.']);
        }

        // Cập nhật trạng thái xác minh email
        $user->email_verified_at = now();
        $user->verification_code = null; 
        $user->save();

        return redirect()->route('login')->with('message', 'Tài khoản của bạn đã được xác minh thành công.');
    }
}
