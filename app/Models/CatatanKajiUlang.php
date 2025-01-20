<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatatanKajiUlang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'catatan_kaji_ulangs';
    protected $guarded = ['id'];
}
