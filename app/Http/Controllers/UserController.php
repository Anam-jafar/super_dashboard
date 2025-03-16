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
            'mailaddr3' => ''
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
                $user->DEPARTMENT = $user->Department->prm ?? null;
                $user->POSITION = $user->Position->prm ?? null;
                if ($user->joblvl == null){
                    $user->DISTRICT_ACCESS = null;
                }else{
                    $user->DISTRICT_ACCESS = $user->DistrictAcceess->prm ?? null;
                }
                $user->USER_GROUP = $user->UserGroup->prm ?? null;
            return $user;
        });

        return view('user.list', [
            'parameters' => $this->getCommon(),
            'users' => $users
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $validatedData = $this->validateInput($request);


            $validatedData['uid'] = $this->generateUniqueUid();

            $dataToInsert = array_merge($this->defaultUserValues, $validatedData);
            

            User::create($dataToInsert);

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
        return view('user.edit', ['user' => $user, 'parameters' => $this->getCommon()]);        
    }
}
