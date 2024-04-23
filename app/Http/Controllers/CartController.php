<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\CartDetail;
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
                if (!$user->cart()->create()) {
                    throw new Exception('Gagal membuat data keranjang');
                }
            }

            $user->refresh();

            $check = $user->cart->detail()->where('id_barang', $id_barang)->first();
            if (!empty($check)) {
                $qty = (int)$check->quantity + 1;
                $subtotal = $barang->harga * $qty;
                if (!$check->update([
                    'quantity'  => $qty,
                    'subtotal'  => $subtotal,
                ])) {
                    throw new Exception('Gagal menambahkan ke keranjang!');
                }
            } else {
                $data = [
                    'id_barang' => $id_barang,
                    'subtotal'  => $barang->harga,
                    'quantity'  => 1,
                ];
                if (!$user->cart->detail()->create($data)) {
                    throw new Exception('Gagal menambahkan ke keranjang!');
                }
            }
            $updateCart = $user->cart()->withSum('detail as subtotal', 'subtotal')->withSum('detail as total_item', 'quantity')->first()->toArray();

            if (!$user->cart->updateCart($updateCart)) {
                throw new Exception('Gagal menambahkan ke keranjang!');
            }

            $user->refresh();

            $response = [
                'status'    => 201,
                'data'      => $user->cart()->with('detail.barang.satuan')->first()->toArray(),
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

    public function change(Request $request, CartDetail $detail)
    {
        $user = $request->user();
        $operator = $request->operator;
        $quantity = $detail->quantity;

        if (!empty($request->quantity)) {
            $qty = $request->quantity;
        } else {
            if ($operator == '+') {
                $qty = $quantity + 1;
            } else if ($operator == '-') {
                $qty = $quantity - 1;
            }
        }

        if($qty > $detail->barang->stock){
            $qty = $detail->barang->stock;
        }

        DB::beginTransaction();
        try {
            $data = [
                'quantity'  => $qty,
                'subtotal'  => $qty * $detail->barang->harga,
            ];
            if (!$detail->updateQty($data)) {
                throw new Exception('Gagal menyimpan data!');
            }

            $updateCart = $user->cart()->withSum('detail as subtotal', 'subtotal')->withSum('detail as total_item', 'quantity')->first()->toArray();

            if (!$user->cart->updateCart($updateCart)) {
                throw new Exception('Gagal menyimpan data!');
            }

            DB::commit();
            $user->refresh();
            $detail->refresh();
            $response = [
                'status'    => 200,
                'data'      => $detail->with('cart')->find($detail->id)->toArray(),
            ];
            return response($response);
        } catch (Exception $e) {
            DB::rollBack();
            $response = [
                'status'    => 500,
                'message'   => $e->getMessage(),
            ];
            return response($response, 500);
        }
    }

    public function reset(Request $request)
    {
        $user = $request->user();
        DB::beginTransaction();
        try {
            if (!$user->resetCart()) {
                throw new Exception('Gagal mereset keranjang!');
            }

            DB::commit();
            $response = [
                'status'    => 200,
                'message'   => 'Berhasil mereset keranjang',
            ];
            return response($response);
        } catch (Exception $e) {
            DB::rollBack();
            $response = [
                'status'    => 500,
                'message'   => $e->getMessage(),
            ];
            return response($response, 500);
        }
    }

}
