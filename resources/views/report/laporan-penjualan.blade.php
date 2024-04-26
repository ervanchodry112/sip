<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Penjualan | {{ now()->isoFormat('DD MMMM Y') }}</title>
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
        <h4 class="text-center">Laporan Penjualan</h4>
        <div class="text-center fs-5">{{ now()->isoFormat('D MMMM Y') }}
            WIB</div>
        <hr>
        <table class="table table-bordered">
            <thead class="table-secondary">
                <tr class="text-center">
                    <th class="text-start" style="width: 5%">No.</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Produk</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penjualan as $item)
                    <tr class="align-middle">
                        <th>{{ $i++ }}</th>
                        <td>{{ $item->tgl_penjualan }}</td>
                        <td>{{ $item->jam_penjualan }}</td>
                        <td>
                            <ul class="p-1">
                                @php
                                    $j = 1;
                                @endphp
                                @foreach ($item->detail as $detail)
                                    <li style="list-style: none;">
                                        <div>
                                            <span class="fw-bold">{{ $detail->barang->nmbrg }}</span> /
                                            <small>{{ $detail->barang->kdbrg }}</small>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <small>
                                                Rp {{ number_format($detail->barang->harga) }} x
                                                {{ $detail->quantity }}
                                                {{ $detail->barang->satuan->nmsatuan }}
                                            </small>
                                            <div class="fw-semibold">
                                                Rp {{ number_format($detail->jumlah) }}
                                            </div>

                                        </div>
                                    </li>
                                    @if ($j++ < count($item->detail))
                                        <hr>
                                    @endif
                                @endforeach
                            </ul>
                        </td>
                        <td class="fw-semibold">
                            <div class="d-flex justify-content-between">
                                <span>Rp</span>
                                <span>{{ number_format($item->total) }}</span>
                            </div>
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
                        <span>{{ number_format($total) }}</span>
                    </td>
                </tr>
            </tfoot>
        </table>
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
