@extends('layout.app')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Ubah Data Barang</div>
                        <x-session-alert />
                        <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ old('id') ?? $user->id }}">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" id="name" value="{{ old('name') ?? $user->name }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    name="username" id="username" value="{{ old('username') ?? $user->username }}" disabled readonly>
                                    <div class="form-text">*username tidak dapat diubah</div>
                                @error('username')
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
                                            @if (old('user_level') == $item || $user->user_level == $item) selected @endif>
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
                                @if(!empty($user->user_foto))
                                <img src="{{ $user->user_foto }}" width="200" alt="">
                                @endif
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
