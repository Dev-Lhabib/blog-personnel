<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // disable FK
        DB::table('categories')->truncate();        // now works
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // enable FK

        $categories = [
            'Laravel',
            'PHP',
            'JavaScript',
            'DevOps',
            'Freelance',
            'test',
            'test2',
        ];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
    }
