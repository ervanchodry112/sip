@extends('layout.app')

@section('content')
    <div class="pagetitle"></div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Satuan</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="d-flex gap-3">
                                <input type="search" id="search-input" class="form-control" name="search" id="search"
                                placeholder="Cari">
                                <button type="button" id="search-btn" class="btn btn-sm btn-outline-primary">
                                    <span class="bi bi-search"></span>
                                </button>
                            </div>
                            <div>
                                <a href="{{ route('satuan.create') }}" class="btn btn-sm btn-primary">
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
                                        Nomor
                                    </th>
                                    <th>Nama Satuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table-data">
                                @php
                                    $i = 1;
                                @endphp
                                @forelse ($satuan as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item->nmsatuan }}</td>
                                        <td class="d-flex gap-2">
                                            <a href="{{ route('satuan.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                                Ubah
                                            </a>
                                            <form action="{{ route('satuan.destroy', $item->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Yakin ingin menghapus data?')" class="btn btn-sm btn-danger">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-3">
                                            <div>
                                                <span class="bi bi-exclamation-square fs-1"></span>
                                            </div>
                                            <div class="fw-semibold fs-4">Belum ada data</div>
                                            <div>
                                                <a href="{{ route('satuan.create') }}"
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

                        {{ $satuan->links() }}
                    </div>
                </div>


            </div>
        </div>
    </section>
    @push('scripts')
        <script>
            $('#search-btn').on('click', () => {
                $.ajax({
                    url: "{{ route('satuan.search') }}",
                    data: {
                        search: $('#search-input').val()
                    },
                    success: function(result) {
                        let html = "";
                        if (result.status != 200) {
                            html += `<tr>
                                        <td colspan="3" class="text-center py-3">
                                            <div>
                                                <span class="bi bi-exclamation-square fs-1"></span>
                                            </div>
                                            <div class="fw-semibold fs-4">Belum ada data</div>
                                            <div>
                                                <a href="{{ route('satuan.create') }}"
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
                                        <td>${element.nmsatuan}</td>
                                        <td class="d-flex gap-2">
                                            <a href="{{ route('satuan.index') }}/${element.id}/edit" class="btn btn-sm btn-warning">
                                                Ubah
                                                </a>
                                            <form action="{{ route('satuan.index') }}/${element.id}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Yakin ingin menghapus data?')" class="btn btn-sm btn-danger">
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
