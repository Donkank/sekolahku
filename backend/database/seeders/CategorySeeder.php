<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'category'  => 'Pengumuman',
            'slug'      => Str::slug('Pengumuman', '-')
        ]);

        Category::create([
            'category'  => 'Informasi',
            'slug'      => Str::slug('Informasi', '-')
        ]);

        Category::create([
            'category'  => 'Tutorial',
            'slug'      => Str::slug('Tutorial', '-')
        ]);

        Category::create([
            'category'  => 'Dopodik',
            'slug'      => Str::slug('Dapodik', '-')
        ]);

        Category::create([
            'category'  => 'Project P5',
            'slug'      => Str::slug('Project P5', '-')
        ]);

        Category::create([
            'category'  => 'Blog',
            'slug'      => Str::slug('Blog', '-')
        ]);
    }
}
