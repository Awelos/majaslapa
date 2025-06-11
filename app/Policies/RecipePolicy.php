<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Recipe;
use App\Models\User;

class RecipePolicy
{
    public function update(User $user, Recipe $recipe)
    {
        return $user->id === $recipe->user_id;
    }

    public function delete(User $user, Recipe $recipe)
    {
        return $user->id === $recipe->user_id;
    }
}
