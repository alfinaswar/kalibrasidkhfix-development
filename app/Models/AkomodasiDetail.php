<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AkomodasiDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'akomodasi_details';
    protected $guarded = ['id'];

    public function getAkomodasi()
    {
        return $this->hasOne(MasterAkomodasi::class, 'id', 'AkomodasiId');
    }
}
