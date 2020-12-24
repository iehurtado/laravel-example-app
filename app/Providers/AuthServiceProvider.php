<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
use App\Models\User;
use App\Models\Post;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $postBelongsToCurrentUserOr = function ($message) {
            return function (User $user, Post $post) use ($message) {
                return $post->author->is($user)
                    ? Response::allow()
                    : Response::deny($message);
            };
        };
        
        Gate::define('update-post', $postBelongsToCurrentUserOr('No puedes modificar un post que no te pertenece'));
        Gate::define('delete-post', $postBelongsToCurrentUserOr('No puedes eliminar un post que no te pertenece'));
    }
}
