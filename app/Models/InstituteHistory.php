<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstituteHistory extends Model
{
    use HasFactory;
    protected $table = 'institute_history';
    public $timestamps = false;

    protected $fillable = [
        'inst_refno',
        'institute',
        'institute_type',
        'registration_date',
        'upgrade_date'
    ];

    public function Type()
    {
        return $this->belongsTo(Parameter::class, 'institute', 'code');
    }
    public function Category()
    {
        return $this->belongsTo(Parameter::class, 'institute_type', 'code');
    }
}
