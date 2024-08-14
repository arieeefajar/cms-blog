<?php

namespace App\Http\Controllers;

use App\Models\PostModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\FuncCall;

class DashboardController extends Controller
{
    public function admin()
    {
        return view('dashboard.admin');
    }

    public function author()
    {
        $countPost = PostModel::where('user_id', Auth::user()->id)->count();
        $countPostPending = PostModel::where('user_id', Auth::user()->id)->where('status', 'pending')->count();
        $countPostReject = PostModel::where('user_id', Auth::user()->id)->where('status', 'reject')->count();
        return view('dashboard.author', compact('countPost', 'countPostPending', 'countPostReject'));
    }
}
