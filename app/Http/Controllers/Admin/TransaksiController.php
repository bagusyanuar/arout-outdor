<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Transaksi;

class TransaksiController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function pesanan()
    {
        $data = Transaksi::with(['user', 'keranjang'])->where('status', '=', 'menunggu')->get();
        return view('admin.transaksi.pesanan.index')->with(['data' => $data]);
    }

    public function pesanan_detail($id)
    {
        $data = Transaksi::with(['user', 'keranjang'])->where('status', '=', 'menunggu')
            ->where('id', '=', $id)
            ->firstOrFail();

        if($this->request->method() === 'POST') {
            $data->update([
                'status' => $this->postField('status'),
                'deskripsi' => $this->postField('deskripsi')
            ]);
            return redirect('/pesanan');
        }
        return view('admin.transaksi.pesanan.detail')->with(['data' => $data]);
    }

    public function pengambilan()
    {
        $data = Transaksi::with(['user', 'keranjang'])->where('status', '=', 'lunas')->get();
        return view('admin.transaksi.pengambilan.index')->with(['data' => $data]);
    }

    public function pengambilan_detail($id)
    {
        $data = Transaksi::with(['user', 'keranjang'])->where('status', '=', 'lunas')
            ->where('id', '=', $id)
            ->firstOrFail();

        if($this->request->method() === 'POST') {
            $data->update([
                'status' => 'proses',
            ]);
            return redirect('/pengambilan');
        }
        return view('admin.transaksi.pengambilan.detail')->with(['data' => $data]);
    }

    public function pengembalian()
    {
        $data = Transaksi::with(['user', 'keranjang'])->where('status', '=', 'proses')->get();
        return view('admin.transaksi.pengembalian.index')->with(['data' => $data]);
    }

    public function pengembalian_detail($id)
    {
        $data = Transaksi::with(['user', 'keranjang'])->where('status', '=', 'proses')
            ->where('id', '=', $id)
            ->firstOrFail();

        if($this->request->method() === 'POST') {
            $data->update([
                'status' => 'selesai',
                'tanggal_dikembalikan' => $this->postField('kembali'),
                'denda' => $this->postField('denda')
            ]);
            return redirect('/pengembalian');
        }
        return view('admin.transaksi.pengembalian.detail')->with(['data' => $data]);
    }

    public function pesanan_selesai()
    {
        $data = Transaksi::with(['user', 'keranjang'])->where('status', '=', 'selesai')->get();
        return view('admin.transaksi.selesai.index')->with(['data' => $data]);
    }

    public function pesanan_selesai_detail($id)
    {
        $data = Transaksi::with(['user', 'keranjang'])->where('status', '=', 'selesai')
            ->where('id', '=', $id)
            ->firstOrFail();
        return view('admin.transaksi.selesai.detail')->with(['data' => $data]);
    }

    public function pesanan_selesai_cetak($id)
    {
        $data = Transaksi::with(['user', 'keranjang'])->where('status', '=', 'selesai')
            ->where('id', '=', $id)
            ->firstOrFail();
        $html = view('admin.cetak.nota-selesai')->with(['data' => $data]);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html)->setPaper('a5', 'landscape');
        return $pdf->stream();
    }
}
