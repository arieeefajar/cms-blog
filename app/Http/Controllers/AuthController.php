<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function Ramsey\Uuid\v1;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth/login');
    }

    public function prosesLogin(Request $request)
    {
        // return $request->all();
        $customMessage = [
            'required' => ':attribute harus diisi',
        ];

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ], $customMessage);

        if ($validator->fails()) {
            toast($validator->messages()->all()[0], 'warning')->position('top')->autoClose(3000);
            return redirect()->back()->withInput();
        }

        $users = User::where('username', $request->username)->first();
        if ($users && Hash::check($request->password, $users->password)) {
            Auth::login($users);
            if ($users->role == 'admin') {
                toast('Login Berhasil', 'success')->position('top')->autoClose(3000);
                return redirect()->route('dashboard');
            }
        }
    }

    public function register()
    {
        return view('auth/register');
    }

    public function logout()
    {
        Auth::logout();
        toast('Logout Berhasil', 'success')->position('top')->autoClose(3000);
        return redirect()->route('login');
    }
}
