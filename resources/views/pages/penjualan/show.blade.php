@extends('layout.app')
@php
    $i = 1;
@endphp

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Detail Penjualan</div>
                        <div class="d-flex justify-content-end mb-3">
                            <div>
                                <a href="{{ route('penjualan.create') }}" class="btn btn-primary">
                                    <span class="bi bi-plus-circle me-1"></span>
                                    Tambah Data Penjualan
                                </a>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between bg-info-subtle bg-gradient p-3 rounded-2 mb-4">
                            <table class="w-50">
                                <tr>
                                    <td class="text-primary text-opacity-50 fw-semibold" style="width: 50%">Tanggal</td>
                                    <td>{{ \Carbon\Carbon::parse($penjualan->tgl_penjualan)->isoFormat('D MMMM Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-primary text-opacity-50 fw-semibold" style="width: 50%">Waktu</td>
                                    <td>{{ $penjualan->jam_penjualan }} WIB</td>
                                </tr>
                                <tr>
                                    <td class="text-primary text-opacity-50 fw-semibold" style="width: 50%">Kasir</td>
                                    <td>{{ $penjualan->user->name }}</td>
                                </tr>

                            </table>
                            <table class="w-50">
                                <tr>
                                    <td class="text-primary text-opacity-50 fw-semibold" style="width: 50%">Total Pembayaran
                                    </td>
                                    <td>Rp {{ number_format($penjualan->total) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-primary text-opacity-50 fw-semibold" style="width: 50%">Jumlah Barang
                                    </td>
                                    <td>{{ $penjualan->detail()->count() }} Jenis</td>
                                </tr>
                                <tr>
                                    <td class="text-primary text-opacity-50 fw-semibold" style="width: 50%">Nomor Transaksi
                                    </td>
                                    <td>{{ $penjualan->nomor_transaksi }}</td>
                                </tr>
                            </table>
                        </div>
                        <table class="table table-responsive">
                            <thead>

                                <tr>
                                    <th style="width: 5%">
                                        No.
                                    </th>
                                    <th class="text-center">Kode Barang</th>
                                    <th class="text-center">Nama Barang</th>
                                    <th class="text-center">Harga</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-center">Total</th>
                                </tr>

                            </thead>
                            <tbody class="table-group-divider">
                                @foreach ($penjualan->detail as $item)
                                    <tr>
                                        <th class="text-center">{{ $i++ }}</th>
                                        <td class="text-center">{{ $item->barang->kdbrg }}</td>
                                        <td class="text-center">{{ $item->barang->nmbrg }}</td>
                                        <td class="text-center">Rp {{ number_format($item->barang->harga) }}</td>
                                        <td class="text-center">
                                            {{ $item->quantity }} {{ $item->barang->satuan->nmsatuan }}
                                        </td>
                                        <td class="d-flex justify-content-between text-center">
                                            <span>Rp</span>
                                            <span>{{ number_format($item->jumlah) }}<span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-group-divider">
                                <tr class="fw-bold">
                                    <td class="text-end px-4" colspan="5">Total</td>
                                    <td class="d-flex justify-content-between">
                                        <span>Rp</span>
                                        <span>{{ number_format($penjualan->total) }}<span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('penjualan.bukti-transaksi', $penjualan->id) }}" target="__blank" class="btn btn-success">
                                <span class="bi bi-printer-fill me-1"></span>
                                Cetak Bukti Penjualan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
