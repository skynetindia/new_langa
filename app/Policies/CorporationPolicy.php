<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use DB;
use App\Corporation;

class CorporationPolicy
{
    use HandlesAuthorization;
	
	public function autorizza(User $user, Corporation $corporation)
	{
		
		if($user->id == 0)
        	return true;
		else {
			$partecipanti = DB::table('enti_partecipanti')
				->where([
					'id_ente' => $corporation->id,
					'id_user' => $user->id
				])->first();
			$partecipante = ($partecipanti != null) ? true : false;
			return $corporation->user_id == $user->id || $corporation->responsabilelanga == $user->name || $partecipante;
		}
	}
	
	public function duplicate(User $user, Corporation $corporation)
	{
        return $this->autorizza($user, $corporation);
	}
	
    public function modify(User $user, Corporation $corporation)
	{
        return $this->autorizza($user, $corporation);
	}
	
    public function destroy(User $user, Corporation $corporation)
	{
        return $this->autorizza($user, $corporation);
	}
}
