<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'id_satuan',
        'kdbrg',
        'nmbrg',
        'harga',
        'stock',
        'terjual',
        'deleted_at'
    ];

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'id_satuan', 'id');
    }

    public function carts()
    {
        return $this->hasMany(CartDetail::class, 'id_barang', 'id');
    }

    // CRUD
    public function saveProduk()
    {
        return $this->save();
    }

    public function updateProduk($data)
    {
        return $this->update($data);
    }

    public function deleteProduk()
    {
        return $this->update([
            'deleted_at'    => now()
        ]);
    }

    public function generateKodeBarang()
    {
        $code = substr($this->nmbrg, 0, 3);
        $number = ItemNumber::getNumber();
        $this->kdbrg = Str::upper($code . '-' . sprintf('%06d', $number));
    }
}
