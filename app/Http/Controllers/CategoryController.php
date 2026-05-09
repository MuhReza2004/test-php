<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MasterItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;

        $data_search = Category::query();

        if (!empty($kode)) $data_search = $data_search->where('kode', $kode);
        if (!empty($nama)) $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');

        $data_search = $data_search->orderBy('id')->get();

        return response()->json([
            'status' => 200,
            'data' => $data_search
        ]);
    }

    public function formView($method, $id = 0)
    {
        $data['item'] = ($method == 'new') ? new Category : Category::find($id);
        $data['method'] = $method;
        return view('categories.form.index', $data);
    }

    public function singleView($id)
    {
        $data['category'] = Category::with('masterItems')->find($id);
        if (!$data['category']) {
            return redirect('categories')->with('error', 'Kategori tidak ditemukan');
        }
        return view('categories.single.index', $data);
    }

    public function printPDF($id)
    {
        $category = Category::with('masterItems')->find($id);
        if (!$category) {
            return redirect('categories')->with('error', 'Kategori tidak ditemukan');
        }

        $pdf = Pdf::loadView('categories.single.pdf', compact('category'));
        return $pdf->download('Kategori-' . $category->kode . '.pdf');
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        $request->validate([
            'kode' => 'required|unique:categories,kode,' . $id,
            'nama' => 'required',
        ]);

        $category = ($method == 'new') ? new Category : Category::find($id);
        $category->nama = $request->nama;
        $category->kode = $request->kode;
        $category->save();

        return redirect('categories');
    }

    public function delete($id)
    {
        Category::findOrFail($id)->delete();
        return redirect('categories');
    }
}
