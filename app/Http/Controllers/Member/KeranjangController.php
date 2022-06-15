<?php


namespace App\Http\Controllers\Member;


use App\Helper\CustomController;
use App\Models\Barang;
use App\Models\Keranjang;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KeranjangController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Keranjang::with(['user', 'barang'])->where('user_id', '=', Auth::id())
            ->whereNull('transaksi_id')
            ->get();
        return view('member.cart')->with(['data' => $data]);
    }

    public function add_to_cart()
    {
        try {
            if (!Auth::check()) {
                return $this->jsonResponse('Unauthenticated', 202);
            }
            $barang = Barang::find($this->postField('barang'));
            $qty = $this->postField('qty');
            $harga = $barang->harga;
            $total = $qty * $harga;

            $data = [
                'user_id' => Auth::id(),
                'transaksi_id' => null,
                'barang_id' => $barang->id,
                'qty' => $qty,
                'harga' => $harga,
                'total' => $total
            ];

            Keranjang::create($data);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }

    public function delete_cart()
    {
        try {

            $id = $this->postField('id');
            Keranjang::destroy($id);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }
    public function count_cart()
    {
        try {
            $data = Keranjang::with('user')->where('user_id', '=', Auth::id())->whereNull('transaksi_id')->get();
            return $this->jsonResponse('success', 200, count($data));
        } catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }

    public function checkout()
    {
        try {
            DB::beginTransaction();
            $lama = $this->postField('lama');
            $tanggal = $this->postField('tanggal');
            $current_datae = new \DateTime($tanggal);
            $tanggal_kembali = $current_datae->modify('+' . $lama . ' day');
//            $tanggal_kembali = date('Y-m-d', strtotime('+' . $lama . ' day'));
            $no_transaksi = 'TR-' . \date('YmdHis');

            $keranjang = Keranjang::with(['user', 'barang'])->where('user_id', '=', Auth::id())
                ->whereNull('transaksi_id')
                ->get();

            $cart_total = $keranjang->sum('total');
            $sub_total = $cart_total * $lama;
            $data = [
                'user_id' => Auth::id(),
                'tanggal' => $tanggal,
                'tanggal_kembali' => $tanggal_kembali,
                'no_transaksi' => $no_transaksi,
                'sub_total' => $sub_total,
                'diskon' => 0,
                'total' => $sub_total - 0,
                'status' => 'pesan',
                'bukti' => null,
                'bank' => null
            ];

            $transaksi = Transaksi::create($data);
            foreach ($keranjang as $v) {
                $v->transaksi_id = $transaksi->id;
                $v->update();
            }
            DB::commit();
            return $this->jsonResponse('success', 200, $transaksi->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }
}
