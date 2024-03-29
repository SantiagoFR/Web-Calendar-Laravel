<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::before(function ($user, $ability) {
            if($user->permisos()->find(1)!=null) return true;
        });
        Gate::define("profesor",function($user){
            if($user->permisos()->find(2)!=null) return true;
        });
        Gate::define("alumno",function($user){
            if($user->permisos()->find(3)!=null) return true;
        });
        Gate::define("administracion",function($user){
            if($user->permisos()->find(4)!=null) return true;
        });
        Gate::define("administracion_profesor",function($user){
            if($user->permisos()->find(4)!=null || $user->permisos()->find(2)!=null) return true;
        });
    }
}
