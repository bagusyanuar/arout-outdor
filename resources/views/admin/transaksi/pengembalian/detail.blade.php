@extends('admin.layout')

@section('css')
@endsection

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire("Berhasil!", '{{\Illuminate\Support\Facades\Session::get('success')}}', "success")
        </script>
    @endif
    @if (\Illuminate\Support\Facades\Session::has('failed'))
        <script>
            Swal.fire("Gagal!", '{{\Illuminate\Support\Facades\Session::get('failed')}}', "error")
        </script>
    @endif
    <div class="container-fluid pt-3">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Pengembalian Pesanan</p>
            <ol class="breadcrumb breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/pengembalian">Pengembalian Pesanan</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $data->no_transaksi }}
                </li>
            </ol>
        </div>
        <div class="w-100 p-2">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <p class="font-weight-bold">Detail Pesanan</p>
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
                                    case  'tolak':
                                        $status = 'Pesanan Di Tolak';
                                        break;
                                    case  'lunas':
                                        $status = 'Lunas';
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
                        </div>
                    </div>
                </div>
            </div>
            <p class="font-weight-bold">Barang Pesanan</p>
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
            <div class="card mt-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-7 col-md-12"></div>
                        <div class="col-lg-5 col-md-12">
                            <form method="post">
                                @csrf
                                <div class="form-group w-100 mt-2">
                                    <label for="kembali">Di Kembalikan Tanggal</label>
                                    <input type="date" class="form-control" id="kembali" name="kembali" required value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="font-weight-bold w-50">Keterlambatan</span>
                                    <span class="font-weight-bold w-50 text-right" id="terlambat">0 hari</span>
                                </div>
                                <div class="form-group w-100 mt-2 d-none" id="panel-denda">
                                    <label for="denda">Denda</label>
                                    <input type="number" class="form-control" id="denda" name="denda" required value="0">
                                </div>
                                <button type="submit" class="btn btn-primary w-100" id="btn-submit">Submit
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script type="text/javascript">
        var tanggal_kembali = '{{ $data->tanggal_kembali }}';

        function calculate_between_days(tgl1, tgl2) {
            let diff_in_time = tgl2.getTime() - tgl1.getTime();
            return diff_in_time / (1000 * 3600 * 24);
        }

        function hitung_terlambat(val) {
            if(val > 0) {
                $('#terlambat').html(val+' hari');
                $('#panel-denda').addClass('d-block');
                $('#panel-denda').removeClass('d-none');
            } else {
                $('#terlambat').html('0 hari');
                $('#panel-denda').addClass('d-none');
                $('#panel-denda').removeClass('d-block');
                $('#denda').val(0);
            }
        }
        $(document).ready(function () {
            $('#table-data').DataTable();
            $('#kembali').on('change', function () {
                let val = this.value;
                let tgl1 = new Date(tanggal_kembali);
                let tgl2 = new Date(val);
                let terlambat = calculate_between_days(tgl1, tgl2);
                hitung_terlambat(terlambat);
                console.log(terlambat)
            })
        });
    </script>
@endsection
