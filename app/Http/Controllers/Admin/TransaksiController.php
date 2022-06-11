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
}
