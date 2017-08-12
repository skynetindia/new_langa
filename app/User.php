<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
	use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'dipartimento', 'email', 'password','social_id'
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
}
