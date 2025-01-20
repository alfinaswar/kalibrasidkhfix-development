<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'quotations';
    protected $guarded = ['id'];

    public function DetailQuotation()
    {
        return $this->hasMany(QuotationDetail::class, 'idQuotation', 'id');
    }

    public function getPO()
    {
        return $this->hasOne(po::class, 'QuotationId', 'id');
    }
    public function getPO2()
    {
        return $this->hasOne(po::class, 'QuotationId', 'id');
    }

    public function getCustomer()
    {
        return $this->hasOne(MasterCustomer::class, 'id', 'CustomerId');
    }

    public function getAkomodasi()
    {
        return $this->hasOne(MasterAkomodasi::class, 'id', 'AkomodasiId');
    }

    public function getAkomodasiDetail()
    {
        return $this->hasMany(AkomodasiDetail::class, 'idQuotation', 'id');
    }

    public function getKaryawan()
    {
        return $this->hasOne(User::class, 'id', 'ApproveBy');
    }
}
