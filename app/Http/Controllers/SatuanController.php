<?php

namespace App\Http\Controllers;

use App\Http\Requests\Satuan\CreateSatuanRequest;
use App\Http\Requests\Satuan\UpdateSatuanRequest;
use App\Models\Satuan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $satuan = Satuan::query();

        // dd(request('search'));
        $data = [
            'title' => 'Satuan',
            'satuan'    => $satuan->paginate(25),
        ];

        return view('pages.satuan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Satuan',
        ];

        return view('pages.satuan.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSatuanRequest $request)
    {
        $satuan = new Satuan($request->validated());

        DB::beginTransaction();
        try {
            if (!$satuan->simpanSatuan()) {
                throw new Exception('Gagal menyimpan data!');
            }
            DB::commit();
            return to_route('satuan.index')->with('success', 'Berhasil menyimpan data!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Satuan $satuan)
    {
        $data = [
            'title' => 'Satuan',
            'satuan'    => $satuan,
        ];

        return view('pages.satuan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSatuanRequest $request, Satuan $satuan)
    {
        DB::beginTransaction();

        try {
            if (!$satuan->updateSatuan($request->validated())) {
                throw new Exception('Gagal mengupdate data!');
            }
            DB::commit();
            return to_route('satuan.index')->with('success', 'Berhasil menyimpan data!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Satuan $satuan)
    {
        DB::beginTransaction();
        try {
            if (!$satuan->hapusSatuan()) {
                throw new Exception('Gagal menghapus data');
            }
            DB::commit();
            return to_route('satuan.index')->with('success', 'Berhasil menghapus data');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function search(Request $request)
    {
        $search = "%$request->search%";
        $satuan = Satuan::where('nmsatuan', 'like', $search)->get();

        if (empty($satuan->toArray())) {
            $response = [
                'status'    => 404,
                'message'   => 'Data tidak ditemukan',
            ];
        } else {
            $response = [
                'status'    => 200,
                'data'      => $satuan,
            ];
        }

        return response($response);
    }
}
