@extends('layout.app')

@push('styles')
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
@endpush

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-4">
                <div class="card pb-4">
                    <div class="card-body">
                        <div class="card-title">Cari Barang</div>
                        <div class="d-flex align-items-center gap-3 w-100">
                            <input type="search" class="form-control" name="search" id="search" placeholder="Search">
                            {{-- <button type="button" id="btn-search" class="btn btn-primary">
                                <span class="bi bi-search"></span>
                            </button> --}}
                        </div>

                    </div>
                </div>
            </div>
            @php
                $total = 0;
            @endphp
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Daftar Barang</div>
                        <div id="product-wrapper" class="w-100 overflow-y-auto" style="height: 35vh;">
                            @forelse ($products as $item)
                                <div class="border rounded-3 p-3 mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5>
                                                <span class="fs-5 fw-bold">{{ $item->nmbrg }}</span>
                                                <span class="fs-6">/ {{ $item->kdbrg }}</span>
                                            </h5>
                                        </div>
                                        <span class="fw-semibold">Rp {{ number_format($item->harga) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small>Stok: {{ $item->stock }} {{ $item->satuan->nmsatuan }}</small>
                                        <button type="button" class="addCartBtn btn btn-primary btn-sm rounded-3"
                                            onclick="addToCart({{ $item->id }})"
                                            @if ($item->stock <= 0) disabled @endif>
                                            Tambah
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="text-secondary d-flex flex-column justify-content-center align-items-center h-100">
                                    <div>
                                        <span class="bi bi-exclamation-triangle fs-1"></span>
                                    </div>
                                    <div class="fw-semibold fs-4">Barang tidak ditemukan</div>
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Keranjang --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Keranjang</div>
                        <table class="table table-bordered">
                            <tr>
                                <td>Tanggal</td>
                                <td>
                                    <input type="text" class="form-control"
                                        value="{{ now()->timezone('asia/jakarta')->locale('id_ID')->isoFormat('D MMMM Y, HH:mm') }}"
                                        disabled>
                                </td>
                            </tr>
                        </table>
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th style="width: 20%;">Jumlah</th>
                                    <th>Total</th>
                                    <th>Kasir</th>
                                    <th style="width: fit-content;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="cart-wrapper">
                                @php
                                    $i = 1;
                                    $total = 0;
                                @endphp
                                @forelse ($carts as $cart)
                                    @php
                                        $total += $cart->subtotal;
                                    @endphp
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $cart->barang->nmbrg }}</td>
                                        <td class="d-flex align-items-center gap-2">
                                            <input type="number" class="form-control" name="{{ $cart->id }}-qty"
                                                id="{{ $cart->id }}-qty" value="{{ $cart->quantity }}" min="0">
                                            {{ $cart->barang->satuan->nmsatuan }}
                                        </td>
                                        <td class="">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>Rp</div>
                                                <div class="ms-auto" id="{{ $cart->id }}-subtotal">
                                                    {{ number_format($cart->subtotal) }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $cart->cart->user->name }}
                                        </td>
                                        <td>
                                            <button type="button" onclick="changeQty({{ $cart->id }}, null, true)"
                                                class="btn btn-sm btn-warning text-white">Update</button>
                                            <button type="button" class="btn btn-sm btn-danger text-white"
                                                onclick="deleteItem({{ $cart->id }})">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div
                                                class="text-secondary d-flex flex-column justify-content-center align-items-center h-100">
                                                <div>
                                                    <span class="bi bi-box2-fill fs-1"></span>
                                                </div>
                                                <div class="fw-semibold fs-4">Keranjang masih kosong!</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <hr>
                        <table class="table align-middle">
                            <tr>
                                <td>Total</td>
                                <td>
                                    <div class="input-group w-100" style="width: 40%">
                                        <div class="input-group-text">Rp</div>
                                        <input type="text" class="form-control" id="total"
                                            value="{{ number_format($total) }}" readonly>
                                    </div>
                                </td>
                                <td>Bayar</td>
                                <td>
                                    <div class="input-group w-100" style="width: 40%">
                                        <div class="input-group-text">Rp</div>
                                        <input type="text" class="form-control" id="bayar" value="0"
                                            min="0">
                                        <div class="invalid-feedback">Pembayaran tidak mencukupi!</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">

                                        <button id="btn-checkout" class="btn btn-success text-nowrap" disabled>
                                            <span class="bi bi-cart-fill"></span>
                                            Bayar
                                        </button>
                                        <button type="button" class="btn btn-danger bg-gradient text-nowrap"
                                            id="reset-button">
                                            Reset
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Kembali</td>
                                <td>
                                    <div class="input-group w-100" style="width: 40%">
                                        <div class="input-group-text">Rp</div>
                                        <input type="text" class="form-control" id="kembali" value="0" readonly>
                                    </div>
                                </td>

                            </tr>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script>
            let nf = new Intl.NumberFormat();
            const header = {
                Authorization: "Bearer {{ session('token') }}"
            };

            function updateKembalian() {
                const total = parseInt($('#total').val().replace(/,/g, ''));
                const bayar = $('#bayar').val();
                if (bayar == '' || bayar == '0') {
                    $('#kembali').val(0);
                    $('#bayar').val();
                } else {
                    const kembali = bayar - total;
                    if (kembali < 0) {
                        $('#bayar').addClass('is-invalid');
                        $('#kembali').val(0);
                        d
                        $('btn-checkout').attr('disabled', true);
                        return;
                    }
                    $('#btn-checkout').attr('disabled', false);
                    $('#bayar').removeClass('is-invalid');
                    $('#kembali').val(kembali);
                }
            }

            $('#bayar').on('keyup', function() {
                updateKembalian();
            });

            $('#btn-checkout').on('click', function() {
                $('#btn-checkout').attr('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('penjualan.checkout') }}",
                    headers: header,
                    data: {
                        bayar: $('#bayar').val(),
                        kembali: $('#kembali').val()
                    },
                    success: function(res) {
                        console.log(res);
                        if (res.status == 201) {
                            location.replace(`{{ route('penjualan.index') }}/${res.data.id}`);
                            // location.href = `{{ route('penjualan.index') }}/${res.data.id}`;
                        }
                    }
                });

                $('#btn-checkout').attr('disabled', false);
            });

            $('#reset-button').on('click', function() {


                $('#reset-button').attr('disabled', true);
                if (confirm('Yakin ingin mereset keranjang?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: "{{ route('cart.reset') }}",
                        headers: header,
                        success: function(result) {
                            if (result.status != 200) {
                                alert(result.message)
                                return;
                            }

                            const html = `<div class="text-secondary d-flex flex-column justify-content-center align-items-center h-100">
                            <div>
                                <span class="bi bi-box2-fill fs-1"></span>
                                </div>
                                <div class="fw-semibold fs-4">Keranjang masih kosong!</div>
                                </div>`;

                            $('#cart-wrapper').html(html);
                            $('#total').val(0);
                            $('#bayar').val(0);
                            $('#kembali').val(0);
                            updateKembalian();
                        }
                    });
                }
                $('#reset-button').attr('disabled', false);
            });

            function deleteItem(id) {
                $.ajax({
                    type: 'DELETE',
                    url: `{{ route('cart.delete') }}/${id}`,
                    headers: header,
                    data: {
                        id_detail: id,
                    },
                    success: function(result) {

                        let i = 1;
                        let html = '';
                        if (result.status != 200) {
                            alert(result.message)
                        } else {
                            if (result.data.detail.length <= 0) {
                                html += ` <tr>
                                        <td colspan="6">
                                            <div
                                                class="text-secondary d-flex flex-column justify-content-center align-items-center h-100">
                                                <div>
                                                    <span class="bi bi-box2-fill fs-1"></span>
                                                </div>
                                                <div class="fw-semibold fs-4">Keranjang masih kosong!</div>
                                            </div>
                                        </td>
                                    </tr>`;
                            } else {
                                result.data.detail.forEach(element => {

                                    html += `<tr>
                                        <td>${i++}</td>
                                        <td>${element.barang.nmbrg}</td>
                                        <td class="d-flex align-items-center gap-2">
                                            <input type="number" class="form-control" name="${element.id}-qty"
                                                onchange="changeQty(${element.id}, null, true)"
                                                id="${element.id}-qty" value="${element.quantity}">
                                            ${element.barang.satuan.nmsatuan}
                                        </td>
                                        <td class="">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>Rp</div>
                                                <div class="ms-auto">${element.subtotal}</div>
                                            </div>
                                        </td>
                                        <td>
                                            ${result.data.user.name}
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning text-white" onclick="changeQty(${element.id}, null, true)">Update</button>
                                            <button type="button" class="btn btn-sm btn-danger text-white" onclick="deleteItem(${element.id})">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </td>
                                    </tr>`;
                                });
                            }
                        }
                        updateKembalian();
                        $('#total').val(nf.format(result.data.subtotal));
                        $('#cart-wrapper').html(html);
                    },
                });
            }


            function changeQty(id, op = null, override = false) {

                let qty = null
                if (override) {
                    qty = $(`#${id}-qty`).val();
                }
                $.ajax({
                    type: 'POST',
                    url: `{{ route('cart.change') }}/${id}`,
                    headers: header,
                    data: {
                        id_detail: id,
                        operator: op,
                        quantity: qty,
                    },
                    success: function(result) {
                        let i = 1;
                        let html = '';
                        if (result.status != 200) {
                            alert(result.message)
                        } else {
                            if (result.data.detail.length <= 0) {
                                html += ` <tr>
                                        <td colspan="6">
                                            <div
                                                class="text-secondary d-flex flex-column justify-content-center align-items-center h-100">
                                                <div>
                                                    <span class="bi bi-box2-fill fs-1"></span>
                                                </div>
                                                <div class="fw-semibold fs-4">Keranjang masih kosong!</div>
                                            </div>
                                        </td>
                                    </tr>`;
                            } else {
                                result.data.detail.forEach(element => {

                                    html += `<tr>
                                        <td>${i++}</td>
                                        <td>${element.barang.nmbrg}</td>
                                        <td class="d-flex align-items-center gap-2">
                                            <input type="number" class="form-control" name="${element.id}-qty"
                                                onchange="changeQty(${element.id}, null, true)"
                                                id="${element.id}-qty" value="${element.quantity}">
                                            ${element.barang.satuan.nmsatuan}
                                        </td>
                                        <td class="">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>Rp</div>
                                                <div class="ms-auto">${element.subtotal}</div>
                                            </div>
                                        </td>
                                        <td>
                                            ${result.data.user.name}
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning text-white" onclick="changeQty(${element.id}, null, true)">Update</button>
                                            <button type="button" class="btn btn-sm btn-danger text-white" onclick="deleteItem(${element.id})">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </td>
                                    </tr>`;
                                });
                            }
                        }
                        $('#total').val(nf.format(result.data.subtotal));
                        $('#cart-wrapper').html(html);
                        updateKembalian();
                    },
                    error: function(error) {
                        const data = JSON.parse(error.responseText);
                        const message = data.message
                        $(`#${id}-qty`).val(data.data.total_item);
                        $(`#${id}-qty`).addClass('is-invalid');

                        alert(message);
                    }
                });

                $('.addQty').attr('disabled', false);
                $('.subQty').attr('disabled', false);
            }

            function addToCart(id) {
                $('.addCartBtn').attr('disabled', true);
                $('#cart-wrapper').html(`<div class="text-secondary d-flex flex-column justify-content-center align-items-center h-100">
                                        <div class="spinner-border" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>`);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('cart.add') }}",
                    headers: header,
                    data: {
                        id_barang: id
                    },
                    success: function(result) {

                        let i = 1;
                        let html = '';
                        if (result.status != 201) {
                            alert(result.message);
                        } else {
                            if (result.data.length <= 0) {
                                html += ` <tr>
                                        <td colspan="6">
                                            <div
                                                class="text-secondary d-flex flex-column justify-content-center align-items-center h-100">
                                                <div>
                                                    <span class="bi bi-box2-fill fs-1"></span>
                                                </div>
                                                <div class="fw-semibold fs-4">Keranjang masih kosong!</div>
                                            </div>
                                        </td>
                                    </tr>`;
                            } else {
                                result.data.detail.forEach(element => {
                                    html += `<tr>
                                        <td>${i++}</td>
                                        <td>${element.barang.nmbrg}</td>
                                        <td class="d-flex align-items-center gap-2">
                                            <input type="number" class="form-control" name="${element.id}-qty"
                                                onchange="changeQty(${element.id}, null, true)"
                                                id="${element.id}-qty" value="${element.quantity}">
                                            ${element.barang.satuan.nmsatuan}
                                        </td>
                                        <td class="">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>Rp</div>
                                                <div class="ms-auto">${element.subtotal}</div>
                                            </div>
                                        </td>
                                        <td>
                                            ${result.data.user.name}
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning text-white" onclick="changeQty(${element.id}, null, true)">Update</button>
                                            <button type="button" class="btn btn-sm btn-danger text-white" onclick="deleteItem(${element.id})">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </td>
                                    </tr>`;
                                });
                            }
                        }
                        updateKembalian();
                        $('#total').val(nf.format(result.data.subtotal));
                        $('#cart-wrapper').html(html);
                        $('#btn-search').attr('disabled', false);
                    },
                })
                $('.addCartBtn').attr('disabled', false);
            }

            $('#search').on('change', () => {
                $('#product-wrapper').html(`<div class="text-secondary d-flex flex-column justify-content-center align-items-center h-100">
                                        <div class="spinner-border" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>`)
                $('#btn-search').attr('disabled', true);
                $.ajax({
                    url: "{{ route('penjualan.searchBarang') }}",
                    data: {
                        search: $('#search').val(),
                    },
                    success: function(result) {
                        let html = '';
                        if (result.status != 200) {
                            html += `<div class="text-secondary d-flex flex-column justify-content-center align-items-center h-100">
                                        <div>
                                            <span class="bi bi-exclamation-triangle fs-1"></span>
                                        </div>
                                        <div class="fw-semibold fs-4">Barang tidak ditemukan</div>
                                    </div>`;
                        } else {
                            result.data.forEach(element => {
                                html += `<div class="border rounded-3 p-3 mb-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h5>
                                                    <span class="fs-5 fw-bold">${element.nmbrg}</span>
                                                    <span class="fs-6">/ ${element.kdbrg}</span>
                                                </h5>
                                            </div>
                                            <span class="fw-semibold">Rp ${element.harga}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small>Stok: ${element.stock} ${element.satuan.nmsatuan}</small>
                                            <button type="button" class="btn btn-primary btn-sm rounded-3" onclick="addToCart(${element.id})">
                                                <span class="bi bi-cart-plus"></span>
                                            </button>
                                        </div>
                                    </div>`;
                            });
                        }
                        $('#product-wrapper').html(html);
                        $('#btn-search').attr('disabled', false);
                    },
                })
            })
        </script>
    @endpush
@endsection
