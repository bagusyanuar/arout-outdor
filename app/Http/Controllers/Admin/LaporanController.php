<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Barang;
use App\Models\Transaksi;

class LaporanController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function laporan_penyewaan()
    {
        return view('admin.laporan.penyewaan.index');
    }

    public function laporan_penyewaan_data()
    {
        try {
            $tgl1 = $this->field('tgl1');
            $tgl2 = $this->field('tgl2');
            $data = Transaksi::with(['user', 'keranjang'])
                ->whereBetween('tanggal', [$tgl1, $tgl2])
                ->where('status', '!=', 'pesan')
                ->where('status', '!=', 'menunggu')
                ->where('status', '!=', 'tolak')
                ->get();
            return $this->basicDataTables($data);
        }catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function laporan_penyewaan_cetak()
    {
            $tgl1 = $this->field('tgl1');
            $tgl2 = $this->field('tgl2');
            $data = Transaksi::with(['user', 'keranjang'])
                ->whereBetween('tanggal', [$tgl1, $tgl2])
                ->where('status', '!=', 'pesan')
                ->where('status', '!=', 'menunggu')
                ->where('status', '!=', 'tolak')
                ->get();
            return $this->convertToPdf('admin.laporan.penyewaan.cetak', [
                'tgl1' => $tgl1,
                'tgl2' => $tgl2,
                'data' => $data
            ]);
    }

    public function laporan_barang_terlaris()
    {
        return view('admin.laporan.terlaris.index');
    }

    public function laporan_barang_terlaris_data()
    {
        try {
            $data = Barang::with('category')->orderBy('id', 'DESC')->get()->append('tersewa');
            $data_sort = $data->sortBy([['tersewa', 'desc']]);
            return $this->basicDataTables($data_sort);
        }catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function laporan_barang_terlaris_cetak()
    {
        $data = Barang::with('category')->orderBy('id', 'DESC')->get()->append('tersewa');
        $data_sort = $data->sortBy([['tersewa', 'desc']]);
        return $this->convertToPdf('admin.laporan.terlaris.cetak', [
            'data' => $data_sort
        ]);
    }

    public function laporan_stock()
    {
        return view('admin.laporan.stock.index');
    }

    public function laporan_stock_data()
    {
        try {
            $data = Barang::with('category')->orderBy('qty', 'DESC')->get();
            return $this->basicDataTables($data);
        }catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function laporan_stock_cetak()
    {
        $data = Barang::with('category')->orderBy('qty', 'DESC')->get();
        return $this->convertToPdf('admin.laporan.stock.cetak', [
            'data' => $data
        ]);
    }
}
