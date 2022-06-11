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
                </tr>
                </thead>
                <tbody>
                @forelse($data->keranjang as $v)
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
                    <span class="w-50 font-weight-bold">No. Transaksi</span>
                    <span class="w-50 text-right font-weight-bold" id="lbl-sub-total"
                    >Rp. {{ $data->no_transaksi }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="w-50 font-weight-bold">Tanggal Sewa</span>
                    <span class="w-50 text-right font-weight-bold" id="lbl-sub-total"
                    >{{ $data->tanggal }}</span>
                </div>
                @php
                    $sewa = new DateTime($data->tanggal);
                    $kembali = new DateTime($data->tanggal_kembali);
                    $interval = $sewa->diff($kembali);

                @endphp
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="w-50 font-weight-bold">Tanggal Kembali</span>
                    <span class="w-50 text-right font-weight-bold" id="lbl-sub-total"
                    >{{ $data->tanggal_kembali }}</span>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="w-50 font-weight-bold">Sub Total</span>
                    <span class="w-50 text-right font-weight-bold" id="lbl-sub-total"
                    >Rp. {{ $data->keranjang->sum('total') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="w-50 font-weight-bold">Lama Sewa</span>
                    <span class="w-50 text-right font-weight-bold" id="lbl-sub-total"
                    >({{$interval->d }} hari)</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="w-50 font-weight-bold">Total</span>
                    <span class="w-50 text-right font-weight-bold" id="lbl-sub-total"
                    >Rp. {{ $data->total }}</span>
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
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="w-50 font-weight-bold">Status</span>
                    <span class="w-50 text-right font-weight-bold" id="lbl-sub-total"
                    >{{ $status }}</span>
                </div>
                @if($data->status == 'tolak')
                    <div class="mb-2" style="border: 1px solid gray; border-radius: 10px; padding: 10px 10px;">
                        <p class="font-weight-bold mb-0">Deskripsi</p>
                        <span class=""
                        >{{ $data->deskripsi }}</span>
                    </div>
                @endif
                <hr>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#table-data').DataTable();
        });
    </script>
@endsection
