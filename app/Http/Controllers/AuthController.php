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

        if ($users) {
            if ($users->status == 'active') {
                if ($users && Hash::check($request->password, $users->password)) {
                    Auth::login($users);
                    if ($users->role == 'admin') {
                        toast('Login Berhasil', 'success')->position('top')->autoClose(3000);
                        return redirect()->route('dashboard');
                    } elseif ($users->role == 'author') {
                        toast('Login Berhasil', 'success')->position('top')->autoClose(3000);
                        return redirect()->route('dashboard.author');
                    }
                } else {
                    toast('Username atau Password salah', 'error')->position('top')->autoClose(3000);
                    return redirect()->back()->withInput();
                }
            } else {
                toast('Akun anda tidak aktif', 'error')->position('top')->autoClose(3000);
                return redirect()->back()->withInput();
            }
        } else {
            toast('Username atau Password salah', 'error')->position('top')->autoClose(3000);
            return redirect()->back()->withInput();
        }
    }

    public function register()
    {
        return view('auth/register');
    }

    public function prosesRegister(Request $request)
    {
        // return $request->all();
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
                alert()->success('Berhasil', 'Register Akun, Silahkan Login Untuk Melanjutkan');
                return redirect()->route('login');
            } catch (\Throwable $th) {
                alert()->error('Gagal', 'Register Akun');
                return redirect()->back()->withInput();
            }
        } else {
            alert()->error('Gagal', 'Repeat Password tidak sama');
            return redirect()->back()->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        toast('Logout Berhasil', 'success')->position('top')->autoClose(3000);
        return redirect()->route('login');
    }

    public function profile()
    {
        return view('auth.profile');
    }

    public function updateProfile(Request $request)
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
        ];

        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:50',
            'username' => 'required|string|max:6',
            'email' => 'required|email',
        ], $customMessage);

        if ($validator->fails()) {
            alert()->error('Gagal', $validator->messages()->all()[0]);
            return redirect()->back()->withInput();
        }

        $users = User::where('id', Auth::user()->id)->first();

        if ($request->oldpassword) {
            if (Hash::check($request->oldpassword, $users->password)) {

                $customMessagePassword = [
                    'password.required' => 'Password Baru harus diisi',
                    'password.string' => 'Password Baru harus berupa string',
                    'password.max' => 'Password Baru maksimal 10 karakter',

                    'repeatpassword.required' => 'Repeat Password harus diisi',
                    'repeatpassword.string' => 'Repeat Password harus berupa string',
                    'repeatpassword.max' => 'Repeat Password maksimal 10 karakter',
                ];

                $validatorPassword = Validator::make($request->all(), [
                    'password' => 'required|string|max:10',
                    'repeatpassword' => 'required|string|max:10',
                ], $customMessagePassword);

                if ($validatorPassword->fails()) {
                    alert()->error('Gagal', $validatorPassword->messages()->all()[0]);
                    return redirect()->back()->withInput();
                }

                if ($request->password == $request->repeatpassword) {
                    $users->fullname = $request->fullname;
                    $users->username = $request->username;
                    $users->email = $request->email;
                    $users->password = Hash::make($request->password);

                    try {
                        $users->save();
                        alert()->success('Berhasil', 'Update Profile');
                        return redirect()->back();
                    } catch (\Throwable $th) {
                        alert()->error('Gagal', 'Update Profile');
                        return redirect()->back()->withInput();
                    }
                } else {
                    alert()->error('Gagal', 'Repeat Password tidak sama');
                    return redirect()->back()->withInput();
                }
            } else {
                alert()->error('Gagal', 'Password lama tidak sesuai');
                return redirect()->back()->withInput();
            }
        } else {
            $users->fullname = $request->fullname;
            $users->username = $request->username;
            $users->email = $request->email;

            try {
                $users->save();
                alert()->success('Berhasil', 'Update Profile');
                return redirect()->back();
            } catch (\Throwable $th) {
                alert()->error('Gagal', 'Update Profile');
                return redirect()->back()->withInput();
            }
        }
    }
}
