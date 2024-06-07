@extends('layout.app')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Tambah Barang</div>
                        <form action="{{ route('produk.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nmbrg" class="form-label">Nama Barang<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nmbrg') is-invalid @enderror"
                                    name="nmbrg" id="nmbrg" value="{{ old('nmbrg') }}" required>
                                @error('nmbrg')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="kdbrg" class="form-label">Kode Barang</label>
                                <input type="text" class="form-control @error('kdbrg') is-invalid @enderror"
                                    name="kdbrg" id="kdbrg" value="{{ old('kdbrg') }}">
                                @error('kdbrg')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga Barang<span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('harga') is-invalid @enderror"
                                        name="harga" id="harga" value="{{ old('harga') }}" placeholder="0"
                                        min="0" required>
                                </div>
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <label for="stock" class="form-label">Stok Barang<span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                        name="stock" id="stock" value="{{ old('stock') }}" placeholder="0"
                                        min="0" required>
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label for="id_satuan" class="form-label">
                                        Satuan<span class="text-danger">*</span>
                                    </label>
                                    <select name="id_satuan" class="form-select @error('id_satuan') is-invalid @enderror"
                                        aria-label="Default select example" required>
                                        <option disabled selected>Pilih satuan</option>
                                        @foreach ($satuan as $item)
                                            <option value="{{ $item->id }}"
                                                @if (old('id_satuan') == $item->id) selected @endif>
                                                {{ $item->nmsatuan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_satuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-text mb-3">
                                <span class="text-danger">*</span>: Wajib diisi
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
