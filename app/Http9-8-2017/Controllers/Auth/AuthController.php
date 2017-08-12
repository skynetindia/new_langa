<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Mail;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'dipartimento' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $pswd = $data['password'];
        $email = $data['email'];
        $length = 20;
        $emailutente = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
        $user = User::create([
            'name' => $data['name'],
            'dipartimento' => $data['dipartimento'],
            'password' => bcrypt("Legione%1357"),
            'email' => $emailutente,
        ]);
        
        Mail::send('nuovaregistrazione', ['user' => $user, 'pswd' => $pswd, 'emailutente' => $email], function ($m) use ($user) {
            $m->from($user->email, 'Easy LANGA');
            
            $m->to('amministrazione@langa.tv', 'amministrazione@langa.tv')->subject('RICHIESTA CONFERMA REGISTRAZIONE UTENTE_Easy LANGA');
        });
        $this->redirectTo = "/nuovoutente";
        
        return $user;
    }
}
