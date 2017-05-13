<?php
namespace App\Repositories;

use App\User;
use DB;
use App\Corporation;

class CorporationRepository
{
	// I miei enti
	public function forUser(User $user)
    {

        if($user->id == 0) {

			return Corporation::where('is_deleted', 0)->orderBy('id', 'asc')->get();
		} else {
			$partecipanti = DB::table('enti_partecipanti')
				->select('id_ente')
				->where('id_user', $user->id)
				->orderBy('id', 'asc')
				->get();
				
			$enti = Corporation::where('privato', 0)
					->whereIn('id', json_decode(json_encode($partecipanti), true))
					->orWhere('user_id', $user->id)
					->orWhere('responsabilelanga', $user->name)
					->orderBy('id', 'asc')
					->get();
			
			foreach($enti as $ente) {
				if($ente->is_deleted == 0)
					$ente_return[] = $ente;	
			}
			
			return $ente_return;
		}
    }
	
	// Tutti gli enti
    public function forUser2(User $user)
    {
        if($user->id == 0)
            return Corporation::where('is_deleted', 0)
        		->where('is_approvato', 1)
				->orderBy('id', 'asc')
                ->get();
			
		$enti = Corporation::where('privato', 0)->orderBy('id', 'asc')->get();
		foreach($enti as $ente) {
			if($ente->is_deleted == 0)
				$ente_return[] = $ente;	
		}
		return $ente_return;
    }
}