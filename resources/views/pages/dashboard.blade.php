@extends('layout.app')

@section('content')
    <div class="pagetitle mb-3">
        <h1>Dashboard</h1>
    </div>

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">


                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">Data User Pegawai</h5>

                                    <a href="{{ route('user.index') }}">
                                        <span>Detail</span>
                                        <span class="bi bi-arrow-right"></span>
                                    </a>
                                </div>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 class="fs-2">{{ $users }}</h6>
                                        <span class="text-primary small pt-1 fw-bold">Pegawai</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">Data Barang</h5>
                                    <a href="{{ route('produk.index') }}">
                                        <span>Detail</span>
                                        <span class="bi bi-arrow-right"></span>
                                    </a>
                                </div>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-box-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 class="fs-2">{{ number_format($products) }}</h6>
                                        <span class="text-success small pt-1 fw-bold">Jenis Barang</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Customers Card -->
                    <div class="col-xxl-4 col-xl-12">

                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">Total Penjualan</h5>
                                    <a href="{{ route('penjualan.index') }}">
                                        <span>Detail</span>
                                        <span class="bi bi-arrow-right"></span>
                                    </a>
                                </div>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 class="fs-2">Rp {{ number_format($selling) }}</h6>
                                        <span class="text-danger small pt-1 fw-bold">Total Pendapatan</span>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- End Customers Card -->


                </div>
            </div><!-- End Left side columns -->

        </div>
    </section>
@endsection
