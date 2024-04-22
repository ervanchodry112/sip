<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $user = $request->user();
        $id_barang = $request->id_barang;

        DB::beginTransaction();
        try {

            $barang = Barang::findOrFail($id_barang);

            if (empty($user->cart)) {
                if(!$user->cart()->create()){
                    throw new Exception('Gagal membuat data keranjang');
                }
            }

            $user->refresh();

            $check = $user->cart->detail()->where('id_barang', $id_barang)->first();
            if (!empty($check)) {
                $qty = (int)$check->quantity + 1;
                $subtotal = $barang->harga * $qty;
                if(!$check->update([
                    'quantity'  => $qty,
                    'subtotal'  => $subtotal,
                ])){
                    throw new Exception('Gagal menambahkan ke keranjang!');
                }
            } else {
                $data = [
                    'id_barang' => $id_barang,
                    'subtotal'  => $barang->harga,
                    'quantity'  => 1,
                ];
                if(!$user->cart->detail()->create($data)){
                    throw new Exception('Gagal menambahkan ke keranjang!');
                }
            }

            $response = [
                'status'    => 201,
                'data'      => $user->cart->detail()->with('barang.satuan')->get()->toArray(),
            ];
            DB::commit();
            return response($response, 201);
        } catch (Exception $e) {
            DB::rollBack();
            $response = [
                'status'    => 500,
                'message'   => $e->getMessage(),
            ];
            return response($e);
        }
    }
}
