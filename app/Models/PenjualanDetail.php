<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory;

    protected $table = 'penjualan_detail';

    protected $fillable = [
        'id_penjualan',
        'id_barang',
        'jumlah',
        'quantity'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id');
    }

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_penjualan', 'id');
    }
}
