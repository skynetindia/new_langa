<?php

namespace App\Http\Controllers;
use Socialite;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
//use App\SocialAccountService;
use Auth;


class SocialAuthController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();   
    }   

    public function callback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return redirect('redirect');
        }
        $authUser = $this->findOrCreateUser($user);
 		
        Auth::login($authUser, true);
 		
        return redirect()->to('home');
    }
	
    private function findOrCreateUser($facebookUser)
    {
        $authUser = User::where('social_id', $facebookUser->id)->first();
 		
        if ($authUser){
            return $authUser;
        }
 
        return User::create([
            'name' => $facebookUser->name,
            'email' => $facebookUser->email,
            'social_id' => $facebookUser->id,
            'logo' => $facebookUser->avatar
        ]);
    }
}

