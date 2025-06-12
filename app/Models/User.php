<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;
    protected $table = 'usr';
    public $timestamps = false;


    protected $fillable = ['ic', 'pass', 'name', 'mel', 'uid', 'hp', 'jobdiv', 'job', 'joblvl', 'syslevel', 'status', 'imgProfile', 'sch_id', 'login_sta', 'login_ts', 'login_period', 'resettokenexpiration', 'mailaddr', 'mailaddr2', 'mailaddr3', 'password_set', 'cdate', 'll', 'adm', 'ts'];
    protected $hidden = ['pass'];

    public function Department()
    {
        return $this->belongsTo(Parameter::class, 'jobdiv', 'code');
    }
    public function Position()
    {
        return $this->belongsTo(Parameter::class, 'job', 'code');
    }
    public function DistrictAcceess()
    {
        return $this->belongsTo(Parameter::class, 'joblvl', 'code');
    }
    public function UserGroup()
    {
        return $this->belongsTo(Parameter::class, 'syslevel', 'code');
    }

}
