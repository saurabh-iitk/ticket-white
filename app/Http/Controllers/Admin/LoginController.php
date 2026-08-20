<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\RoleModulePermission;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

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
     * Show the application login.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.login');
    }

    /**
     * Show the application login.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (isset($user) && $user->role_id == 1) {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials, $request->filled('remember'))) {
                $roleModulePermission = RoleModulePermission::where('role_id', $user->role_id)->pluck('module_permission_name');
                Session::put('permissions', $roleModulePermission);
                return redirect()->intended($this->redirectTo);
            } else {
                return redirect("/admin/login")->with('error', 'Oppes! You have entered invalid credentials.');
            }
        } else {
            return redirect("/login")->with('error', 'Oppes! Please login with admin credentials.');
        }
    }
}
