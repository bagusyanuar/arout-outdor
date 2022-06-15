<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="css/bootstrap3.min.css" rel="stylesheet">
    <style>
        .report-title {
            font-size: 14px;
            font-weight: bolder;
        }

        .f-bold {
            font-weight: bold;
        }

        .footer {
            position: fixed;
            bottom: 0cm;
            right: 0cm;
            height: 2cm;
        }

        .w-50 {
            width: 50%;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .d-flex {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
<div class="text-center f-bold report-title">NOTA PENYEWAAN BARANG AROUT OUTDOOR</div>
<div class="text-center">
    <span>Jl. Wonogir ray no. 16, Wonogiri, Jawa Tengah</span>
</div>
<hr>
<div class="row">
    <div class="col-xs-2 f-bold">No. Transaksi</div>
    <div class="col-xs-3 f-bold">: {{ $data->no_transaksi }}</div>
    <div class="col-xs-2">Tanggal Sewa</div>
    <div class="col-xs-3">: {{ $data->tanggal }}</div>
</div>
@php
    $sewa = new DateTime($data->tanggal);
    $kembali = new DateTime($data->tanggal_kembali);
    $interval = $sewa->diff($kembali);
@endphp
<div class="row">
    <div class="col-xs-2 f-bold">Username</div>
    <div class="col-xs-3 f-bold">: {{ $data->user->username }}</div>
    <div class="col-xs-2">Tanggal Kembali</div>
    <div class="col-xs-3">: {{ $data->tanggal_kembali }} ({{$interval->d}} hari)</div>
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
<div class="row">
    <div class="col-xs-2">Status</div>
    <div class="col-xs-3">: {{ $status }}</div>
</div>
<hr>
<table id="my-table" class="table display">
    <thead>
    <tr>
        <th width="5%" class="text-center">#</th>
        <th>Nama Barang</th>
        <th>Qty</th>
        <th>Harga</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data->keranjang as $v)
        <tr>
            <td class="text-center">{{ $loop->index + 1 }}</td>
            <td>{{ $v->barang->nama }}</td>
            <td>{{ $v->qty }}</td>
            <td>{{ $v->harga }}</td>
            <td>{{ $v->total }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<hr>
<div class="row">
    <div class="col-xs-7"></div>
    <div class="col-xs-2">
        <div>Sub Total</div>
    </div>
    <div class="col-xs-2">
        <div>: Rp. {{ $data->sum('total') }}</div>
    </div>
</div>
<div class="row">
    <div class="col-xs-7"></div>
    <div class="col-xs-2">
        <div>Lama Sewa</div>
    </div>
    <div class="col-xs-2">
        <div>: {{$interval->d}} hari</div>
    </div>
</div>
<div class="row">
    <div class="col-xs-7"></div>
    <div class="col-xs-2">
        <div>Total</div>
    </div>
    <div class="col-xs-2">
        <div>: Rp. {{ $data->total }}</div>
    </div>
</div>
</body>
</html>
