<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $authors = User::where('role', 'author')->orderBy('created_at', 'desc')->get();
        return view('masterdata.users', compact('authors'));
    }

    public function store(AuthorRequest $request)
    {
        $email = User::where('email', $request->email)->first();
        if ($email) {
            alert()->error('Gagal', 'Email sudah terdaftar, silahkan gunakan email lain');
            return redirect()->back()->withInput();
        }

        if ($request->password == $request->repeatpassword) {
            $user = new User();
            $user->fullname = $request->fullname;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->status = 'active';

            try {
                $user->save();
                alert()->success('Berhasil', 'Menambahkan Akun Baru');
                return redirect()->back();
            } catch (\Throwable $th) {
                alert()->error('Gagal', 'Menambahkan Akun Baru');
                return redirect()->back()->withInput();
            }
        } else {
            alert()->error('Gagal', 'Repeat Password tidak sama');
            return redirect()->back()->withInput();
        }
    }

    public function update(UpdateAuthorRequest $request, $id)
    {
        $user = User::find($id);
        $email = User::where('email', $request->email)->first();

        if ($email) {
            if ($email->id != $user->id) {
                alert()->error('Gagal', 'Email sudah terdaftar, silahkan gunakan email lain');
                return redirect()->back()->withInput();
            }
        }

        $user->fullname = $request->fullname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->status = $request->status;

        try {
            $user->save();
            alert()->success('Berhasil', 'Mengubah Data Akun');
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
            alert()->error('Gagal', 'Mengubah Data Akun');
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);

        try {
            $user->delete();
            alert()->success('Berhasil', 'Menghapus Akun');
            return redirect()->back();
        } catch (\Throwable $th) {
            alert()->error('Gagal', 'Menghapus Akun');
            return redirect()->back();
        }
    }
}
