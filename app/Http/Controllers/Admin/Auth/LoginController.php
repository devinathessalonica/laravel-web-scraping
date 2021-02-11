<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    protected $auth;
    protected $lockoutTime;
    protected $maxLoginAttempts;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->lockoutTime  = 1;    // lockout for 1 minute (value is in minutes)
        $this->maxLoginAttempts = 5;    // lockout after 5 attempts
    }

    /**
     * Authenticate user credentials
     * @param  Request $request
     * @return Response
     */
    public function doLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);
        // dd('a');
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return redirect('admin/login')->with('error', 'Terlalu banyak kesalahan login. Mohon ulangi setelah ' . ($this->lockoutTime * 60) . ' detik');
        }
        $login = Auth::guard('web')->attempt(['username' => $request->username, 'password' => $request->password]);
        if ($login) {
            return redirect(!empty(session('url')['intended']) ? session('url')['intended'] : 'admin/dashboard');
        } else {
            $this->incrementLoginAttempts($request);
            return redirect('admin/login')->with('error', 'Username atau password salah!');
        }
    }

    /**
     * Log user out
     * @return Response
     */
    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('admin/login')->with('success', 'Anda telah keluar dari sistem.');
    }

    /**
     * Get username column name
     * @return string
     */
    protected function username()
    {
        return 'username';
    }
     
    /**
     * Determine if the user has too many failed login attempts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasTooManyLoginAttempts(Request $request)
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request), $this->maxLoginAttempts, $this->lockoutTime
        );
    }
}
