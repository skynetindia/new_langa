<?php
namespace App\Repositories;

use App\User;
use DB;
use App\Corporation;

class CorporationRepository
{
	public function forUser(User $user)
    {		
        if($user->id == 0 || $user->dipartimento == 0) {
			/*$data = Corporation::where('is_deleted', 0)->orderBy('id', 'asc')->get();*/			
			$data = DB::table('corporations')
				->join('users', 'corporations.user_id', '=', 'users.id')
				->select('corporations.*')
				->where('is_deleted','0')
				->where('users.is_delete', '=', 0)
				->where('corporations.is_approvato', 1)
				->orderBy('corporations.id', 'asc')
				->get();

			foreach($data as $data) {				
				if($data->statoemotivo != ""){
					$statiemotivitipi = DB::table('statiemotivitipi')->where('id',$data->statoemotivo)->orderBy('id', 'asc')->first();
					if(isset($statiemotivitipi->language_key)){
						$data->statoemotivo = (!empty($statiemotivitipi->language_key)) ? trans('messages.'.$statiemotivitipi->language_key) : $statiemotivitipi->name;
					}
					if(isset($statiemotivitipi->color)){
						$data->statoemotivo = '<span style="color:'.$statiemotivitipi->color.'">'.ucwords(strtolower($data->statoemotivo)).'</span>';
					}
				}
				$data->nomeazienda = ucwords(strtolower($data->nomeazienda));
				$data->nomereferente = ucwords(strtolower($data->nomereferente));
				$data->settore = ucwords(strtolower($data->settore));
				$data->responsabilelanga = ucwords(strtolower($data->responsabilelanga));				
				$ente_return[] = $data;	
			}	
			return $ente_return;
		} 
		else {			
			$partecipanti = DB::table('enti_partecipanti')
				->select('id_ente')
				->where('id_user', $user->id)
				->orderBy('id', 'asc')
				->get();
			$ente_return = [];
			$enti = Corporation::where('privato', 0)
					->select('corporations.*')
					->whereIn('id', json_decode(json_encode($partecipanti), true))
					->orWhere('user_id', $user->id)
					->orWhere('responsabilelanga', $user->name)
					->orderBy('id', 'asc')
					->get();
			
			foreach($enti as $ente) {				
				if($ente->is_deleted == 0){
					if($ente->statoemotivo != ""){
						$statiemotivitipi = DB::table('statiemotivitipi')->where('id',$ente->statoemotivo)->orderBy('id', 'asc')->first();
						if(isset($statiemotivitipi->language_key)){
							$ente->statoemotivo = (!empty($statiemotivitipi->language_key)) ? trans('messages.'.$statiemotivitipi->language_key) : $statiemotivitipi->name;							
						}
						if(isset($statiemotivitipi->color)){
							$ente->statoemotivo = '<span style="color:'.$statiemotivitipi->color.'">'.ucwords(strtolower($ente->statoemotivo)).'</span>';
						}
					}

					$ente->nomeazienda = ucwords(strtolower($ente->nomeazienda));
					$ente->nomereferente = ucwords(strtolower($ente->nomereferente));
					$ente->settore = ucwords(strtolower($ente->settore));
					$ente->responsabilelanga = ucwords(strtolower($ente->responsabilelanga));

					$ente_return[] = $ente;
				}
			}			
			
			return $ente_return;
		}
    }
	
	// Tutti gli enti
    public function forUser2(User $user)
    {      
		if($user->id == 0 || $user->dipartimento == 0){
           $data = DB::table('corporations')
			   	->join('users', 'corporations.user_id', '=', 'users.id')
				->select('corporations.*')
				->where('is_deleted','0')
				->where('users.is_delete', '=', 0)
				->where('corporations.is_approvato', 1)
				->orderBy('corporations.id', 'desc')
				->get();
			foreach($data as $data) {				
				if($data->statoemotivo != ""){
					$statiemotivitipi = DB::table('statiemotivitipi')->where('id',$data->statoemotivo)->orderBy('id', 'asc')->first();
					if(isset($statiemotivitipi->language_key)){
						$data->statoemotivo = (!empty($statiemotivitipi->language_key)) ? trans('messages.'.$statiemotivitipi->language_key) : $statiemotivitipi->name;
					}
					if(isset($statiemotivitipi->color)){
						$data->statoemotivo = '<span style="color:'.$statiemotivitipi->color.'">'.$data->statoemotivo.'</span>';
					}
				}
				$ente_return[] = $data;	
			}	
			return $ente_return;
		    /*return Corporation::where('is_deleted', 0)
        		->where('is_approvato', 1)
				->orderBy('id', 'asc')
                ->get();*/
		}
		else {
			 $enti = Corporation::join('users', 'corporations.user_id', '=', 'users.id')
				->select('corporations.*')
				->where('privato', 0)
        		->where('users.is_delete', '=', 0)
        		->orderBy('corporations.id', 'asc')->get();
			foreach($enti as $ente) {
				if($ente->is_deleted == 0){
					if($ente->statoemotivo != ""){
						$statiemotivitipi = DB::table('statiemotivitipi')->where('id',$ente->statoemotivo)->orderBy('id', 'asc')->get();
						if(isset($statiemotivitipi->language_key)){
							$ente->statoemotivo = (!empty($statiemotivitipi->language_key)) ? trans('messages.'.$statiemotivitipi->language_key) : $statiemotivitipi->name;
						}
						if(isset($statiemotivitipi->color)){
							$ente->statoemotivo = '<span style="color:'.$statiemotivitipi->color.'">'.$ente->statoemotivo.'</span>';
						}
					}
					$ente_return[] = $ente;
				}
			}
			return $ente_return;
		}
    }
}