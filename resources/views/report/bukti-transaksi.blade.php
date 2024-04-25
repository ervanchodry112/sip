<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bukti Transaksi | {{ $penjualan->tgl_penjualan }}</title>
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
    $i = 1;
@endphp

<body>
    <div class="container-md p-4">
        <h2 class="text-center">CV. Karya Mandiri</h2>
        <h4 class="text-center">Bandar Lampung</h4>
        <div class="text-center fs-5">{{ \Carbon\Carbon::parse($penjualan->created_at)->isoFormat('D MMMM Y, H:mm') }}
            WIB</div>
        <hr>
        <div class="d-flex justify-content-between mb-3">
            <div class="row">
                <div class="col-3">Kasir</div>
                <div class="col-1">:</div>
                <div class="col-6">{{ $penjualan->user->name }}</div>
            </div>
            <div></div>
        </div>
        <table class="table table-bordered">
            <thead class="table-secondary">
                <tr class="text-center">
                    <th class="text-start" style="width: 5%">No.</th>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penjualan->detail as $item)
                    <tr>
                        <th>{{ $i++ }}</th>
                        <td>{{ $item->barang->kdbrg }}</td>
                        <td>{{ $item->barang->nmbrg }}</td>
                        <td class="text-center">{{ $item->quantity }} {{ $item->barang->satuan->nmsatuan }}</td>
                        <td class="d-flex justify-content-between">
                            <span>Rp</span>
                            <span>{{ number_format($item->jumlah) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="table-secondary">
                <tr>
                    <td colspan="3" class="table-light"></td>
                    <td class="fw-bold text-start pe-4">Total</td>
                    <td class="d-flex justify-content-between fw-bold">
                        <span>Rp</span>
                        <span>{{ number_format($penjualan->total) }}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="table-light"></td>
                    <td class="fw-bold text-start pe-4">Bayar</td>
                    <td class="d-flex justify-content-between fw-bold">
                        <span>Rp</span>
                        <span>{{ number_format($penjualan->bayar) }}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="table-light"></td>
                    <td class="fw-bold text-start pe-4">Kembali</td>
                    <td class="d-flex justify-content-between fw-bold">
                        <span>Rp</span>
                        <span>{{ number_format($penjualan->kembali) }}</span>
                    </td>
                </tr>
            </tfoot>
        </table>
        <div class="text-center">Terima kasih telah berbelanja di toko kami.</div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            window.print()
        });
    </script>
</body>

</html>
