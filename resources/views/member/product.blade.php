@extends('member.layout')

@section('content')
    <div id="overlay-loading">
        <div class="d-flex justify-content-center align-items-center" id="overlay-loading-child">
            <p class="font-weight-bold color-white">Sedang Menambah Keranjang....</p>
        </div>
    </div>
    <div class="container-fluid mt-2" style="padding-left: 50px; padding-right: 50px; padding-top: 10px;">
        <ol class="breadcrumb breadcrumb-transparent mb-2">
            <li class="breadcrumb-item">
                <a href="/dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $data->nama }}
            </li>
        </ol>
        <div class="w-100 row product-detail">
            <div class="col-lg-4 col-md-12">
                <img src="{{ asset('/assets/barang'). '/' . $data->gambar }}" height="400"
                     alt="Gambar Produk" class="mr-3 w-100">
            </div>
            <div class="col-lg-5 col-md-12">
                <div class="flex-grow-1">
                    <div class="font-weight-bold" style="font-size: 24px">{{ $data->nama }}</div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div style="font-size: 14px; color: #777777">{{ $data->category->nama }}</div>
                    </div>
                    <div class="font-weight-bold color-green" style="font-size: 24px">Rp. {{ $data->harga }}</div>
                    <div style="text-align: justify">{{ $data->deskripsi }}</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-12">
                <div style="border: solid 1px #777777; border-radius: 5px; padding: 10px;">
                    <p class="font-weight-bold">Atur Jumlah</p>
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div style="font-size: 14px; color: #777777" class="w-50" data-qty="{{$data->qty}}" id="lbl-stock">Sisa {{ $data->qty }}</div>
                        <div class="d-flex mb-2">
                            <a href="#" class="btn btn-sm btn-outline-primary mr-1 btn-min"><i class="fa fa-minus"></i></a>
                            <input class="form-control form-control-sm text-right w-100" type="number" id="qty"
                                   name="qty"
                                   value="1">
                            <a href="#" class="btn btn-sm btn-primary ml-1 btn-add"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="mr-1" style="color: #777777">Subtotal</div>
                        <div class="flex-grow-1 text-right" style="font-size: 20px; font-weight: bold">
                            Rp. {{ $data->harga }}</div>
                    </div>
                    <div class="w-100 mt-2 mb-1">
                        <a href="#" class="btn btn-primary w-100" id="btn-add-cart">Tambah Keranjang</a>
                    </div>
                    <div class="w-100">
                        <a href="#" class="btn btn-outline-primary w-100" id="btn-rent">Sewa Sekarang</a>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

@section('js')
    <script>
        var barang_id = '{{$data->id}}';
        async function addToCart(direct = false) {
            try {
                blockLoading(true);
                let response = await $.post('/keranjang/create', {
                    barang: barang_id,
                    qty: $('#qty').val()
                });
                blockLoading(false);
                if(response.status === 202) {
                    window.location.href = '/login-member';
                }else {
                    if (direct === true) {
                        window.location.href = '/keranjang';
                    }else {
                        window.location.reload();
                    }

                }
                console.log(response);
            }catch(e) {
                console.log(e.response.status)

            }
        }
        $(document).ready(function () {

            $('.btn-add').on('click', function (e) {
                e.preventDefault();
                let currentQty = parseInt($('#qty').val());
                let stock = parseInt($('#lbl-stock').attr('data-qty'));
                if(stock > currentQty) {
                    console.log(currentQty);
                    $('#qty').val(currentQty + 1);
                }

            });

            $('.btn-min').on('click', function (e) {
                e.preventDefault();
                let currentQty = parseInt($('#qty').val());
                let qty = currentQty - 1;
                if (qty > 0) {
                    $('#qty').val(qty);
                }
            });

            $('#btn-add-cart').on('click', function (e) {
                e.preventDefault();
                addToCart();
            })

            $('#btn-rent').on('click', function (e) {
                e.preventDefault();
                addToCart(true);
            })
        });
    </script>
@endsection
