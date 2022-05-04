<?php

namespace App\Providers;

use App\Models\Order\Order;
use App\Policies\OrderPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Enums\UserRoleEnums as Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Order::class => OrderPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /*
         * TRANSPORT SECTION
         */

        Gate::define('create-transport', function ($user) {
            return $user->isLogistic() || $user->isAdmin();
        });

        Gate::define('edit-transport', function ($user) {
            return $user->isLogistic() || $user->isAdmin();
        });

	    /*
		 * PROFILE SECTION
		 */

	    Gate::define('create-staff', function ($user) {
		    return $user->isLogistic() || $user->isAdmin();
	    });

	    /*
		 * ROLE SECTION
		 */

        Gate::define(Role::LOGISTIC, function ($user) {
            return $user->isLogistic();
        });

	    Gate::define(Role::LOGIST, function ($user) {
		    return $user->isLogist();
	    });

	    Gate::define(Role::CLIENT, function ($user) {
		    return $user->isClient();
	    });
    }
}
