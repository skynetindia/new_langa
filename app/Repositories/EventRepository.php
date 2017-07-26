<?php

namespace App\Repositories;

use App\User;
use App\Event;
use DB;

class EventRepository
{
    /**
     * Get all of the events for a given user at a given month.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUser(User $user, $month, $year)
    {
		//print_r($user);
       if($user->id == 0 || $user->dipartimento == 0)
           return DB::table('events')->where('meseFine', '>=', $month)
            ->where('annoFine', '>=', $year)
            ->orderBy('giorno', 'asc')
            ->get();
        return DB::table('events')->where('user_id', $user->id)
            ->where('meseFine', '>=', $month)
            ->where('annoFine', '>=', $year)
            ->orderBy('giorno', 'asc')
            ->get();
    }
	
	public function forUser2(User $user, $month, $year)
    {
       if($user->id == 0 || $user->dipartimento == 0)
           return DB::table('events')->where('meseFine', '>=', $month)
            ->where('annoFine', '>=', $year)
            ->orderBy('giorno', 'asc')
            ->get();
        return DB::table('events')
            ->where('meseFine', '>=', $month)
            ->where('annoFine', '>=', $year)
            ->orderBy('giorno', 'asc')
            ->get();
    }
	
	public function findEvent(User $user, $id)
	{
         if($user->id == 0 || $user->dipartimento == 0)
           return Event::where([
			'id' => $id,
		])
			->get();
		return Event::where([
			'id' => $id,
		])
			->get();
	}
}