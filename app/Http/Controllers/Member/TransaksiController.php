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
}
