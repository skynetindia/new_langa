<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Corporation extends Model
{
    protected $fillable = [
    	'appunti',
    	'ric',
    	'select',
    	'data',
		'nomeazienda',
		'nomereferente',
		'settore',
		'piva',
		'cf',
		'tipi[]',
		'sedelegale',
		'indirizzospedizione',
		'privato',
		'telefonoazienda',
		'cellulareazienda',
		'fax',
		'email',
        'emailsecondaria',
		'indirizzo',
		'logo',
		'noteenti',
		'iban',
		'statoemotivo',
		'responsabilelanga',
		'telefonolanga',
	];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
