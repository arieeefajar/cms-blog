<?php

namespace App\Http\Controllers;

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
