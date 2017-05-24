<?php

namespace App\Repositories;

use App\User;
use DB;
use App\Project;

class ProjectRepository
{
	// tutti
    public function forUser(User $user) {
    // 	$data = DB::table('projects')
				// ->where('is_deleted','0')
				// ->orderBy('id', 'asc')
				// ->get();

    	$data = DB::table('projects')
    			->join('users', 'projects.user_id', '=', 'users.id')
    			->select(DB::raw('projects.*, users.id as uid, users.is_delete'))
				->where('is_deleted','0')
				->where('users.is_delete', '=', 0)
				->orderBy('projects.id', 'asc')
				->get();
		
		foreach($data as $data) {
				if($data->statoemotivo != ""){
					$statiemotivitipi = DB::table('statiemotivitipi')->where('id',$data->emotion_stat_id)->orderBy('id', 'asc')->first();
					if(isset($statiemotivitipi->color)){
						$data->statoemotivo = '<span style="color:'.$statiemotivitipi->color.'">'.$statiemotivitipi->name.'</span>';
					}					
				}
				$ente_return[] = $data;	
			}	
			return $ente_return;
	   		// return Project::where('is_deleted', 0)
				// ->orderBy('id', 'asc')
				// ->get();
    }
	
	//miei
	public function forUser2(User $user)
    {
       if($user->id == 0) {

    // 	 $data = DB::table('projects')
				// ->where('is_deleted','0')
				// ->orderBy('id', 'asc')
				// ->get();

       	$data = DB::table('projects')
       			->join('users', 'projects.user_id', '=', 'users.id')
       			->select(DB::raw('projects.*, users.id as uid, users.is_delete'))
				->where('is_deleted','0')
				->where('users.is_delete', '=', 0)
				->orderBy('projects.id', 'asc')
				->get();
							
			foreach($data as $data) {				

				if($data->statoemotivo != ""){
					$statiemotivitipi = DB::table('statiemotivitipi')->where('id',$data->emotion_stat_id)->orderBy('id', 'asc')->first();
					$data->statoemotivo = isset($statiemotivitipi->name) ? '<span style="color:">'.$statiemotivitipi->name.'</span>' : '-';
					if(isset($statiemotivitipi->color)){
						$data->statoemotivo = '<span style="color:'.$statiemotivitipi->color.'">'.$statiemotivitipi->name.'</span>';
					}					
				}
				$ente_return[] = $data;	
			}	
			return $ente_return;
       //     return Project::where('is_deleted', 0)
		   		// ->get();

       } else {
			

		$partecipanti = DB::table('progetti_partecipanti')
			->select('id_progetto')
			->where('id_user', $user->id)
			->get();

		// $progetti = Project::whereIn('id', json_decode(json_encode($partecipanti), true))
		// 	->orWhere('user_id', $user->id)
		// 	->orderBy('id', 'asc')
		// 	->get();

		$progetti = Project::join('users', 'projects.user_id', '=', 'users.id')
			->select(DB::raw('projects.*, users.id as uid, users.is_delete'))
			->whereIn('projects.id', json_decode(json_encode($partecipanti), true))
			->orWhere('projects.user_id', $user->id)
			->where('users.is_delete', '=', 0)
			->orderBy('projects.id', 'asc')
			->get();
		
		foreach($progetti as $prog) {
			if($prog->is_deleted == 0)
				$prog_return[] = $prog;	
		}
				
		return $prog_return;

		}
    }
    
}