@extends('admin.layout')

@section('css')
@endsection

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire("Berhasil!", '{{\Illuminate\Support\Facades\Session::get('success')}}', "success")
        </script>
    @endif
    <div class="container-fluid pt-3">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Pesanan</p>
            <ol class="breadcrumb breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/pesanan">Pesanan</a>
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
                <div class="col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <p class="font-weight-bold">Bukti Pembayaran</p>
                            <a target="_blank"
                               href="{{ asset('assets/bukti')."/".$data->bukti }}">
                                <img src="{{  asset('assets/bukti')."/".$data->bukti }}" alt="Gambar Produk"
                                     style="width: 185px; height: 185px; object-fit: cover">
                            </a>
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
                                    <label for="status">Proses Pesanan</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="lunas">Lunas</option>
                                        <option value="tolak">Tolak Pembayaran</option>
                                    </select>
                                </div>
                                <div class="form-group w-100 d-none" id="reason">
                                    <label for="deskripsi">Alasan</label>
                                    <textarea class="form-control" rows="3" name="deskripsi" id="deskripsi"></textarea>
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

        $(document).ready(function () {
            $('#table-data').DataTable();
            $('#status').on('change', function () {
                let val = this.value;
                if (val === 'tolak') {
                    $('#reason').removeClass('d-none')
                    $('#reason').addClass('d-block')
                } else {
                    $('#reason').removeClass('d-block')
                    $('#reason').addClass('d-none')
                }
            })
        });
    </script>
@endsection
