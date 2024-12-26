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

    /**
     * Show the user profile.
     *
     */
    public function profile()
    {

        $user = Auth::user(); 


        return view('auth.profile', compact('user'));
    }

    
/**
 * Update the authenticated user's profile information.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\RedirectResponse
 */
public function updateProfile(Request $request)
{
    $user = Auth::user();

    // Validate the input data
    // $request->validate([
    //     'name' => 'required|string|max:255',
    //     'email' => 'required|email|max:255',
    //     'phone' => 'required|string|max:20',
    // ]);

    // Update the user profile
    $user->update([
        'name' => $request->name,
        'mel' => $request->email,
        'hp' => $request->phone,
    ]);

    return redirect()->back()->with('success', 'Profile updated successfully!');
}

/**
 * Update the authenticated user's password.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\RedirectResponse
 */
public function updatePassword(Request $request)
{
    $user = Auth::user();

    // Validate the input data
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:8|confirmed',
    ]);

    // Check if the current password is correct
    if (!Hash::check($request->current_password, $user->pass)) {
        return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
    }

    // Update the password
    $user->update([
        'pass' => Hash::make($request->new_password),
    ]);

    return redirect()->back()->with('success', 'Password updated successfully!');
}

}
