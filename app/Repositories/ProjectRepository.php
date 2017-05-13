<?php

namespace App\Repositories;

use App\User;
use DB;
use App\Project;

class ProjectRepository
{
	// tutti
    public function forUser(User $user)
    {
        return Project::where('is_deleted', 0)
			->orderBy('id', 'asc')
			->get();
    }
	
	//miei
	public function forUser2(User $user)
    {
       if($user->id == 0)
           return Project::where('is_deleted', 0)
		   		->get();
				
		$partecipanti = DB::table('progetti_partecipanti')
			->select('id_progetto')
			->where('id_user', $user->id)
			->get();
				
		$progetti = Project::whereIn('id', json_decode(json_encode($partecipanti), true))
			->orWhere('user_id', $user->id)
			->orderBy('id', 'asc')
			->get();
			
		foreach($progetti as $prog) {
			if($prog->is_deleted == 0)
				$prog_return[] = $prog;	
		}
				
		return $prog_return;
    }
    
}