<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'barang_id',
        'transaksi_id',
        'qty',
        'harga',
        'total'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    public function transaksi_sukses()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id')
            ->where('status', '!=', 'menunggu')
            ->where('status', '!=', 'pesan')
            ->where('status', '!=', 'tolak');
    }
}
