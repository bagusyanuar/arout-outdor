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
                <li class="breadcrumb-item active" aria-current="page">Pesanan
                </li>
            </ol>
        </div>
        <div class="w-100 p-2">
            <table id="table-data" class="display w-100 table table-bordered">
                <thead>
                <tr>
                    <th width="5%" class="text-center">#</th>
                    <th>Nama</th>
                    <th>No. Transaksi</th>
                    <th width="12%">Tanggal Sewa</th>
                    <th width="12%">Lama Sewa</th>
                    <th>Total</th>
                    <th width="20%" class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $v)
                    <tr>
                        <td width="5%" class="text-center">{{ $loop->index + 1 }}</td>
                        <td>{{ $v->user->username }}</td>
                        <td>{{ $v->no_transaksi }}</td>
                        <td>{{ $v->tanggal }}</td>
                        @php
                            $sewa = new DateTime($v->tanggal);
                            $kembali = new DateTime($v->tanggal_kembali);
                            $interval = $sewa->diff($kembali);
                        @endphp
                        <td>{{ $interval->d }}</td>
                        <td>{{ number_format($v->total, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <a href="/pesanan/{{ $v->id }}" class="btn btn-sm btn-warning btn-edit"
                               data-id="{{ $v->id }}"><i class="fa fa-info"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            $('#table-data').DataTable();

        });
    </script>
@endsection
