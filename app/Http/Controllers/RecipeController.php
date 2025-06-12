<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\WeatherService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    use AuthorizesRequests;


        public function index(Request $request)
    {
        $query = Recipe::where('user_id', Auth::id());

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('ingredients', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('tags')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->whereIn('id', $request->tags);
            });
        }

        $recipes = $query->latest()->paginate(10);
        $availableTags = Tag::all();

        return view('recipes.index', [
            'recipes' => $recipes,
            'personal' => true,
            'availableTags' => $availableTags,
        ]);
    }



    public function allRecipes(Request $request)
    {
        $query = Recipe::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('ingredients', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('tags')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->whereIn('name', $request->tags);
            });
        }

        $availableTags = Tag::all();
        $recipes = $query->latest()->paginate(10);

        return view('recipes.index', [
            'recipes' => $recipes,
            'personal' => false,
            'availableTags' => $availableTags,
        ]);
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        $tags = Tag::all();

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

        $tagQuery = Tag::query();

        if ($temp < 10) {
            $tagQuery->where('name', 'like', '%soup%');
        } elseif ($weatherCondition === 'Rain') {
            $tagQuery->where('name', 'like', '%comfort%');
        } else {
            $tagQuery->where('name', 'like', '%salad%');
        }

        $tags = $tagQuery->pluck('id');

        $recipes = Recipe::whereHas('tags', function ($query) use ($tags) {
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

    public function edit(Recipe $recipe)
    {
        $this->authorize('update', $recipe);
        $allTags = Tag::all();
        return view('recipes.edit', compact('recipe', 'allTags'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'ingredients' => 'required|string',
            'description' => 'required|string',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($recipe->image) {
                Storage::delete('public/' . $recipe->image);
            }
            $path = $request->file('image')->store('recipes', 'public');
            $recipe->image = $path;
        }

        $recipe->title = $request->title;
        $recipe->ingredients = $request->ingredients;
        $recipe->description = $request->description;
        $recipe->save();

        $recipe->tags()->sync($request->tags ?? []);

        return redirect()->route('recipes.show', $recipe)->with('success', 'Recepte atjaunināta!');
    }

    public function destroy(Recipe $recipe)
    {
        $this->authorize('delete', $recipe);
        $recipe->delete();
        return redirect()->route('recipes.index')->with('success', __('Recipe deleted.'));
    }
}
