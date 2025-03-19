<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;



class AuthController extends Controller
{

    public function showLoginForm()
    {
        $currentDateTime = Carbon::now('Asia/Kuala_Lumpur');

        $arabicDateTime = $currentDateTime->locale('ar')->isoFormat('D MMMM YYYY / HH:mm:ss');

        $englishDateTime = $currentDateTime->locale('en')->isoFormat('D MMMM YYYY / HH:mm:ss');

        return view('auth.login', compact('arabicDateTime', 'englishDateTime'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'mel' => 'required|string',
            'pass' => 'required|string',
        ]);
        
        $user = DB::table('usr')
            ->where('mel', $request->mel)
            ->where('pass', md5($request->pass))
            ->first();

        if ($user) {
            // if($user->status = 1){
            //     return back()->with('error', 'Akaun anda telah dinyahaktifkan. Sila hubungi pentadbir sistem.');
            // }
            if($user->password_set == 0){
                return redirect()->route('resetPassword', ['id' => $user->id]);
            }

            Auth::guard()->loginUsingId($user->id);
            $this->logActivity('Login', 'log in attempt successful');


            return redirect()->route('index');
        }
        $this->logActivity('Login', 'log in attempt failed');
        return back()->with('error', 'Invalid credentials.');
    }

    public function resetPassword(Request $request, $id)
    {
        $user = User::with('Department', 'Position', 'DistrictAcceess', 'UserGroup')->find($id);

        if($request->method() == 'POST') {
            $request->validate([
                'password' => 'required|string',
                'confirm_password' => 'required|string|same:password',
            ]);

            $user->update([
                'pass' => md5($request->password),
                'password_set' => 1,
            ]);
            
            return redirect()->route('login')->with('success', 'Kata Laluan Dikemaskini. Log masuk semula dengan kata laluan baharu.');


        }
        return view('auth.reset_password', compact('user'));
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

    // Validate the input fields
    $request->validate([
        'name' => 'required|string|max:255',
        'ic' => 'required|string|max:12|unique:usr,ic,' . Auth::id() . ',id',
        'hp' => 'required|string|max:15',
        'mel' => 'required|email|max:255|unique:usr,mel,' . Auth::id() . ',id',
        'current_password' => 'nullable|string',
        'new_password' => 'nullable|string|min:5',
    ], [
        'name.required' => 'Nama diperlukan.',
        'name.string' => 'Nama mesti dalam bentuk teks.',
        'name.max' => 'Nama tidak boleh melebihi 255 aksara.',

        'ic.required' => 'Nombor IC diperlukan.',
        'ic.string' => 'Nombor IC mesti dalam bentuk teks.',
        'ic.max' => 'Nombor IC tidak boleh melebihi 12 aksara.',
        'ic.unique' => 'Nombor IC ini sudah wujud.',

        'hp.required' => 'Nombor telefon diperlukan.',
        'hp.string' => 'Nombor telefon mesti dalam bentuk teks.',
        'hp.max' => 'Nombor telefon tidak boleh melebihi 15 aksara.',

        'mel.required' => 'Alamat emel diperlukan.',
        'mel.email' => 'Masukkan alamat emel yang sah.',
        'mel.max' => 'Alamat emel tidak boleh melebihi 255 aksara.',
        'mel.unique' => 'Alamat emel ini sudah digunakan.',

        'new_password.min' => 'Kata laluan baharu mesti sekurang-kurangnya 8 aksara.',
    ]);

    try {
        $user->update($request->only(['name', 'ic', 'hp', 'mel']));

        // Update password if provided
        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (md5($request->current_password) !== $user->pass) {
                return redirect()->back()->withErrors(['current_password' => 'Kata laluan semasa tidak betul.']);
            }

            $user->update([
                'pass' => md5($request->new_password),
            ]);
            $this->logActivity('Kemaskini Kata Laluan', 'Kata laluan pengguna berjaya dikemaskini');
        }

        $this->logActivity('Kemaskini Profil', 'Profil pengguna berjaya dikemaskini');
        return redirect()->back()->with('success', 'Profil berjaya dikemaskini!');

    } catch (\Exception $e) {
        \Log::error('Kemaskini profil gagal: ' . $e->getMessage());

        return redirect()->back()->withErrors(['error' => 'Terdapat masalah semasa mengemaskini profil. Sila cuba lagi nanti.']);
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
