@extends('layout.app')

@section('content')
    <div class="pagetitle"></div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">User</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="d-flex gap-3">
                                <input type="search" id="search-input" class="form-control" name="search" id="search"
                                    placeholder="Cari">
                                <button type="button" id="search-btn" class="btn btn-sm btn-outline-primary">
                                    <span class="bi bi-search"></span>
                                </button>
                            </div>
                            <div>
                                <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary">
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
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Level</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table-data">
                                @php
                                    $i = 1;
                                @endphp
                                @forelse ($users as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->username }}</td>
                                        <td>{{ $item->user_level }}</td>
                                        <td class="d-flex gap-2">
                                            <a href="{{ route('user.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                                Ubah
                                            </a>
                                            <form action="{{ route('user.destroy', $item->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Yakin ingin menghapus data?')"
                                                    class="btn btn-sm btn-danger">
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
                                                <a href="{{ route('user.create') }}"
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

                        {{ $users->links() }}
                    </div>
                </div>


            </div>
        </div>
    </section>
    @push('scripts')
        <script>
            $('#search-btn').on('click', () => {
                $.ajax({
                    url: "{{ route('user.search') }}",
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
                                                <a href="{{ route('user.create') }}"
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
                                        <td>${element.name}</td>
                                        <td>${element.username}</td>
                                        <td>${element.user_level}</td>
                                        <td class="d-flex gap-2">
                                            <a href="{{ route('user.index') }}/${element.id}" class="btn btn-sm btn-warning">
                                                Ubah
                                            </a>
                                            <form action="{{ route('user.index') }}/${element.id}" method="post">
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
