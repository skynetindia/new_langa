<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'dipartimento', 'email', 'password',
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
