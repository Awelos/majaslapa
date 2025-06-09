<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('recipes.index', ['recipes' => $recipes, 'personal' => true]);
    }

    public function allRecipes()
    {
        $recipes = Recipe::orderBy('created_at', 'desc')->get();

        return view('recipes.index', ['recipes' => $recipes, 'personal' => false]);
    }


    public function create()
    {
        $categories = \App\Models\Category::all();
        $tags = \App\Models\Tag::all();

        return view('recipes.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'ingredients' => 'required',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
        ]);

        $validated['user_id'] = Auth::id();
        $recipe = Recipe::create($validated);

        $recipe->tags()->sync($request->input('tags', []));

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
