@extends('layout.app')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Tambah User Baru</div>
                        <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" id="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    name="username" id="username" value="{{ old('username') }}" required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" id="password" required>

                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password<span
                                        class="text-danger">*</span></label>
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    name="password_confirmation" id="password_confirmation" required>

                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="user_level" class="form-label">
                                    User Level<span class="text-danger">*</span>
                                </label>
                                <select name="user_level" class="form-select @error('user_level') is-invalid @enderror"
                                    aria-label="Default select example" required>
                                    <option disabled selected>Pilih level</option>
                                    @foreach ($roles as $item)
                                        <option value="{{ $item }}"
                                            @if (old('user_level') == $item) selected @endif>
                                            {{ Str::title($item) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="user_foto" class="form-label">Foto</label>
                                <input type="file" class="form-control @error('user_foto') is-invalid @enderror"
                                    name="user_foto" id="user_foto" value="{{ old('user_foto') }}" >
                                <div class="form-text">
                                    Max size: 2mb
                                </div>
                                @error('user_foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-text mb-3">
                                <span class="text-danger">*</span>: Wajib diisi
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('user.index') }}" class="btn btn-outline-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
