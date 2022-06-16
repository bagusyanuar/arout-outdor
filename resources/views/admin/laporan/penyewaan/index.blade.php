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
            <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Laporan Penyewaan</p>
            <ol class="breadcrumb breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Laporan Penyewaan
                </li>
            </ol>
        </div>
        <div class="w-100 p-2">
            <p class="font-weight-bold mb-0">Filter Tanggal</p>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center w-50">
                    <input type="date" class="form-control" name="tgl1" id="tgl1" value="{{ date('Y-m-d') }}">
                    <span class="font-weight-bold mr-2 ml-2">S/D</span>
                    <input type="date" class="form-control" name="tgl2" id="tgl2" value="{{ date('Y-m-d') }}">
                </div>
                <div class="text-right">
                    <a href="#" class="btn btn-primary" id="btn-cetak">
                        <i class="fa fa-print mr-2"></i>
                        <span>Cetak</span>
                    </a>
                </div>
            </div>

            <table id="table-data" class="display w-100 table table-bordered">
                <thead>
                <tr>
                    <th width="5%" class="text-center">#</th>
                    <th>Nama</th>
                    <th>No. Transaksi</th>
                    <th width="12%">Tanggal Sewa</th>
                    <th width="12%">Lama Sewa</th>
                    <th>Total</th>
                    <th>Denda</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div class="text-right">
            <span class="mr-2 font-weight-bold">Total Pendapatan : </span>
            <span class="font-weight-bold" id="lbl-total">Rp. 0</span>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script type="text/javascript">
        var table;

        function reload() {
            table.ajax.reload();
        }

        $(document).ready(function () {
            table = DataTableGenerator('#table-data', '/laporan-penyewaan/data', [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'user.username'},
                {data: 'no_transaksi'},
                {data: 'tanggal'},
                {
                    data: null, render: function (data, type, row, meta) {
                        let tgl1 = data['tanggal'];
                        let tgl2 = data['tanggal_kembali'];
                        return calculate_days(tgl1, tgl2);
                    }
                },
                {data: 'total'},
                {data: 'denda'},
                {
                    data: null, render: function (data, type, row, meta) {
                        let tgl1 = data['tanggal'];
                        let tgl2 = data['tanggal_kembali'];
                        let status = '-';
                        switch (data['status']) {
                            case 'lunas':
                                status = 'Lunas';
                                break;
                            case 'proses':
                                status = 'Proses Sewa';
                                break;
                            case 'selesai':
                                status = 'Selesai';
                                break;
                            default:
                                break;
                        }
                        return status;
                    }
                },
            ], [], function (d) {
                d.tgl1 = $('#tgl1').val();
                d.tgl2 = $('#tgl2').val();
            }, {
                dom: 'ltipr',
                "fnDrawCallback": function( oSettings ) {
                    let data = this.fnGetData();
                    let sum_total = data.map(item => item['total']).reduce((prev, next) => prev + next, 0);
                    let sum_denda = data.map(item => item['denda']).reduce((prev, next) => prev + next, 0);
                    let total = sum_total + sum_denda;
                    $('#lbl-total').html('Rp. '+total);
                }
            });

            $('#tgl1').on('change', function (e) {
                reload();
            });
            $('#tgl2').on('change', function (e) {
                reload();
            });

            $('#btn-cetak').on('click', function (e) {
                e.preventDefault();
                let tgl1 = $('#tgl1').val();
                let tgl2 = $('#tgl2').val();
                window.open('/laporan-penyewaan/cetak?tgl1=' + tgl1 + '&tgl2=' + tgl2, '_blank');
            })
        });
    </script>
@endsection
