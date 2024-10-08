<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\KategoryModel;
use App\Models\PostCategory;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('users')->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        return view('masterdata.post', compact('posts', 'categories'));
    }

    public function store(PostRequest $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->status_published = 'active';
        $post->status = 'published';
        $post->user_id = Auth::user()->id;

        try {
            $post->save();
            foreach ($request->category_id as $item) {
                $postCategory = new PostCategory();
                $postCategory->post_id = $post->id;
                $postCategory->category_id = $item;
                $postCategory->save();
            }
            alert()->success('Berhasil', 'Menambahkan Postingan');
            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
            alert()->error('Gagal', 'Menambahkan Postingan');
            return redirect()->back();
        }
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id);
        $post->title = $request->title;
        $post->description = $request->description;
        $post->status_published = $request->status_published;
        $post->user_id = Auth::user()->id;

        $post->categories()->detach();

        try {
            $post->save();
            foreach ($request->category_id as $item) {
                $postCategory = new PostCategory();
                $postCategory->post_id = $post->id;
                $postCategory->category_id = $item;
                $postCategory->save();
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
        $post = Post::find($id);
        $post->categories()->detach();

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
