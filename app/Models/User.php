<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable; // Use the Authenticatable trait
    protected $table = 'usr';
    public $timestamps = false; // This disables the automatic timestamp handling



    protected $fillable = ['ic', 'pass', 'name', 'mel'];
    protected $hidden = ['pass'];
}