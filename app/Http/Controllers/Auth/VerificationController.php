<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VerificationController extends Controller
{
  public function verify($id, $hash, $token, $email)
    {
        $user = User::find($id);
        
        if (!$user || sha1($user->email) !== $hash) {
            return redirect()->route('login')->withErrors(['email' => 'Email xác minh không hợp lệ.']);
        }

        if (!Hash::check($token, $user->verification_code)) {
            return redirect()->route('login')->withErrors(['email' => 'Token xác minh không hợp lệ.']);
        }

        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('login')->with('message', 'Tài khoản của bạn đã được xác minh thành công.');
    }
}
