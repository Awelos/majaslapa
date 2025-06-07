<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = ['title', 'ingredients', 'description', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
