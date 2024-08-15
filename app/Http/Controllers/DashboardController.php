<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PostModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\FuncCall;

class DashboardController extends Controller
{
    public function admin()
    {
        $countPost = PostModel::where('status', 'publish')->count();
        $countAuthor = User::where('role', 'author')->count();
        $countKategory = Category::count();
        $countPostPending = PostModel::where('status', 'pending')->count();
        return view('dashboard.admin', compact('countPost', 'countAuthor', 'countKategory', 'countPostPending'));
    }

    public function author()
    {
        $countPost = PostModel::where('user_id', Auth::user()->id)->where('status', 'publish')->count();
        $countPostPending = PostModel::where('user_id', Auth::user()->id)->where('status', 'pending')->count();
        $countPostReject = PostModel::where('user_id', Auth::user()->id)->where('status', 'reject')->count();
        return view('dashboard.author', compact('countPost', 'countPostPending', 'countPostReject'));
    }
}
