<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\Accounting;

/**
 * In questo modulo l'amministratore e l'admin hanno gli stessi
 * 'poteri', mentre gli altri possono fare azioni solo sui
 * pagamenti, originalmente creati da loro
 */
class AccountingPolicy
{
    use HandlesAuthorization;
	
	public function autorizza(User $user, Accounting $accounting)
	{
		if ($user->id == 0 || $user->dipartimento == "AMMINISTRAZIONE") {
            return true;
        }
        return $accounting->user_id == $user->id;
	}
	
    public function duplicate(User $user, Accounting $accounting)
    {
        return $this->autorizza($user, $accounting);
    }
	
	public function mostra(User $user, Accounting $accounting)
    {
        return $this->autorizza($user, $accounting);
    }
	
    public function modify(User $user, Accounting $accounting)
    {
        return $this->autorizza($user, $accounting);
    }
	
    public function destroy(User $user, Accounting $accounting)
    {
        return $this->autorizza($user, $accounting);
    }
}
