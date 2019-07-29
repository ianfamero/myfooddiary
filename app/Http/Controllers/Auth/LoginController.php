<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Http\Requests\LoginRequest;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(LoginRequest $request) {
        try {
          if(Auth::Guard('web')->attempt([
            'email' => $request->email,
            'password' => $request->password
            ], $request->remember)) { 
          } else {
            return response(['message' => config('global.failed-user-login')], 500); 
          }
        } catch (\Exception $ex) {
          // return response()->json(['message' => $ex->getMessage()], 500); //uncomment when debugging
          return response(['message' => config('global.failed-login')], 500);
        }
      }
    
    public function logout(Request $request) {
        Auth::guard('web')->logout();
        $sessionKey = Auth::guard('web')->getName();
        $request->session()->forget($sessionKey);
        $request->session()->regenerate();
        return redirect('/');
      }
}
