<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ], [
        'email.email' => 'Vui lòng nhập đúng định dạng email.',
        'email.required' => 'Vui lòng nhập email.',
        'password.required' => 'Vui lòng nhập mật khẩu.',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return redirect()->route('login')->withErrors([
            'email' => 'Tài khoản không tồn tại hoặc mật khẩu sai.',
        ]);
    }
    if (!$user || !Hash::check($request->password, $user->password)) {
        return redirect()->route('login')->withErrors([
            'password' => 'Tài khoản không tồn tại hoặc mật khẩu sai.',
        ]);
    }

    if ($user->keyy === 'inactive') {
        return redirect()->route('login')->withErrors([
            'email' => 'Tài khoản của bạn đã bị vô hiệu hóa.',
        ]);
    }
    if($user->email_verified_at == null ){
        return redirect()->route('login')->withErrors([
            'email' => 'Tài khoản của bạn chưa được xác nhận.',
        ]);
    }
    // Attempt authentication
    if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
        return redirect()->route('login')->withErrors([
            'email' => trans('auth.failed'),
        ]);
    }

    // Regenerate session to avoid session fixation
    $request->session()->regenerate();

    // Redirect to intended page
    return redirect()->intended(route('page.home'));
}


    

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
