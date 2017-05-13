<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use DB;
use App\Project;

class ProjectPolicy
{
    use HandlesAuthorization;
	
	public function autorizza(User $user, Project $project)
	{
		if ($user->id == 0) {
            return true;
        } else {
			$partecipanti = DB::table('progetti_partecipanti')
				->where([
					'id_progetto' => $project->id,
					'id_user' => $user->id
				])
				->first();
			$partecipante = ($partecipanti != null) ? true : false;
			return $project->user_id === $user->id || $partecipante;
		}
	}
	
    public function duplicate(User $user, Project $project)
    {
        return $this->autorizza($user, $project);
    }
	
    public function modify(User $user, Project $project)
    {
        return $this->autorizza($user, $project);
    }
	
    public function destroy(User $user, Project $project)
    {
        return $this->autorizza($user, $project);
    }
}