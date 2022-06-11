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
            <li class="breadcrumb-item">
                <a href="/transaksi">Transaksi</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $data->no_transaksi }}
            </li>
        </ol>
        <div class="mt-5">
            <div class="row">
                <div class="col-lg-7 col-md-6">
                    <img src="{{ asset('/assets/icon/payment.png') }}" width="500">
                </div>
                <div class="col-lg-5 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <span class="w-50 font-weight-bold">No. Transaksi</span>
                                <span class="w-50  font-weight-bold">: {{ $data->no_transaksi }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <span class="w-50 font-weight-bold">Tanggal Sewa</span>
                                <span class="w-50  font-weight-bold">: {{ $data->tanggal }}</span>
                            </div>
                            @php
                                $sewa = new DateTime($data->tanggal);
                                $kembali = new DateTime($data->tanggal_kembali);
                                $interval = $sewa->diff($kembali);

                            @endphp
                            <div class="d-flex align-items-center mb-2">
                                <span class="w-50 font-weight-bold">Tanggal Kembali</span>
                                <span class="w-50 font-weight-bold">: {{ $data->tanggal_kembali }} ({{$interval->d }} hari)</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <span class="w-50 font-weight-bold">Total</span>
                                <span class="w-50  font-weight-bold">: Rp. {{ $data->total }}</span>
                            </div>
                            @php
                                $status = 'Belum Lunas';
                                switch ($data->status){
                                    case 'menunggu':
                                        $status = 'Menunggu';
                                        break;
                                    case  'lunas':
                                        $status = 'Lunas';
                                        break;
                                    case  'tolak':
                                        $status = 'Pesanan Di Tolak';
                                        break;
                                    case  'proses':
                                        $status = 'Proses Sewa';
                                        break;
                                    case  'selesai':
                                        $status = 'Selesai';
                                        break;
                                    default:
                                        break;
                                }
                            @endphp
                            <div class="d-flex align-items-center mb-2">
                                <span class="w-50 font-weight-bold">Status</span>
                                <span class="w-50  font-weight-bold">: {{ $status }}</span>
                            </div>
                            <hr>
                            @if($data->status == 'pesan')
                                <form method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group w-100 mt-2">
                                        <label for="bank">Pembayaran Bank</label>
                                        <select class="form-control" id="bank" name="bank" required>
                                            <option value="">--pilih bank--</option>
                                            <option value="BCA">BRI</option>
                                            <option value="BCA">BCA</option>
                                            <option value="MANDIRI">MANDIRI</option>
                                        </select>
                                    </div>
                                    <div class="w-100 mb-1">
                                        <label for="bukti" class="form-label">Gambar Bukti Transfer</label>
                                        <input type="file" class="form-control-file" id="bukti"
                                               placeholder="Gambar Bukti"
                                               name="bukti" required>
                                    </div>
                                    <hr>
                                    <button type="submit" class="btn btn-primary w-100" id="btn-checkout">Upload
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <hr>
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
                window.location.href = '/transaksi';
            } catch (e) {
                alert('Terjadi Kesalahan');
            }
        }

        $(document).ready(function () {
        });
    </script>
@endsection
