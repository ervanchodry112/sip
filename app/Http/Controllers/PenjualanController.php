<?php

namespace App\Http\Controllers;

use App\Http\Requests\Penjualan\CreatePenjualanRequest;
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
            'penjualan' => Penjualan::orderBy('created_at', 'DESC')->paginate(25),
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
            'products'  => Barang::whereNull('deleted_at')->get(),
            'carts'     => auth()->user()->cart->detail,
        ];

        return view('pages.penjualan.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePenjualanRequest $request)
    {
        $user = $request->user();
        DB::beginTransaction();
        try {
            $penjualan = $user->checkout($request->bayar, $request->kembali);
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
        $data = [
            'title' => 'Detail Penjualan',
            'penjualan' => $penjualan,
        ];

        return view('pages.penjualan.show', $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        DB::beginTransaction();
        try {
            if (!$penjualan->deletePenjualan()) {
                throw new Exception('Gagal menghapus data penjualan!');
            }
            DB::commit();
            return to_route('penjualan.index')->with('success', 'Berhasil menghapus data penjualan!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
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
        $produk = Barang::whereNull('deleted_at')->where('nmbrg', 'like', $search)->orWhere('kdbrg', 'like', $search)->with('satuan')->get();
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

    public function bukti_transaksi(Penjualan $penjualan)
    {
        $data = [
            'penjualan' => $penjualan
        ];
        return view('report.bukti-transaksi', $data);
    }

    public function report()
    {
        $data = [
            'penjualan' => Penjualan::orderBy('created_at', 'DESC')->get(),
            'total'     => Penjualan::sum('total'),
        ];

        return view('report.laporan-penjualan', $data);
    }
}
