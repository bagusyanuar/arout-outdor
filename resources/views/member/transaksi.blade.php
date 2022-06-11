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
            <li class="breadcrumb-item active" aria-current="page">Transaksi
            </li>
        </ol>
        <div class="mt-5">
            <table id="table-data" class="display w-100 table table-bordered">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">No. Transaksi</th>
                    <th scope="col">Sewa</th>
                    <th scope="col">Kembali</th>
                    <th scope="col">Lama Sewa</th>
                    <th scope="col">Total</th>
                    <th scope="col">Status</th>
                    <th scope="col">action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($data as $v)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>
                            {{ $v->no_transaksi }}
                        </td>
                        <td>{{ $v->tanggal }}</td>
                        <td>{{ $v->tanggal_kembali }}</td>
                        @php
                            $sewa = new DateTime($v->tanggal);
                            $kembali = new DateTime($v->tanggal_kembali);
                            $interval = $sewa->diff($kembali);

                        @endphp
                        <td>{{ $interval->d }} hari</td>
                        <td>{{ $v->total }}</td>
                        @php
                            $status = 'Belum Lunas';
                            switch ($v->status){
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
                        <td>{{ $status }}</td>
                        <td>
                            <a href="/transaksi/{{ $v->id }}/detail" class="btn btn-sm btn-info btn-edit"
                               ><i class="fa fa-info"></i></a>
                            <a href="/transaksi/{{ $v->id }}/pembayaran" class="btn btn-sm btn-success" ><i
                                    class="fa fa-credit-card"></i></a></td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
        </div>
        <hr>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#table-data').DataTable();
        });
    </script>
@endsection
