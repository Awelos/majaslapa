<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\WeatherService;

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

public function recommended(WeatherService $weatherService)
{
    $weather = $weatherService->getCurrentWeather();

    if (!$weather) {
        return redirect()->route('recipes.index')->with('error', 'Unable to fetch weather data.');
    }

    $temp = $weather['main']['temp'];
    $weatherCondition = $weather['weather'][0]['main'];

    $tagQuery = \App\Models\Tag::query();

    if ($temp < 10) {
        $tagQuery->where('name', 'like', '%soup%');
    } elseif ($weatherCondition === 'Rain') {
        $tagQuery->where('name', 'like', '%comfort%');
    } else {
        $tagQuery->where('name', 'like', '%salad%');
    }

    $tags = $tagQuery->pluck('id');

    $recipes = \App\Models\Recipe::whereHas('tags', function ($query) use ($tags) {
        $query->whereIn('tags.id', $tags);
    })->with('tags')->latest()->limit(10)->get();

    return view('recipes.recommended', compact('recipes', 'weather'));
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('recipes', 'public');
        }

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
