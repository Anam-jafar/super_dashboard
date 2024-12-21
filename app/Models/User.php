<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable; // Use the Authenticatable trait
    protected $table = 'usr';


    protected $fillable = ['ic', 'pass'];
    protected $hidden = ['pass'];
}