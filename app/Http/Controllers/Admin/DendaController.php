<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Denda;

class DendaController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Denda::firstOrFail();
        if($this->request->method() === 'POST') {
            try {
                $data->update([
                    'nominal' => $this->postField('nominal')
                ]);
                return redirect()->back()->with(['success' => 'Berhasil Merubah Data...']);
            } catch (\Exception $e) {
                return redirect()->back()->with(['failed' => 'Terjadi Kesalahan ' . $e->getMessage()]);
            }
        }
        return view('admin.denda.index')->with(['data' => $data]);
    }
}
