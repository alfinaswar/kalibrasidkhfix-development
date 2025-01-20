<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class po extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pos';
    protected $guarded = ['id'];

    public function getCustomer()
    {
        return $this->hasOne(MasterCustomer::class, 'id', 'CustomerId');
    }

    public function getKaryawan()
    {
        return $this->hasOne(User::class, 'id', 'ApproveBy');
    }
    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'idUser');
    }

    public function getSertifikat()
    {
        return $this->hasMany(Sertifikat::class, 'PoId', 'id');
    }

    public function DetailPo()
    {
        return $this->hasMany(poDetail::class, 'PoId', 'id');
    }

    public function getAkomodasiDetail()
    {
        return $this->hasMany(AkomodasiDetail::class, 'PoId', 'id');
    }
}
