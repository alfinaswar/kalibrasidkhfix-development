<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjustLK extends Model
{
    use HasFactory;

    protected $table = 'adjust_lk';
    protected $guarded = ['id'];
    protected $casts = [
        'FisikFungsi' => 'json',
        'KeselamatanListrik' => 'json',
    ];
}
