<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;

    protected $table = 'satuan';

    protected $fillable = [
        'nmsatuan'
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_satuan', 'id');
    }


    // CRUD
    public function simpanSatuan()
    {
        return $this->save();
    }

    public function hapusSatuan()
    {
        return $this->delete();
    }

    public function updateSatuan($data){
        return $this->update($data);
    }
}
