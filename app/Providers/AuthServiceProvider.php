<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Recipe;
use App\Policies\RecipePolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Recipe::class => RecipePolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
    public const HOME = '/all-recipes';
}