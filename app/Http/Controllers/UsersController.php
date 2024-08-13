<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function index()
    {
        $author = User::where('role', 'author')->orderBy('created_at', 'desc')->get();
        return view('masterdata.users.index', compact('author'));
    }

    public function store(Request $request)
    {
        $customMessage = [
            'fullname.required' => 'Fullname harus diisi',
            'fullname.string' => 'Fullname harus berupa string',
            'fullname.max' => 'Fullname maksimal 50 karakter',

            'username.required' => 'Username harus diisi',
            'username.string' => 'Username harus berupa string',
            'username.max' => 'Username maksimal 6 karakter',

            'password.required' => 'Password harus diisi',
            'password.string' => 'Password harus berupa string',
            'password.max' => 'Password maksimal 10 karakter',

            'email.required' => 'Email harus diisi',
            'email.email' => 'Email harus valid',
        ];

        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:50',
            'username' => 'required|string|max:6',
            'password' => 'required|string|max:10',
            'email' => 'required|email',
        ], $customMessage);

        if ($validator->fails()) {
            alert()->error('Gagal', $validator->messages()->all()[0]);
            return redirect()->back()->withInput();
        }

        $email = User::where('email', $request->email)->first();
        if ($email) {
            alert()->error('Gagal', 'Email sudah terdaftar, silahkan gunakan email lain');
            return redirect()->back()->withInput();
        }

        if ($request->password == $request->repeatpassword) {
            $users = new User();
            $users->fullname = $request->fullname;
            $users->username = $request->username;
            $users->email = $request->email;
            $users->password = Hash::make($request->password);
            $users->status = 'active';

            try {
                $users->save();
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

    public function update(Request $request, $id)
    {
        $customMessage = [
            'fullname.required' => 'Fullname harus diisi',
            'fullname.string' => 'Fullname harus berupa string',
            'fullname.max' => 'Fullname maksimal 50 karakter',

            'username.required' => 'Username harus diisi',
            'username.string' => 'Username harus berupa string',
            'username.max' => 'Username maksimal 6 karakter',

            'email.required' => 'Email harus diisi',
            'email.email' => 'Email harus valid',

            'status.required' => 'Status harus diisi',
            'status.in.active' => 'Status harus active',
            'status.in.inactive' => 'Status harus inactive',
        ];

        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:50',
            'username' => 'required|string|max:6',
            'email' => 'required|email',
            'status' => 'required|in:active,inactive',
        ], $customMessage);

        if ($validator->fails()) {
            alert()->error('Gagal', $validator->messages()->all()[0]);
            return redirect()->back()->withInput();
        }

        $users = User::find($id);
        $email = User::where('email', $request->email)->first();

        if ($email) {
            if ($email->id != $users->id) {
                alert()->error('Gagal', 'Email sudah terdaftar, silahkan gunakan email lain');
                return redirect()->back()->withInput();
            }
        }

        $users->fullname = $request->fullname;
        $users->username = $request->username;
        $users->email = $request->email;
        $users->status = $request->status;

        try {
            $users->save();
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
        $users = User::find($id);

        try {
            $users->delete();
            alert()->success('Berhasil', 'Menghapus Akun');
            return redirect()->back();
        } catch (\Throwable $th) {
            alert()->error('Gagal', 'Menghapus Akun');
            return redirect()->back();
        }
    }
}
