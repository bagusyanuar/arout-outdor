<?php


namespace App\Http\Controllers\Member;


use App\Helper\CustomController;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Transaksi::with(['user', 'keranjang'])->where('user_id', '=', Auth::id())
            ->get();
        return view('member.transaksi')->with(['data' => $data]);
    }

    public function detail($id) {
        $transaksi = Transaksi::with(['user', 'keranjang'])->findOrFail($id);
        return view('member.transaksi-list')->with(['data' => $transaksi]);
    }

    public function pembayaran($id)
    {
        $transaksi = Transaksi::with(['user', 'keranjang'])->findOrFail($id);
        if ($this->request->method() === 'POST') {

            $nama_gambar = $this->generateImageName('bukti');

            if ($nama_gambar !== '') {
                $data['gambar'] = $nama_gambar;
                $this->uploadImage('bukti', $nama_gambar, 'bukti');
            }
            $transaksi->update([
                'bank' => $this->postField('bank'),
                'bukti' => $nama_gambar,
                'status' => 'menunggu'
            ]);
            return redirect('/transaksi');
        }
        return view('member.transaksi-detail')->with(['data' => $transaksi]);
    }

}
