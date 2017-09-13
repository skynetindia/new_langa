<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\MyResetPassword;

class User extends Authenticatable
{
	use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'dipartimento','username', 'email', 'password','social_id','social_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
	
    public function corporations()
    {
	return $this->hasMany(Corporation::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    
    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }
	public function sendPasswordResetNotification($token)
	{
		$this->notify(new MyResetPassword($token));
	}
}
