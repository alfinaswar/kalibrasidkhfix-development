<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SerahTerima extends Model
{
    use HasFactory;

    protected $table = 'serah_terimas';
    protected $guarded = ['id'];

    public function Stdetail()
    {
        return $this->hasMany(SerahTerimaDetail::class, 'SerahTerimaId', 'id');
    }

    public function getNamaAlat()
    {
        return $this->hasOne(Instrumen::class, 'id', 'InstrumanId');
    }

    public function dataKaji()
    {
        return $this->hasMany(KajiUlang::class, 'SerahTerimaId', 'id');
    }
    public function getQuotation()
    {
        return $this->hasOne(Quotation::class, 'SerahTerimaId', 'id');
    }
    public function getPO()
    {
        return $this->hasMany(po::class, 'SerahTerimaId', 'id');
    }
    public function getPO2()
    {
        return $this->hasMany(po::class, 'SerahTerimaId', 'id');
    }
    public function CekPO()
    {
        return $this->hasOne(po::class, 'id', 'SerahTerimaId');
    }

    public function getCustomer()
    {
        return $this->hasOne(MasterCustomer::class, 'id', 'CustomerId');
    }
    public function getCatatan()
    {
        return $this->hasOne(CatatanKajiUlang::class, 'KajiUlangId', 'id');
    }
}
