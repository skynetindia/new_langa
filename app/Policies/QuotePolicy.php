<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\Quote;
use DB;

class QuotePolicy
{
    use HandlesAuthorization;
	
	public function autorizza(User $user, Quote $quote)
	{
		if ($user->id == 0) {
           	return true;
        }
        
		$partecipanti = DB::table('enti_partecipanti')
			->where([
				'id_ente' => $quote->idente,
				'id_user' => $user->id
			])->first();
		$partecipante = ($partecipanti != null) ? true : false;
		
		return $quote->user_id == $user->id || $quote->idutente == $user->id || $partecipante;
	}
	
    public function duplicate(User $user, Quote $quote)
    {
        return $this->autorizza($user, $quote);
    }
	
    public function modify(User $user, Quote $quote)
    {
        return $this->autorizza($user, $quote);
    }
	
    public function destroy(User $user, Quote $quote)
    {
        return $this->autorizza($user, $quote);
    }
    public function visualizzapdf(User $user, Quote $quote) {
    	return $this->autorizza($user, $quote);
    }
}