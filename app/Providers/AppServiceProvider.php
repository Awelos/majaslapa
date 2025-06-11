<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Recipe;
use App\Observers\RecipeObserver;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Recipe::observe(RecipeObserver::class);
    }
}
