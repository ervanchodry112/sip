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
            <div class="col-lg-5">
                <div class="card pb-4">
                    <div class="card-body">
                        <div class="card-title">Daftar Produk</div>
                        <div class="d-flex align-items-center gap-3 mb-3 w-75">
                            <input type="search" class="form-control" name="search" id="search" placeholder="Search">
                            <button type="button" id="btn-search" class="btn btn-primary">
                                <span class="bi bi-search"></span>
                            </button>
                        </div>
                        <div id="product-wrapper" class="w-100 overflow-y-auto" style="height: 65vh;">
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
                                            onclick="addToCart({{ $item->id }})">
                                            <span class="bi bi-cart-plus"></span>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="text-secondary d-flex flex-column justify-content-center align-items-center h-100">
                                    <div>
                                        <span class="bi bi-exclamation-triangle fs-1"></span>
                                    </div>
                                    <div class="fw-semibold fs-4">Produk tidak ditemukan</div>
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
            @php
                $total = 0;
            @endphp
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Keranjang</div>
                        <div class="mb-3" id="cart-wrapper" style="height: 60%;">
                            @forelse ($carts as $cart)
                                @php
                                    $total += $cart->subtotal;
                                @endphp
                                <div class="border rounded-3 p-3 mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label for="{{ $cart->id }}-qty">
                                            <h5>
                                                <span class="fs-5 fw-bold">{{ $cart->barang->nmbrg }}</span>
                                                <span class="fs-6">/ {{ $cart->barang->kdbrg }}</span>
                                            </h5>
                                        </label>
                                        <div id="{{ $cart->id }}-subtotal" class="fw-semibold">Rp
                                            {{ number_format($cart->subtotal) }}</div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small>Stok: {{ $cart->barang->stock }}
                                            {{ $cart->barang->satuan->nmsatuan }}</small>
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="button" class="subQty btn btn-primary btn-sm rounded-3"
                                                onclick="changeQty({{ $cart->id }}, '-')">
                                                <span class="bi bi-dash"></span>
                                            </button>
                                            <input type="number" class="form-control form-control-sm text-center"
                                                style="width: 15%;" name="qty" id="{{ $cart->id }}-qty"
                                                value="{{ $cart->quantity }}"
                                                onchange="changeQty({{ $cart->id }}, null, true)">
                                            <button type="button" class="addQty btn btn-primary btn-sm rounded-3"
                                                onclick="changeQty({{ $cart->id }}, '+')">
                                                <span class="bi bi-plus"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="text-secondary d-flex flex-column justify-content-center align-items-center h-100">
                                    <div>
                                        <span class="bi bi-box2-fill fs-1"></span>
                                    </div>
                                    <div class="fw-semibold fs-4">Keranjang masih kosong!</div>
                                </div>
                            @endforelse
                        </div>
                        <div class="mb-2">
                            <div class="row mb-2">
                                <div class="col-3">Tanggal/Waktu </div>
                                <div class="col-3">:</div>
                                <div id="date" class="col-6 text-end">
                                    {{ now()->timezone('asia/jakarta')->locale('id_ID')->isoFormat('D MMMM Y, HH:mm') }}
                                    WIB
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-3">Total </div>
                                <div class="col-4">:</div>
                                <div class="input-group col-4" style="width: 40%">
                                    <div class="input-group-text">Rp</div>
                                    <input type="text" class="form-control" id="total"
                                        value="{{ number_format($total) }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-3">Bayar </div>
                                <div class="col-4">:</div>
                                <div class="input-group col-4" style="width: 40%">
                                    <div class="input-group-text">Rp</div>
                                    <input type="text" class="form-control" id="bayar" value="0">
                                    <div class="invalid-feedback">Pembayaran tidak mencukupi!</div>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-3">Kembali </div>
                                <div class="col-4">:</div>
                                <div class="input-group col-4" style="width: 40%">
                                    <div class="input-group-text">Rp</div>
                                    <input type="text" class="form-control" id="kembali" value="0" readonly>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="button" id="btn-bayar" class="btn btn-primary bg-gradient">Bayar</button>
                            <button type="button" id="btn-checkout"
                                class="d-none btn btn-primary bg-gradient">Simpan</button>
                            <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="button" class="btn btn-danger bg-gradient" id="reset-button">
                                Reset Keranjang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body"></div>
                    </div>
                </div>
            </div> --}}
    </section>
    @push('scripts')
        <script>
            let nf = new Intl.NumberFormat();
            const header = {
                Authorization: 'Bearer {{ session('token') }}'
            };

            function updateKembalian() {
                const total = parseInt($('#total').val().replace(/,/g, ''));
                const bayar = $('#bayar').val();
                if (bayar == '' || bayar == '0') {
                    $('#kembali').val(0);
                    $('#bayar').val(0);
                } else {
                    const kembali = bayar - total;
                    $('#kembali').val(kembali);
                }
            }

            $('#btn-bayar').on('click', function() {
                const total = $('#total').val();
                const bayar = $('#bayar').val();

                if (bayar < total) {
                    $('#bayar').addClass('is-invalid');
                } else {
                    $('#bayar').removeClass('is-invalid');
                    updateKembalian();
                    $('#btn-checkout').removeClass('d-none');
                    $('#btn-bayar').addClass('d-none');
                }
            });

            $('#btn-checkout').on('click', function() {
                $('#btn-checkout').attr('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('penjualan.checkout') }}",
                    headers: header,
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
                            updateKembalian();
                        }
                    });
                }
                $('#reset-button').attr('disabled', false);
            });



            function changeQty(id, op = null, override = false) {
                $('.addQty').attr('disabled', true);
                $('.subQty').attr('disabled', true);

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
                        const subtotal = result.data.subtotal;
                        const qty = result.data.quantity;
                        const cartSubtotal = result.data.cart.subtotal;

                        $('#total').val(nf.format(cartSubtotal));
                        $(`#${id}-subtotal`).html(`Rp ${nf.format(subtotal)}`);
                        $(`#${id}-qty`).val(qty);
                        updateKembalian();
                    },
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
                        let html = '';
                        if (result.status != 201) {
                            html += `<div class="text-secondary d-flex flex-column justify-content-center align-items-center h-100">
                                        <div>
                                            <span class="bi bi-box2-fill fs-1"></span>
                                        </div>
                                        <div class="fw-semibold fs-4">Keranjang masih kosong!</div>
                                    </div>`;
                        } else {
                            result.data.detail.forEach(element => {
                                html += `<div class="border rounded-3 p-3 mb-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="${element.id}-qty">
                                                <h5>
                                                    <span class="fs-5 fw-bold">${element.barang.nmbrg}</span>
                                                    <span class="fs-6">/ ${element.barang.kdbrg}</span>
                                                </h5>
                                            </label>
                                            <span class="fw-semibold">Rp ${nf.format(element.subtotal)}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small>Stok: ${element.barang.stock}
                                                ${element.barang.satuan.nmsatuan}</small>
                                            <div class="d-flex justify-content-end gap-2">
                                                <button type="button" class="subQty btn btn-primary btn-sm rounded-3" onclick="changeQty(${element.id}, '-')">
                                                    <span class="bi bi-dash"></span>
                                                </button>
                                                <input type="number" class="form-control form-control-sm text-center"
                                                    style="width: 15%;" name="qty" id="${element.id}-qty"
                                                    value="${element.quantity}">
                                                <button type="button" class="addQty btn btn-primary btn-sm rounded-3" onclick="changeQty(${element.id}, '+')">
                                                    <span class="bi bi-plus"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>`;
                            });
                        }
                        updateKembalian();
                        $('#total').val(nf.format(result.data.subtotal));
                        $('#cart-wrapper').html(html);
                        $('#btn-search').attr('disabled', false);
                    },
                })
                $('.addCartBtn').attr('disabled', false);
            }

            $('#btn-search').on('click', () => {
                $('#product-wrapper').html(`<div class="text-secondary d-flex flex-column justify-content-center align-items-center h-100">
                                        <div class="spinner-border" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>`)
                $('#btn-search').attr('disabled', true);
                $.ajax({
                    url: "{{ route('penjualan.searchProduk') }}",
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
                                        <div class="fw-semibold fs-4">Produk tidak ditemukan</div>
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
                                            <button type="button" class="btn btn-primary btn-sm rounded-3">
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
