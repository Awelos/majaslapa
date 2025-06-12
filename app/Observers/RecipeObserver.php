<?php

namespace App\Observers;

use App\Models\Recipe;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class RecipeObserver
{
    public function updated(Recipe $recipe)
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'updated',
            'model_type' => Recipe::class,
            'model_id' => $recipe->id,
            'old_values' => $recipe->getOriginal(),
            'new_values' => $recipe->getChanges(),
        ]);
    }

    public function created(Recipe $recipe)
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'created',
            'model_type' => Recipe::class,
            'model_id' => $recipe->id,
            'new_values' => $recipe->getAttributes(),
        ]);
    }

    public function deleted(Recipe $recipe)
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'deleted',
            'model_type' => Recipe::class,
            'model_id' => $recipe->id,
            'old_values' => $recipe->getOriginal(),
        ]);
    }
}
