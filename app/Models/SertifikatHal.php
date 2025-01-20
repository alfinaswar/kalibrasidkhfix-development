<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SertifikatHal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sertifikat_hals';

    protected $guarded = ['id'];
}
