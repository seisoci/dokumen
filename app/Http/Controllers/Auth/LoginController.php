<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
  protected $redirectTo = RouteServiceProvider::HOME;

  public function username()
  {
    return 'username';
  }

  protected function credentials(Request $request)
  {
    return ['username' => $request->username, 'password' => $request->password, 'active' => 1];
  }

  public function __construct()
  {
    $this->middleware('guest')->except('logout');
  }

  public function showLoginForm()
  {

    return view('/auth/login');
  }

  public function logout(Request $request)
  {
    $this->guard()->logout();
    $request->session()->flush();
    $request->session()->regenerate();
    return redirect('/backend');
  }
}
