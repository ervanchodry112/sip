<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    use HasFactory;

    protected $table = 'cart_detail';

    protected $fillable = [
        'id_cart',
        'id_barang',
        'subtotal',
        'quantity'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'id_cart', 'id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id');
    }

    // CRUD
    public function updateQty($data){
        if($data['quantity'] <= 0){
            return $this->deleteCartItem();
        }
        return $this->update($data);
    }

    public function deleteCartItem(){
        return $this->delete();
    }
}
