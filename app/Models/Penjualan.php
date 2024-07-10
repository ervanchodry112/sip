<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';

    protected $fillable = [
        'tgl_penjualan',
        'jam_penjualan',
        'total',
        'bayar',
        'kembali',
        'nomor_transaksi',
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

    // CRUD
    public function deletePenjualan()
    {
        return $this->delete();
    }

    public static function generateInvoiceNumber()
    {
        $last = static::latest()->first();

        if (!$last) {
            return 'ORD-' . now()->toDateString() . '-0001';
        }

        $number = Str::afterLast($last->nomor_transaksi, '-',);

        return 'ORD-' . now()->toDateString() . '-' . sprintf('%04d', (int)$number + 1);
    }
}
