<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';

    protected $fillable = [
        'id_user',
        'subtotal',
        'total_item',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function detail()
    {
        return $this->hasMany(CartDetail::class, 'id_cart', 'id');
    }

    public function updateCart($data)
    {
        $data['subtotal'] = $data['subtotal'] ?? 0;
        $data['total_item'] = $data['total_item'] ?? 0;
        return $this->update($data);
    }

    public function resetCart()
    {
        return $this->detail()->delete();
    }
}
