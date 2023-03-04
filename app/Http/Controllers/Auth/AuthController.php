<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RegisterEmail;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use JeroenDesloovere\VCard\VCard;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $messages = [
            'required'              => ':attribute wajib diisi',
            'min'                   => ':attribute harus diisi minimal digit :min ',
            'max'                   => ':attribute harus diisi maksimal :max karakter',
            'email.required'        => 'Email wajib diisi',
            'password.required'     => 'Password wajib diisi',
            'g-recaptcha-response.required'  => 'Captcha wajib diisi'
        ];

        $this->validate($request, [
            'email'                 => 'required|email',
            'password'              => 'required|string',
            'g-recaptcha-response'  => 'required|captcha',
        ], $messages);

        $email          = $request->email;
        $password       = $request->password;

        $checkUser = User::where('email', $email)->first();

        if ($checkUser->token != null) {
            if (Auth::guard('web')->attempt([
                'email'     => $email,
                'password'  => $password,
                'status'    => true
            ])) {
                return redirect()->route('dashboard-user')->with('success', 'Berhasil Login');
            } else {
                return redirect()->back()->with('warning', 'Email dan Password Salah');
            }
        } else {
            return redirect()->back()->with('info', 'Akun belum melakukan verifikasi');
        }
    }

    public function register()
    {
        return view('auth.register');
    }

    public function postRegister(Request $request)
    {
        $messages = [
            'required'              => ':attribute wajib diisi',
            'min'                   => ':attribute harus diisi minimal digit :min ',
            'max'                   => ':attribute harus diisi maksimal :max karakter',
            'password.same'         => 'Password tidak sama',
            'passwordConfirm.same'  => 'Konfrimasi Password tidak sama',
            // 'answerCaptcha.in'      => 'Captcha Salah',
            'email.unique'          => 'Email Sudah Pernah Dipakai',
            'photo.mimes'           => 'Foto wajib JPG atau PNG',
            'photo.max'             => 'Foto maksimal 1 MB',
            'g-recaptcha-response.required'  => 'Captcha wajib diisi'
        ];

        $this->validate($request, [
            'email'             => 'required|min:5|unique:users,email',
            'nama'              => 'required|string|min:3',
            'password'          => 'required|string|min:6',
            'passwordConfirm'   => 'required|same:password|string|min:6',
            'photo'             => 'required|mimes:jpeg,png,jpg|max:1024',
            'g-recaptcha-response'  => 'required|captcha',
        ], $messages);

        $image = "data:image/png;base64," . base64_encode(file_get_contents($request->file('photo')));

        $data = array(
            'email'     => $request->email,
            'nama'      => ucfirst($request->nama),
            'password'  => Hash::make($request->password),
            'status'    => true,
            'token'     => null,
            'photo'     => $image
        );

        User::create($data);

        $details = [
            'title'     => 'Verifikasi Akun Ancol',
            'nama'      => ucfirst($request->nama),
            'token'     => Crypt::encryptString($request->email),
            'image'     => $image
        ];

        Mail::to($request->email)->send(new RegisterEmail($details));
        return redirect()->back()->with('success', 'Berhasil Melakukan Pendaftaran Silahkan Verifikasi Email')->with('loader', true);
    }

    public function verifyAccount($id)
    {
        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ1234567890');
        $token = substr($random, 0, 10);

        $tokenDecrypt = Crypt::decryptString($id);
        $checkUser = User::where('email', $tokenDecrypt)->count();


        if ($checkUser == 1) {
            $data = array(
                'token'     => $token,
            );
            User::where('email', $tokenDecrypt)->update($data);
            dd("VERIFIKASI EMAIL BERHASIL SILAHKAN LOGIN KEMBALI");
        } elseif ($checkUser == 0) {
            dd("TIDAK BERHASIL MELAKUKAN VERIFIKASI EMAIL");
            // return redirect()->back()->with('error', 'Akun Tidak Ada');
        }
    }

    public function logout()
    {
        session()->forget('codeTicket');
        session()->forget('dateTransaksi');
        session()->forget('quotaPeople');
        session()->forget('quotaVenicle');
        session()->forget('typeTicket');
        session()->forget('dateEndTransaksi');

        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }
        return redirect()->route('login')->with('toast_success', 'Berhasil Keluar');
    }

    public function generateDownload()
    {
        // define vcard
        $vcard = new VCard();

        // define variables
        $lastname = 'Desloovere';
        $firstname = 'Jeroen';
        $additional = '';
        $prefix = '';
        $suffix = '';

        // add personal data
        $vcard->addName($lastname, $firstname, $additional, $prefix, $suffix);

        // add work data
        $vcard->addCompany('Siesqo');
        $vcard->addJobtitle('Web Developer');
        $vcard->addRole('Data Protection Officer');
        $vcard->addEmail('info@jeroendesloovere.be');
        $vcard->addPhoneNumber(1234121212, 'PREF;WORK');
        $vcard->addPhoneNumber(123456789, 'WORK');
        $vcard->addAddress(null, null, 'street', 'worktown', null, 'workpostcode', 'Belgium');
        $vcard->addLabel('street, worktown, workpostcode Belgium');
        $vcard->addURL('http://www.jeroendesloovere.be');

        return $vcard->download();
    }
}
