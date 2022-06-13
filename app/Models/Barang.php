<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'nama',
        'harga',
        'deskripsi',
        'gambar'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'barang_id');
    }

    public function keranjang_sukses()
    {
        return $this->hasMany(Keranjang::class, 'barang_id')
            ->join('transaksis', function ($join) {
                $join->on([
                    ['keranjangs.transaksi_id', '=', 'transaksis.id'],
                ])->where('transaksis.status', '!=', 'menunggu')
                    ->where('transaksis.status', '!=', 'pesan')
                    ->where('transaksis.status', '!=', 'tolak');
            });
    }

    public function getTersewaAttribute()
    {
        $data = $this->keranjang_sukses()->get();
        $count = 0;
        foreach ($data as $v){
            $count += $v->qty;
        }
        return $count;
    }
}
