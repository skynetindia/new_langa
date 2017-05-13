<?php

namespace App\Policies;

use App\Event;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    public function autorizza(User $user, Event $quote)
	{
		if ($user->id == 0) {
            return true;
        }
        return $quote->user_id == $user->id;
	}
	
    public function duplicate(User $user, Event $quote)
    {
        return $this->autorizza($user, $quote);
    }
	
    public function modify(User $user, Event $quote)
    {
        return $this->autorizza($user, $quote);
    }
	
    public function destroy(User $user, Event $quote)
    {
        return $this->autorizza($user, $quote);
    }
}