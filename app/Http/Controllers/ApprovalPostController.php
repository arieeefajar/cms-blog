<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class ApprovalPostController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 'pending')->orderBy('created_at', 'desc')->get();
        return view('admin.approvalPost', compact('posts'));
    }

    public function approve($id)
    {
        $post = Post::find($id);
        $post->status_published = 'active';
        $post->status = 'published';

        try {
            $post->save();
            alert()->success('Berhasil', 'Menyetujui Postingan');
            return redirect()->back();
        } catch (\Throwable $th) {
            alert()->error('Gagal', 'Menyetujui Postingan');
            return redirect()->back();
        }
    }

    public function reject($id)
    {
        $post = Post::find($id);
        $post->status = 'rejected';

        try {
            $post->save();
            alert()->success('Berhasil', 'Menolak Postingan');
            return redirect()->back();
        } catch (\Throwable $th) {
            alert()->error('Gagal', 'Menolak Postingan');
            return redirect()->back();
        }
    }
}
