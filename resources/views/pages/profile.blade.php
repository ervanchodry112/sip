@extends('layout.app')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Profile</div>
                        <div id="error" class="d-none alert alert-danger alert-dismissible fade">
                            <span>Gagal mengubah password</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div id="success" class="d-none alert alert-success alert-dismissible fade">
                            <span>Berhasil mengubah password</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('user.update', auth()->id()) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ auth()->id() }}">
                            <input type="hidden" name="user_level" value="{{ auth()->user()->user_level }}">
                            <table class="w-75">
                                <tr>
                                    <td>
                                        <label for="name">Nama Lengkap</label>
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" id="name"
                                            class="form-control my-2 @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') ?? auth()->user()->name }}">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="username">Username</label>
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" id="username"
                                            class="form-control my-2 @error('username') is-invalid @enderror"
                                            name="username" value="{{ old('username') ?? auth()->user()->username }}"
                                            readonly disabled>
                                        @error('username')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="user_foto">Foto</label>
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <input type="file"
                                            class="form-control my-2 @error('user_foto') is-invalid @enderror"
                                            id="user_foto" name="user_foto"
                                            value="{{ old('user_foto') ?? auth()->user()->user_foto }}">
                                        @error('user_foto')
                                            {{ $message }}
                                        @enderror
                                    </td>
                                </tr>
                                @if (!empty(auth()->user()->user_foto))
                                    <tr>
                                        <td colspan="2"></td>
                                        <td>
                                            <img src="{{ auth()->user()->user_foto }}" width="150" alt="Foto Profil">
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="3">
                                        <button type="submit" id="btn-submit" class="btn btn-primary my-2"
                                            disabled>Simpan</button>
                                        <button type="button" id="btn-reset" class="d-none btn btn-outline-danger"
                                            disabled>Reset</button>
                                        <button type="button" id="btn-change-password" class="btn btn-warning"
                                            data-bs-toggle="modal" data-bs-target="#modal-change-password">Ubah
                                            Password</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="modal-change-password" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="w-100">
                        <tr>
                            <td>
                                <label for="current_password">Password saat ini</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input type="password" name="current_password" id="current_password" class="form-control"
                                    placeholder="Current Password">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="new_password">Password Baru</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input type="password" name="new_password" id="new_password" class="form-control my-2"
                                    placeholder="New Password">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="new_password_confirmation">Konfirmasi Password</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                    class="form-control" placeholder="Confirm Password">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close-modal" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" id="save-password-change" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function(){
                $('#error').print();
            })
            const header = {
                Authorization: 'Bearer {{ session('token') }}'
            };

            $('.form-control').on('change keyup', function() {
                $('#btn-submit').attr('disabled', false);
                $('#btn-reset').attr('disabled', false);
                $('#btn-reset').removeClass('d-none');
            });

            $('#btn-reset').on('click', function() {
                $('#btn-reset').attr('disabled', true);
                $('#btn-reset').addClass('d-none');

                $('#name').val("{{ auth()->user()->name }}");
            });

            $('#save-password-change').on('click', function() {
                const current = $('#current_password').val();
                const new_pass = $('#new_password').val();
                const confirm = $('#new_password_confirmation').val();

                $.ajax({
                    type: 'PUT',
                    url: "{{ route('user.change_password', auth()->id()) }}",
                    headers: header,
                    data: {
                        current_password: current,
                        new_password: new_pass,
                        new_password_confirmation: confirm
                    },
                    success: function(res) {
                        if (res.status == 200) {
                            $('#success').addClass('show');
                            $('#success').removeClass('d-none');
                        } else {
                            $('#error').addClass('show');
                            $('#error').removeClass('d-none');
                        }
                        $('#close-modal').click();
                        $('#current_password').val();
                        $('#new_password').val();
                        $('#new_password_confirmation').val();
                    }
                });
            });
        </script>
    @endpush
@endsection
