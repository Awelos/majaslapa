<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            ['name' => 'Zupas'],
            ['name' => 'Deserti'],
            ['name' => 'Gaļa'],
            ['name' => 'Veģetārie'],
            ['name' => 'Bezglutēna'],
        ]);
    }
}
