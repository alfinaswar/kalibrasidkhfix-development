<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SertifikatManual extends Model
{
    use HasFactory;
    protected $table = 'sertifikat_manuals';
    protected $guarded = ['id'];
}
