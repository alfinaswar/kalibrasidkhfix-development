<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterAkomodasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'master_akomodasis';
    protected $guarded = ['id'];
}
