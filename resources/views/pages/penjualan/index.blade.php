@extends('layout.app')

@section('content')
    <div class="pagetitle"></div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Penjualan</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="d-flex gap-3">
                                <input type="search" id="search-input" class="form-control" name="search" id="search"
                                    placeholder="Cari">
                                <button type="button" id="search-btn" class="btn btn-sm btn-outline-primary">
                                    <span class="bi bi-search"></span>
                                </button>
                            </div>
                            <div>
                                <a href="{{ route('penjualan.report') }}" target="__blank" class="btn btn-sm btn-success">
                                    <span class="bi bi-printer"></span>
                                    Cetak Laporan
                                </a>
                                <a href="{{ route('penjualan.create') }}" class="btn btn-sm btn-primary">
                                    <span class="bi bi-plus-circle"></span>
                                    Tambah Data
                                </a>
                            </div>
                        </div>
                        <x-session-alert />
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%;">
                                        No.
                                    </th>
                                    <th class="text-center" style="width: 15%;">Tgl</th>
                                    <th class="text-center" style="width: 10%">Waktu</th>
                                    <th class="text-center" style="width: 10%">Nomor Invoice</th>
                                    <th class="text-center" style="width: 45%;">Barang</th>
                                    <th class="text-center" style="width: 15%;">Total</th>
                                    <th class="text-center" style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table-data">
                                @php
                                    $i = 1;

                                @endphp
                                @forelse ($penjualan as $item)
                                    <tr>
                                        <td class="text-center align-middle">{{ $i++ }}</td>
                                        <td class="text-center align-middle">
                                            {{ \Carbon\Carbon::parse($item->tgl_penjualan)->isoFormat('D MMMM Y') }}</td>
                                        <td class="text-center align-middle">{{ $item->jam_penjualan }} WIB</td>
                                        <td class="text-center align-middle">{{ $item->nomor_transaksi ?? '-' }}</td>
                                        <td>
                                            <ul>
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
                                        <td class="fw-semibold text-center align-middle">Rp
                                            {{ number_format($item->total) }}</td>
                                        <td class="text-center align-middle">
                                            <a href="{{ route('penjualan.show', $item->id) }}"
                                                class="btn btn-sm btn-warning w-100 mb-2">
                                                <span class="bi bi-eye-fill"></span>
                                                Detail
                                            </a>
                                            <a href="{{ route('penjualan.bukti-transaksi', $item->id) }}"
                                                class="btn btn-sm btn-success w-100 mb-2" target="__blank">
                                                <span class="bi bi-printer-fill"></span>
                                                Cetak
                                            </a>
                                            <form action="{{ route('penjualan.destroy', $item->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Yakin ingin menghapus data?')"
                                                    class="btn btn-sm btn-danger w-100">
                                                    <span class="bi bi-trash-fill"></span>
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-3">
                                            <div>
                                                <span class="bi bi-exclamation-square fs-1"></span>
                                            </div>
                                            <div class="fw-semibold fs-4">Belum ada data</div>
                                            <div>
                                                <a href="{{ route('penjualan.create') }}"
                                                    class="btn btn-sm btn-primary bg-gradient mt-2">
                                                    <span class="bi bi-plus-circle"></span>
                                                    Tambah Data
                                                </a>
                                            </div>

                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                        {{ $penjualan->links() }}
                    </div>
                </div>


            </div>
        </div>
    </section>
    @push('scripts')
        <script>
            $('#search-btn').on('click', () => {
                $.ajax({
                    url: "{{ route('penjualan.search') }}",
                    data: {
                        search: $('#search-input').val()
                    },
                    success: function(result) {
                        let html = "";
                        if (result.status != 200) {
                            html += `<tr>
                                        <td colspan="6" class="text-center py-3">
                                            <div>
                                                <span class="bi bi-exclamation-square fs-1"></span>
                                            </div>
                                            <div class="fw-semibold fs-4">Belum ada data</div>
                                            <div>
                                                <a href="{{ route('penjualan.create') }}"
                                                    class="btn btn-sm btn-primary bg-gradient mt-2">
                                                    <span class="bi bi-plus-circle"></span>
                                                    Tambah Data
                                                </a>
                                            </div>

                                        </td>
                                    </tr>`;
                        } else {
                            let i = 1;
                            result.data.forEach(element => {
                                const temp = `<tr>
                                        <td>${i++}</td>
                                        <td>${element.tgl_penjualan}</td>
                                        <td>${element.jam_penjualan}</td>
                                        <td>
                                            <ul>

                                            </ul>
                                        </td>
                                        <td>${element.total}</td>
                                        <td class="d-flex gap-2">
                                            <a href="{{ route('penjualan.index') }}/${element.id}" class="btn btn-sm btn-warning">
                                                Ubah
                                            </a>
                                            <form action="{{ route('penjualan.index') }}/${element.id}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Yakin ingin menghapus data?')"
                                                    class="btn btn-sm btn-danger">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>`
                                html += temp;
                            });
                        }

                        $("#table-data").html(html);
                    }
                });
            });
        </script>
    @endpush
@endsection
