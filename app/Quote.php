<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Quote extends Model
{
    protected $fillable = [
        'anno',
        'idutente',
        'idente',
        'data',
        'oggetto',
        'dipartimento',
        'noteintestazione',
        'metodo',
        'considerazioni',
        'noteimportanti',
		'filetecnico',
		'notetecniche',
        'valenza',
        'finelavori',
        'subtotale',
        'scontoagente',
        'scontobonus',
        'totale',
        'totaledapagare',
		'lineebianche',
		'is_deleted',
		'file'
    ];
    
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
