<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::where('user_id', Auth::id())->get();
        return view('recipes.index', compact('recipes'));
    }

    public function create()
    {
        return view('recipes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'ingredients' => 'required',
            'description' => 'required',
        ]);

        $validated['user_id'] = Auth::id();
        Recipe::create($validated);

        return redirect()->route('recipes.index')->with('success', 'Recepte pievienota!');
    }

    public function show(Recipe $recipe)
    {
        return view('recipes.show', compact('recipe'));
    }

    public function edit(Recipe $recipe) { /* vēlāk */ }

    public function update(Request $request, Recipe $recipe) { /* vēlāk */ }

    public function destroy(Recipe $recipe) { /* vēlāk */ }
}
