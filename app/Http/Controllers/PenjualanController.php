<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title'     => 'Penjualan',
            'penjualan' => Penjualan::paginate(25),
        ];

        return view('pages.penjualan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title'     => 'Tambah Penjualan',
            'products'  => Barang::get(),
            'carts'     => auth()->user()->cart->detail,
        ];

        return view('pages.penjualan.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        DB::beginTransaction();
        try {
            $penjualan = $user->checkout();
            $response = [
                'status'    => 201,
                'data'      => $penjualan,
            ];
            DB::commit();
            return response($response, 201);
        } catch (Exception $e) {
            DB::rollBack();
            $response = [
                'status'    => 500,
                'message'   => $e->getMessage()
            ];
            return response($response, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Penjualan $penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penjualan $penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        //
    }

    public function search(Request $request)
    {
        $search = "%$request->search%";
        $produk = Penjualan::where('tgl_penjualan', 'like', $search)->with('satuan')->get();
        if (empty($produk->toArray())) {
            $response = [
                'status'    => 404,
                'message'   => 'Data tidak ditemukan',
            ];
        } else {
            $response = [
                'status'    => 200,
                'data'      => $produk,
            ];
        }

        return response($response);
    }

    public function searchProduk(Request $request)
    {
        $search = "%$request->search%";
        $produk = Barang::where('nmbrg', 'like', $search)->orWhere('kdbrg', 'like', $search)->with('satuan')->get();
        if (empty($produk->toArray())) {
            $response = [
                'status'    => 404,
                'message'   => 'Data tidak ditemukan',
            ];
        } else {
            $response = [
                'status'    => 200,
                'data'      => $produk,
            ];
        }

        return response($response);
    }
}
