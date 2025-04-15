<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use HasFactory;

    protected $table = 'type';

    public $timestamps = false;

    protected $fillable = ['prm', 'val', 'code', 'grp', 'sta', 'idx', 'des', 'sid', 'lvl', 'etc', 'isdel'];

}
