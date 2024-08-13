<?php

namespace App\Http\Controllers;

use App\Models\KategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoryController extends Controller
{
    public function index()
    {
        $kategory = KategoryModel::orderBy('created_at', 'desc')->get();
        return view('masterdata.kategori', compact('kategory'));
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

        $kategory = new KategoryModel();
        $kategory->name = $request->name;

        try {
            $kategory->save();
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

        $kategory = KategoryModel::find($id);
        $kategory->name = $request->name;

        try {
            $kategory->save();
            alert()->success('Berhasil', 'Mengubah Kategori');
            return redirect()->back();
        } catch (\Throwable $th) {
            alert()->error('Gagal', 'Mengubah Kategori');
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        $kategory = KategoryModel::find($id);

        try {
            $kategory->delete();
            alert()->success('Berhasil', 'Menghapus Kategori');
            return redirect()->back();
        } catch (\Throwable $th) {
            alert()->error('Gagal', 'Menghapus Kategori');
            return redirect()->back();
        }
    }
}
