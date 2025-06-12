<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::latest()->get();
        return view('reviews.index', compact('reviews'));
    }

    public function store(Request $request)
    {
        $request->validate(['content' => 'required']);
        Review::create(['content' => $request->content]);
        return redirect()->route('reviews.index');
    }
}