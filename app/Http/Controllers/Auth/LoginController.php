<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\RoleModulePermission;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/home';

    protected function redirectTo()
    {
        if (auth()->user()->role_id === 2) {
            return '/home';
        }
        return '/dashboard';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        $login = request()->input('email');

        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
        request()->merge([$field => $login]);

        return $field;
    }

    protected function authenticated(Request $request, $user)
    {
        $roleModulePermission = RoleModulePermission::where(['role_id' => $user->role_id])->pluck('module_permission_name');

        Session::put('permissions', $roleModulePermission);
        Session::put('role_id', $user->role_id);
    }
}
