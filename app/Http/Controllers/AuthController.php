<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class AuthController extends Controller
{

    /**
     * Display the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle the user login request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'ic' => 'required|string',
            'pass' => 'required|string',
        ]);

        $user = DB::table('usr')
            ->where('ic', $request->ic)
            ->where('pass', md5($request->pass))
            ->first();

        if ($user) {
            Auth::guard()->loginUsingId($user->id);

            return redirect()->route('index');
        }

        return back()->with('error', 'Invalid credentials.');
    }

    /**
     * Log out the authenticated user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
