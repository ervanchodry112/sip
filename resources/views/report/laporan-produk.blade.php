<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Produk | {{ now()->isoFormat('D MMMM Y') }}</title>
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
        <h4 class="text-center">Laporan Penjualan Barang</h4>
        <div class="text-center fs-5">
            {{ now()->isoFormat('D MMMM Y') }} WIB</div>
        <hr>

        <table class="table table-bordered">
            <thead class="table-secondary">
                <tr class="text-center">
                    <th class="text-start" style="width: 5%">No.</th>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Terjual</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $item)
                    @php
                        $total += $item->terjual * $item->harga;
                    @endphp
                    <tr>
                        <th>{{ $i++ }}</th>
                        <td>{{ $item->kdbrg }}</td>
                        <td>{{ $item->nmbrg }}</td>
                        <td class="d-flex justify-content-between">
                            <span>Rp</span>
                            <span>{{ number_format($item->harga) }}</span>
                        </td>
                        <td class="text-center">{{ $item->terjual }} {{ $item->satuan->nmsatuan }}</td>
                        <td class="d-flex justify-content-between">
                            <span>Rp</span>
                            <span>{{ number_format($item->terjual * $item->harga) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="table-secondary">
                <tr>
                    <td colspan="4" class="table-light"></td>
                    <td class="fw-bold text-start pe-4">Total</td>
                    <td class="d-flex justify-content-between fw-bold">
                        <span>Rp</span>
                        <span>{{ number_format($total) }}</span>
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
            window.print();
        });
    </script>
</body>

</html>
