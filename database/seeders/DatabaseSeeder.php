<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Users ────────────────────────────────────────────────
        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@newsapp.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Editor Redaksi',
            'email'    => 'editor@newsapp.com',
            'password' => Hash::make('password'),
            'role'     => 'editor',
        ]);

        // ─── Categories ───────────────────────────────────────────
        $categories = [
            ['name' => 'Teknologi',  'slug' => 'teknologi'],
            ['name' => 'Bisnis',     'slug' => 'bisnis'],
            ['name' => 'Olahraga',   'slug' => 'olahraga'],
            ['name' => 'Politik',    'slug' => 'politik'],
            ['name' => 'Hiburan',    'slug' => 'hiburan'],
            ['name' => 'Kesehatan',  'slug' => 'kesehatan'],
            ['name' => 'Pendidikan', 'slug' => 'pendidikan'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // ─── Tags ─────────────────────────────────────────────────
        $tags = [
            ['name' => 'AI',           'slug' => 'ai'],
            ['name' => 'Indonesia',    'slug' => 'indonesia'],
            ['name' => 'Startup',      'slug' => 'startup'],
            ['name' => 'Inovasi',      'slug' => 'inovasi'],
            ['name' => 'Digital',      'slug' => 'digital'],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
