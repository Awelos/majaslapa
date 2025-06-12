<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = ['Vegāns', 'Bezglutēna', 'Ātri pagatavojams', 'Deserts', 'Zems kaloriju saturs', 'soup', 'comfort', 'salad'];

        foreach ($tags as $tagName) {
            \App\Models\Tag::firstOrCreate(['name' => $tagName]);
        }
    }
}
