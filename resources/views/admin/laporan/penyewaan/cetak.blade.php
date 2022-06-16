@extends('admin.cetak.index')

@section('content')
    <div class="text-center f-bold report-title">LAPORAN PENYEWAAN AROUT OUTDOOR</div>
    <div class="text-center">Periode Laporan {{ $tgl1 }} - {{ $tgl2 }} </div>

    <hr>
    <table id="my-table" class="table display">
        <thead>
        <tr>
            <th width="5%" class="text-center">#</th>
            <th>Nama</th>
            <th width="20%">No. Transaksi</th>
            <th>Tanggal Sewa</th>
            <th>Lama Sewa (hari)</th>
            <th>Total</th>
            <th>Denda</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $v)
            <tr>
                <td class="text-center">{{ $loop->index + 1 }}</td>
                <td>{{ $v->user->username }}</td>
                <td>{{ $v->no_transaksi }}</td>
                @php
                    $sewa = new DateTime($v->tanggal);
                    $kembali = new DateTime($v->tanggal_kembali);
                    $interval = $sewa->diff($kembali);
                @endphp
                <td>{{ $v->tanggal }}</td>
                <td>{{ $interval->d }}</td>
                <td class="text-center">{{ $v->total }}</td>
                <td class="text-center">{{ $v->denda }}</td>
                @php
                    $status = '-';
                    switch ($v->status){
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
                <td class="text-center">{{ $status }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <hr>
    <div class="text-right" style="font-weight: bold">
        Total Pendapatan : Rp. {{ $data->sum('total') + $data->sum('denda') }}
    </div>
    <br>
    <hr>
    <div class="row">
        <div class="col-xs-8"></div>
        <div class="col-xs-3">
            <div class="text-center">Admin</div>
            <br>
            <br>
            <br>
            <div class="text-center">(..............)</div>
        </div>
    </div>
@endsection
