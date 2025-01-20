<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKeselamatanListrik extends Model
{
    use HasFactory;

    protected $table = 'master_keselamatan_listriks';
    protected $guarded = ['id'];
    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
