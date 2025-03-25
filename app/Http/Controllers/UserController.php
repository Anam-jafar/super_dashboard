<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationApproveConfirmation;
use App\Models\Parameter;
use App\Mail\SendUserOtp;

class UserController extends Controller
{
    public $defaultTime;

    private array $defaultUserValues;

    public function __construct()
    {
        $this->defaultTime = now()->format('Y-m-d H:i:s');

        $this->defaultUserValues = [
            'sch_id' => 1,
            'login_sta' => 0,
            'login_ts' => $this->defaultTime,
            'login_period' => $this->defaultTime,
            'resettokenexpiration' => $this->defaultTime,
            'mailaddr' => '',
            'mailaddr2' => '',
            'mailaddr3' => '',
            'cdate' => $this->defaultTime,
            'll' => $this->defaultTime,
        ];
    }

        private function validateInput(Request $request): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'ic' => 'required|string|max:50',
            'mel' => 'required|string|max:255',
            'hp' => 'required|string|max:50',
            'jobdiv' => 'required|string|max:50',
            'job' => 'required|string|max:50',
            'joblvl' => 'nullable|string|max:50',
            'syslevel' => 'required|string|max:50',
            'status' => 'required|string|max:50',
        ];

        return Validator::make($request->all(), $rules)->validate();
    }


        private function generateUniqueUid()
    {
        $lastUid = DB::table('usr')->orderBy('uid', 'desc')->value('uid');

        $numericPart = intval(substr($lastUid, 1)) ?? 0;

        do {
            $numericPart++;
            $newUid = 'A' . str_pad($numericPart, 5, '0', STR_PAD_LEFT);
            $exists = DB::table('usr')->where('uid', $newUid)->exists();

        } while ($exists); 

        return $newUid;
    }

        private function applyFilters($query, Request $request)
    {
        foreach ($request->all() as $field => $value) {
            if (!empty($value) && \Schema::hasColumn('usr', $field)) {
                $query->where($field, $value);
            }
        }

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', "%{$searchTerm}%");
        }

        return $query;
    }

        public function list(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        
        $query = $this->applyFilters(User::query(), $request);

        $users = $query->with('Department', 'Position', 'DistrictAcceess', 'UserGroup')
            ->orderBy('id', 'desc')
            ->paginate($perPage)->withQueryString();

        
        $users->getCollection()->transform(function ($user) {
            $user->DEPARTMENT = isset($user->Department->prm) ? strtoupper($user->Department->prm) : null;
            $user->POSITION = isset($user->Position->prm) ? strtoupper($user->Position->prm) : null;

            if ($user->joblvl == null) {
                $user->DISTRICT_ACCESS = "SEMUA";
            } else {
                $user->DISTRICT_ACCESS = isset($user->DistrictAcceess->prm) ? strtoupper($user->DistrictAcceess->prm) : null;
            }

            $user->USER_GROUP = isset($user->UserGroup->prm) ? strtoupper($user->UserGroup->prm) : null;
            $user->STATUS = Parameter::where('grp', 'clientstatus')
                ->where('val', $user->status)
                ->pluck('prm', 'val')
                ->map(fn($prm, $val) => ['val' => $val, 'prm' => $prm])
                ->first();

            return $user;
        });


        return view('user.list', [
            'parameters' => $this->getCommon(),
            'users' => $users
        ]);
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
            Auth::guard()->loginUsingId($user->id);
            $this->logActivity('Login', 'log in attempt successful');


            return redirect()->route('index');
        }
        $this->logActivity('Login', 'log in attempt failed');
        return back()->with('error', 'Invalid credentials.');
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $validatedData = $this->validateInput($request);

            $validatedData['uid'] = $this->generateUniqueUid();

            $password = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $validatedData['pass'] = md5($password);
            $validatedData['password_set'] = 0;

            $dataToInsert = array_merge($this->defaultUserValues, $validatedData);

            $user = User::create($dataToInsert);

            Mail::to($user->mel)->send(new SendUserOtp($user->mel, $password, $user->name));

            return redirect()->route('userList')->with('success', 'Pengguna telah berjaya didaftarkan!');
        }

        $parameters = $this->getCommon();
        $parameters['districts'] = ['' => 'Semua'] + $parameters['districts'];

        return view('user.create', ['parameters' => $parameters]);
    }


    public function edit(Request $request, $id)
    {
        $user = User::find($id);

        if ($request->isMethod('post')) {
            $validatedData = $this->validateInput($request);
            
            $user->update($validatedData);

            return redirect()->route('userList')->with('success', 'Pengguna telah berjaya dikemas kini!!');
        }
        $parameters = $this->getCommon();
        $parameters['districts'] = ['' => 'Semua'] + $parameters['districts']; 
        return view('user.edit', ['user' => $user, 'parameters' => $parameters]);        
    }
}
