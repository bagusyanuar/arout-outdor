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
            Swal.fire("Gagal", '{{\Illuminate\Support\Facades\Session::get('failed')}}', "error")
        </script>
    @endif
    <div class="container-fluid pt-3">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Kategori Barang</p>
            <ol class="breadcrumb breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/category">Kategori Barang</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit
                </li>
            </ol>
        </div>
        <div class="w-100 p-2">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6 col-sm-11">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="/category/patch">
                                @csrf
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <div class="w-100 mb-1">
                                    <label for="nama" class="form-label">Nama Kategori</label>
                                    <input type="text" class="form-control" id="nama" placeholder="Nama Kategori"
                                           name="nama" value="{{ $data->nama }}">
                                </div>
                                <div class="w-100 mb-2 mt-3 text-right">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
