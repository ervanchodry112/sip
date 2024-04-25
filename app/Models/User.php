<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_foto',
        'name',
        'username',
        'password',
        'user_level',
        'user_status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function cart()
    {
        return $this->hasOne(Cart::class, 'id_user', 'id');
    }

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'created_by', 'id');
    }

    // CRUD
    public function saveUser()
    {
        $this->save();

        return $this->cart()->create();
    }

    public function updateUser($data)
    {
        return $this->update($data);
    }

    public function resetCart()
    {
        return $this->cart->resetCart();
    }

    public function checkout($bayar, $kembali)
    {
        $data = [
            'tgl_penjualan' => now()->toDateString(),
            'jam_penjualan' => now()->toTimeString(),
            'total'         => $this->cart->subtotal,
            'bayar'         => $bayar,
            'kembali'       => $kembali,
        ];

        if (!$this->penjualan()->create($data)) {
            throw new Exception('Gagal menyimpan data penjualan');
        }

        $this->cart()->update([
            'subtotal'      => 0,
            'total_item'    => 0,
        ]);

        $penjualan = $this->penjualan()->orderBy('created_at', 'DESC')->first();

        foreach ($this->cart->detail as $detail) {
            $data = [
                'id_barang' => $detail->id_barang,
                'jumlah'    => $detail->subtotal,
                'quantity'  => $detail->quantity,
            ];
            if (!$penjualan->detail()->create($data)) {
                throw new Exception('Gagal menyimpan data penjualan!');
            }
            $barang = $detail->barang;
            $barang->update([
                'stock'     => $barang->stock - $detail->quantity,
                'terjual'   => $barang->terjual + $detail->quantity,
            ]);
        }
        if (!$this->cart->detail()->delete()) {
            throw new Exception('Gagal menyimpan data penjualan!');
        }
        $this->refresh();
        return $penjualan;
    }

    public function changePassword($request)
    {
        $data = [
            'password'  => bcrypt($request->new_password),
        ];

        return $this->update($data);
    }
}
