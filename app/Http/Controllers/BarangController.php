<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Barang;
use App\Models\Satuan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Produk',
            'products'  => Barang::whereNull('deleted_at')->paginate(25),
        ];
        return view('pages.produk.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title'     => 'Tambah Produk',
            'satuan'    => Satuan::get(),
        ];

        return view('pages.produk.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        $produk = new Barang($request->validated());

        DB::beginTransaction();
        try {
            $produk->generateKodeBarang();
            if (!$produk->saveProduk()) {
                throw new Exception('Gagal menyimpan produk!');
            }
            DB::commit();
            return to_route('produk.index')->with('success', 'Berhasil menyimpan produk!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $produk)
    {
        $data = [
            'title'     => 'Ubah data produk',
            'product'   => $produk,
            'satuan'    => Satuan::get(),
        ];

        return view('pages.produk.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Barang $produk)
    {
        DB::beginTransaction();
        try {
            if (!$produk->updateProduk($request->validated())) {
                throw new Exception('Gagal mengupdate data produk!');
            }
            DB::commit();
            return to_route('produk.index')->with('success', 'Berhasil menyimpan data produk!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $produk)
    {
        DB::beginTransaction();
        try {
            if (!$produk->deleteProduk()) {
                throw new Exception('Gagal menghapus data produk!');
            }
            DB::commit();
            return to_route('produk.index')->with('success', 'Berhasil menghapus produk!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function search(Request $request)
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

    public function report()
    {
        $data = [
            'products'  => Barang::get(),
            'total'     => 0
        ];

        return view('report.laporan-produk', $data);
    }
}
