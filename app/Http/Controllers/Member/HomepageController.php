<?php


namespace App\Http\Controllers\Member;


use App\Helper\CustomController;
use App\Models\Barang;
use App\Models\Category;

class HomepageController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $category = Category::all();
        $data = Barang::with('category')->get();
        return view('member.index')->with([
            'categories' => $category,
            'data' => $data
        ]);
    }

    public function product_page($id)
    {
        $data = Barang::findOrFail($id);
        return view('member.product')->with(['data' => $data]);
    }

    public function category_page($id)
    {
        $category = Category::all();
        $current_category = Category::find($id);
        $data = Barang::with('category')->where('category_id', '=', $id)->get();
        return view('member.category')->with([
            'categories' => $category,
            'data' => $data,
            'current_category' => $current_category
        ]);
    }

    public function about_page() {
        return view('member.about');
    }

    public function contact_page() {
        return view('member.contact');
    }
    public function get_product_by_name_and_category($id)
    {
        try {
            $name = $this->field('name');
            $data = Barang::with('category')
                ->where('category_id', '=', $id)
                ->where('nama', 'LIKE', '%' . $name . '%')
                ->get();
            return $this->jsonResponse('success', 200, $data);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }
}
