<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'tanggal',
        'tanggal_kembali',
        'no_transaksi',
        'sub_total',
        'diskon',
        'total',
        'status',
        'bukti',
        'bank',
        'deskripsi',
        'tanggal_dikembalikan',
        'denda'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'transaksi_id');
    }
}
