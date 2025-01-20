<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SertifikatFisikFungsi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sertifikat_fisik_fungsis';
    protected $guarded = ['id'];
    protected $casts = [
        'Parameter1' => 'json',
        'Parameter2' => 'json',
        'Parameter3' => 'json',
        'Parameter4' => 'json',
        'Parameter5' => 'json',
        'Parameter6' => 'json',
        'Parameter7' => 'json',
        'Parameter8' => 'json',
        'Parameter9' => 'json',
        'Parameter10' => 'json',
        'Parameter11' => 'json',
        'Parameter12' => 'json',
        'Parameter13' => 'json',
    ];
}
