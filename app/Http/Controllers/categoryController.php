<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
    {
        $customMessage = [
            'required' => ':attribute harus diisi',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], $customMessage);

        if ($validator->fails()) {
            alert()->error('Gagal', $validator->messages()->all()[0]);
            return redirect()->back()->withInput();
        }

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

    public function update(Request $request, $id)
    {
        $customMessage = [
            'required' => ':attribute harus diisi',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], $customMessage);

        if ($validator->fails()) {
            alert()->error('Gagal', $validator->messages()->all()[0]);
            return redirect()->back()->withInput();
        }

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
