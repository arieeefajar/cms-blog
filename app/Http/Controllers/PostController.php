<?php

namespace App\Http\Controllers;

use App\Models\KategoryModel;
use App\Models\PostKategoryModel;
use App\Models\PostModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $post = PostModel::with('users')->where('status', 'published')->orderBy('created_at', 'desc')->get();
        $kategory = KategoryModel::all();
        return view('masterdata.post', compact('post', 'kategory'));
    }

    public function store(Request $request)
    {
        $customMessage = [
            'title.required' => 'Judul harus diisi',
            'title.max' => 'Judul maksimal 25 karakter',

            'description.required' => 'Deskripsi harus diisi',

            'kategory_id.required' => 'Harap pilih kategori',
        ];

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:25',
            'description' => 'required',
            'kategory_id' => 'required',
        ], $customMessage);

        if ($validator->fails()) {
            alert()->error('Gagal', $validator->messages()->all()[0]);
            return redirect()->back()->withInput();
        }

        $post = new PostModel();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->status_published = 'active';
        $post->status = 'published';
        $post->user_id = Auth::user()->id;

        try {
            $post->save();
            foreach ($request->kategory_id as $item) {
                $postKategory = new PostKategoryModel();
                $postKategory->post_id = $post->id;
                $postKategory->kategory_id = $item;
                $postKategory->save();
            }
            alert()->success('Berhasil', 'Menambahkan Postingan');
            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
            alert()->error('Gagal', 'Menambahkan Postingan');
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $customMessage = [
            'title.required' => 'Judul harus diisi',
            'title.max' => 'Judul maksimal 25 karakter',

            'description.required' => 'Deskripsi harus diisi',

            'kategory_id.required' => 'Harap pilih kategori',
        ];

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:25',
            'description' => 'required',
            'kategory_id' => 'required',
        ], $customMessage);

        if ($validator->fails()) {
            alert()->error('Gagal', $validator->messages()->all()[0]);
            return redirect()->back()->withInput();
        }

        $post = PostModel::find($id);
        $post->title = $request->title;
        $post->description = $request->description;
        $post->status_published = $request->status_published;
        $post->user_id = Auth::user()->id;

        $post->kategory()->detach();

        try {
            $post->save();
            foreach ($request->kategory_id as $item) {
                $postKategory = new PostKategoryModel();
                $postKategory->post_id = $post->id;
                $postKategory->kategory_id = $item;
                $postKategory->save();
            }
            alert()->success('Berhasil', 'Mengubah Postingan');
            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
            alert()->error('Gagal', 'Mengubah Postingan');
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        $post = PostModel::find($id);
        $post->kategory()->detach();

        try {
            $post->delete();
            alert()->success('Berhasil', 'Menghapus Postingan');
            return redirect()->back();
        } catch (\Throwable $th) {
            alert()->error('Gagal', 'Menghapus Postingan');
            return redirect()->back();
        }
    }
}
