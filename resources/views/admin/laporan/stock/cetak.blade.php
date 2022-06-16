@extends('admin.cetak.index')

@section('content')
    <div class="text-center f-bold report-title">LAPORAN STOCK BARANG AROUT OUTDOOR</div>

    <hr>
    <table id="my-table" class="table display">
        <thead>
        <tr>
            <th width="5%" class="text-center">#</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Qty</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $v)
            <tr>
                <td class="text-center">{{ $loop->index + 1 }}</td>
                <td>{{ $v->nama }}</td>
                <td>{{ $v->category->nama }}</td>
                <td class="text-center">{{ $v->qty }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
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
