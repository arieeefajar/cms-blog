<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        return view('masterdata.category', compact('categories'));
    }

    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;

        try {
            $category->save();
            alert()->success('Berhasil', 'Menambahkan Kategori');
            return redirect()->back();
        } catch (\Throwable $th) {
            alert()->error('Gagal', 'Menambahkan Kategori');
            return redirect()->back()->withInput();
        }
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find($id);
        $category->name = $request->name;

        try {
            $category->save();
            alert()->success('Berhasil', 'Mengubah Kategori');
            return redirect()->back();
        } catch (\Throwable $th) {
            alert()->error('Gagal', 'Mengubah Kategori');
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        try {
            $category->delete();
            alert()->success('Berhasil', 'Menghapus Kategori');
            return redirect()->back();
        } catch (\Throwable $th) {
            alert()->error('Gagal', 'Menghapus Kategori');
            return redirect()->back();
        }
    }
}
