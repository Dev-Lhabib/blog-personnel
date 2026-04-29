<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Laravel',
            'PHP',
            'JavaScript',
            'DevOps',
            'Freelance',
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate(['name' => $name]);
        }
            // Removed truncate and foreign key checks for safer, non-destructive seeding
    }
    }
