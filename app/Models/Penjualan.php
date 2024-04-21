<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';

    protected $fillable = [
        'tgl_penjualan',
        'jam_penjualan',
        'total',
        'created_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function detail()
    {
        return $this->hasMany(PenjualanDetail::class, 'id_penjualan', 'id');
    }
}
