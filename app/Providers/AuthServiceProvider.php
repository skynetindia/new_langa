<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
	    'App\Corporation' => 'App\Policies\CorporationPolicy',
		'App\Event' => 'App\Policies\EventPolicy',
        'App\Quote' => 'App\Policies\QuotePolicy',
        'App\Project' => 'App\Policies\ProjectPolicy',
		'App\Accounting' => 'App\Policies\AccountingPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //
    }
}
