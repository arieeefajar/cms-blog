<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class DashboardController extends Controller
{
    public function admin()
    {
        return view('dashboard.admin');
    }
}
