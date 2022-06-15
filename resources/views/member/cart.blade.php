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
            <li class="breadcrumb-item active" aria-current="page">Keranjang
            </li>
        </ol>
        <div class="mt-2">
            <table id="table-data" class="display w-100 table table-bordered">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Gambar</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Total</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($data as $v)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>
                            <a target="_blank"
                               href="{{ asset('assets/barang')."/".$v->barang->gambar }}">
                                <img
                                    src="{{ asset('assets/barang')."/".$v->barang->gambar }}"
                                    alt="Gambar Produk"
                                    style="width: 75px; height: 80px; object-fit: cover"/>
                            </a>
                        </td>
                        <td>{{ $v->barang->nama }}</td>
                        <td>{{ $v->qty }}</td>
                        <td>{{ $v->harga }}</td>
                        <td>{{ $v->total }}</td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="{{ $v->id }}"><i
                                    class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
        </div>
        <hr>
        <div class="row mb-3">
            <div class="col-lg-8 col-md-7"></div>
            <div class="col-lg-4 col-md-5">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="w-50 font-weight-bold">Sub Total</span>
                    <span class="w-50 text-right font-weight-bold" id="lbl-sub-total"
                          data-sub="{{ $data->sum('total') }}">Rp. {{ $data->sum('total') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="w-50 font-weight-bold">Tanggal Pinjam</span>
                    <div class="d-flex justify-content-end align-items-center w-50">
                        <input type="date" name="tanggal" id="tanggal" class="form-control form-control-sm w-75"
                               value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="w-50 font-weight-bold">Lama Pinjam (hari)</span>
                    <div class="d-flex justify-content-end align-items-center w-50">
                        <input type="number" name="duration" id="duration" class="form-control form-control-sm w-50"
                               value="1">
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="w-50 font-weight-bold">Total</span>
                    <span class="w-50 text-right font-weight-bold" id="lbl-total">Rp. {{ $data->sum('total') }}</span>
                </div>
                <hr>
                <a href="#" class="btn btn-outline-primary w-100" id="btn-checkout">Checkout</a>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>

        async function checkout() {
            try {
                blockLoading(true);
                let response = await $.post('/keranjang/checkout', {
                    lama: $('#duration').val(),
                    tanggal: $('#tanggal').val()
                });
                blockLoading(false);
                let payload = response['payload'];
                window.location.href = '/transaksi/' + payload + '/pembayaran';
            } catch (e) {
                alert('Terjadi Kesalahan');
            }
        }

        async function delete_keranjang(id) {
            try {
                blockLoading(true);
                let response = await $.post('/keranjang/destroy', {
                    id: id
                });
                blockLoading(false);
                window.location.reload()
            } catch (e) {
                alert('Terjadi Kesalahan');
            }
        }
        $(document).ready(function () {
            $('#table-data').DataTable();
            $('#duration').on('change', function () {
                let qty = parseInt(this.value);
                let sub = parseInt($('#lbl-sub-total').attr('data-sub'));
                let total = qty * sub;
                $('#lbl-total').html('RP. ' + total);
                console.log(total);
            });

            $('#btn-checkout').on('click', function (e) {
                e.preventDefault();
                checkout();
            });

            $('.btn-delete').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                AlertConfirm('Apakah anda yakin menghapus?', 'Data yang dihapus tidak dapat dikembalikan!', function () {
                    delete_keranjang(id);
                });
            })


        });
    </script>
@endsection
