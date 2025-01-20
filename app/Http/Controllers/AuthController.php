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
            $this->logActivity('Login', 'log in attempt successful');


            return redirect()->route('index');
        }
        $this->logActivity('Login', 'log in attempt failed');
        return back()->with('error', 'Invalid credentials.');
    }

    /**
     * Log out the authenticated user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {

                $this->logActivity('Logout', 'log out attempt successful');

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
        
        $user->update($request->all());
        $this->logActivity('User Profile Update', 'User profile update successful');
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


        // Check if the current password is correct
        if (md5($request->current_password) !== $user->pass) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update the password (hash the new one)
        $user->update([
            'pass' => md5($request->new_password),  // If you are using MD5 (but it's not recommended)
        ]);
        $this->logActivity('User Password Update', 'User password update successful');
        return redirect()->back()->with('success', 'Password updated successfully!');
    }

public function activityLogs()
{
    // Get the per_page value from the request, default to 10
    $perPage = request()->get('per_page', 10); 

    // Fetch the logs with pagination, ordered by date and time in descending order
    $logs = DB::table('sys_log as s')
        ->rightJoin('usr as u', 's.uid', '=', 'u.uid')
        ->select('s.*', 'u.uid', 'u.name', 'u.ic')
        ->orderBy('s.dt', 'desc')
        ->orderBy('s.tm', 'desc')
        ->paginate($perPage);

    // Pass the 'perPage' value and the logs to the view
    return view('auth.activity_logs', ['logs' => $logs, 'perPage' => $perPage]);
}



}
