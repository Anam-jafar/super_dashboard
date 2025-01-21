<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class AuthController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }

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

    public function logout()
    {

                $this->logActivity('Logout', 'log out attempt successful');

        Auth::logout();
        return redirect()->route('login');
    }

    public function profile()
    {

        $user = Auth::user(); 


        return view('auth.profile', compact('user'));
    }

        
public function updateProfile(Request $request)
{
    $user = Auth::user();

    try {
        $user->update($request->only(['name', 'ic', 'hp', 'mel']));

        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (md5($request->current_password) !== $user->pass) {
                return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }

            $user->update([
                'pass' => md5($request->new_password),
            ]);
            $this->logActivity('Password Update', 'User password update successful');
        }

        $this->logActivity('Profile Update', 'User profile update successful');
        return redirect()->back()->with('success', 'Profile updated successfully!');

    } catch (\Exception $e) {
        \Log::error('Profile update failed: ' . $e->getMessage());

        return redirect()->back()->withErrors(['error' => 'There was an issue updating the profile. Please try again later.']);
    }
}



public function activityLogs()
{
    $perPage = request()->get('per_page', 25); 

    $logs = DB::table('sys_log as s')
        ->rightJoin('usr as u', 's.uid', '=', 'u.uid')
        ->select('s.*', 'u.uid', 'u.name', 'u.ic')
        ->orderBy('s.dt', 'desc')
        ->orderBy('s.tm', 'desc')
        ->paginate($perPage);

    return view('auth.activity_logs', ['logs' => $logs, 'perPage' => $perPage]);
}



}
