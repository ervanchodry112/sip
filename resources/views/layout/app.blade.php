@extends('layout.layout')

@section('layout')
    <x-header />

    <x-sidebar />

    <main id="main" class="main">

        @yield('content')


    </main><!-- End #main -->
@endsection
