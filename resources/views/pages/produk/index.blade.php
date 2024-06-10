@extends('layout.app')

@section('content')
    <div class="pagetitle"></div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Barang</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="d-flex gap-3">
                                <input type="search" id="search-input" class="form-control" name="search" id="search"
                                    placeholder="Cari">
                                <button type="button" id="search-btn" class="btn btn-sm btn-outline-primary">
                                    <span class="bi bi-search"></span>
                                </button>
                            </div>
                            <div>
                                <a href="{{ route('produk.report') }}" target="__blank" class="btn btn-sm btn-success">
                                    <span class="bi bi-printer"></span>
                                    Cetak Laporan
                                </a>
                                <a href="{{ route('produk.create') }}" class="btn btn-sm btn-primary">
                                    <span class="bi bi-plus-circle"></span>
                                    Tambah Data
                                </a>
                            </div>
                        </div>
                        <x-session-alert />
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        No.
                                    </th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Satuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table-data">
                                @php
                                    $i = 1;
                                @endphp
                                @forelse ($products as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item->kdbrg }}</td>
                                        <td>{{ $item->nmbrg }}</td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <div>Rp </div>
                                                <div>{{ number_format($item->harga) }}</div>
                                            </div>
                                        </td>
                                        <td>{{ $item->stock }}</td>
                                        <td>{{ $item->satuan->nmsatuan }}</td>
                                        <td>
                                            <div class="d-flex gap-2">

                                                <a href="{{ route('produk.edit', $item->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    Ubah
                                                </a>
                                                <form action="{{ route('produk.destroy', $item->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Yakin ingin menghapus data?')"
                                                        class="btn btn-sm btn-danger">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
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
                                                <a href="{{ route('produk.create') }}"
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

                        {{ $products->links() }}
                    </div>
                </div>


            </div>
        </div>
    </section>
    @push('scripts')
        <script>
            $('#search-btn').on('click', () => {
                $.ajax({
                    url: "{{ route('produk.search') }}",
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
                                                <a href="{{ route('produk.create') }}"
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
                                        <td>${element.kdbrg}</td>
                                        <td>${element.nmbrg}</td>
                                        <td>${element.harga}</td>
                                        <td>${element.stock} ${element.satuan.nmsatuan}</td>
                                        <td class="d-flex gap-2">
                                            <a href="{{ route('produk.index') }}/${element.id}" class="btn btn-sm btn-warning">
                                                Ubah
                                            </a>
                                            <form action="{{ route('produk.index') }}/${element.id}" method="post">
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
