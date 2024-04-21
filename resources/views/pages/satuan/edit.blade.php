@extends('layout.app')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Ubah Satuan</div>
                        <form action="{{ route('satuan.update', $satuan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ old('id') ?? $satuan->id }}">
                            <div class="mb-3">
                                <label for="nmsatuan" class="form-label">Nama Satuan</label>
                                <input type="text" class="form-control @error('nmsatuan') is-invalid @enderror"
                                    name="nmsatuan" id="nmsatuan" value="{{ old('nmsatuan') ?? $satuan->nmsatuan }}">
                                @error('nmsatuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Ex: Kg, cm, etc</div>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('satuan.index') }}" class="btn btn-outline-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection