<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    use HasFactory;

    protected $table = 'client';
    
    public $timestamps = false;
        
    protected $fillable = [
        'uid',
        'name',
        'cate1',
        'cate',
        'rem8',
        'rem9',
        'addr',
        'addr1',
        'pcode',
        'city',
        'state',
        'hp',
        'fax',
        'mel',
        'web',
        'rem10',
        'rem11',
        'rem12',
        'rem13',
        'rem14',
        'rem15',
        'location',
        'con1',
        'ic',
        'pos1',
        'tel1',
        'sta',
        'country',
        'firebase_id',
        'imgProfile',
        'isustaz',
        'iskariah',
        'sid',
        'regdt',
        'app',
    ];

    public function Type()
    {
        return $this->belongsTo(Parameter::class, 'cate1', 'code');
    }
    public function Category()
    {
        return $this->belongsTo(Parameter::class, 'cate', 'code');
    }
    public function City()
    {
        return $this->belongsTo(Parameter::class, 'city', 'code');
    }
    public function Subdistrict()
    {
        return $this->belongsTo(Parameter::class, 'rem9', 'code');
    }
    public function District()
    {
        return $this->belongsTo(Parameter::class, 'rem8', 'code');
    }
    public function State()
    {
        return $this->belongsTo(Parameter::class, 'state', 'code');
    }
    public function Country()
    {
        return $this->belongsTo(Parameter::class, 'country', 'code');
    }
    public function UserPosition()
    {
        return $this->belongsTo(Parameter::class, 'pos1', 'code');
    }
}
