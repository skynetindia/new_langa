<?php

namespace App\Http\Controllers\Auth;
use App\Traits\CaptchaTrait;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use DB;
use Mail;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers,CaptchaTrait;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {   
        $reg_user_id = Session::get('reg_user_id');
		   $data['captcha'] = $this->captchaCheck();

        if(isset($reg_user_id)){
            return Validator::make($data, [
                'email' => 'required|string|email|max:255|unique:users,email,'.$reg_user_id,
				'username' => 'required|string|max:255|unique:users,username,'.$reg_user_id,
                'password' => 'required|string|min:6',
				'g-recaptcha-response'  => 'required',
                'captcha'               => 'required|min:1'
            ]);
        } else {
            return Validator::make($data, [
                'email' => 'required|string|email|max:255|unique:users',
				'username' => 'required|string|max:255|unique:users',
                'password' => 'required|string|min:6',
				 'g-recaptcha-response' => 'required',
                'captcha'              => 'required|min:1'
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    { 
        $name = $data['firstname'] .' ' .$data['lastname'];
		
        $reg_user_id = Session::get('reg_user_id');

        if(isset($reg_user_id)){
            $user = DB::table('users')->where('id', $reg_user_id)->update([
                'name' => isset($name) ? $name : '',
                'email' => isset($data['email']) ? $data['email'] : '',
				 'username' => (isset($data['username'])) ? $data['username'] : '',
                'password' => bcrypt($data['password'])
            ]);
			$user=DB::table('users')->where('id', $reg_user_id)->first();
			
           return json_encode($user);
            
        } else {
            $user =  User::create([
            'name' => (isset($name)) ? $name : '',
            'email' => (isset($data['email']))? $data['email'] : '',
			 'username' => (isset($data['username'])) ? $data['username'] : '',
            'password' => bcrypt($data['password'])
            ]);

            // $email = $data['email'];
            // $pswd = bcrypt($data['password']);

            // Mail::send('layouts.nuovaregistrazione', ['user' => $user, 'pswd' => $pswd, 'emailutente' => $email], function ($m) use ($user, $email) {
            //     $m->from('easy@langa.tv', 'Easy LANGA');            
            //     $m->to($email)->subject('RICHIESTA CONFERMA REGISTRAZIONE UTENTE_Easy LANGA');
            // });

            Session::put('reg_user_id', $user->id);  
			  
            return json_encode($user);
        }
    }
}
