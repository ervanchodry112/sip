@extends('layout.layout')

@section('layout')
    <div class="container-fluid vh-100 d-flex justify-content-center align-items-center">
        <div class="bg-white w-25 border px-4 py-4 rounded-3 shadow-lg">
            <div class="fw-bold fs-3 text-primary text-center">Login</div>
            <div class="w-100 border my-3"></div>
            @if (\Session::has('error'))
                <div class="alert alert-danger d-flex align-items-center justify-content-between mx-auto text-nowrap"
                    role="alert">
                    <span style="font-size: .8rem;">
                        <span class="bi bi-exclamation-triangle"></span>
                        {{ \Session::get('error') }}
                    </span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form action="{{ route('login.attempt') }}" class="d-flex flex-column align-items-center gap-3" method="POST">
                @csrf
                <div class="w-100">
                    <input type="text" class="form-control  @error('username') is-invalid @enderror" name="username"
                        id="username" placeholder="Username">
                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="w-100">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                        id="password" placeholder="Password">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-sm btn-primary bg-gradient w-25">Login</button>
            </form>
        </div>
    </div>
@endsection
