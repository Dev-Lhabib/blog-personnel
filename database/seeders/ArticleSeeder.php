<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use Carbon\Carbon;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            $user = User::firstOrCreate(
                ['email' => 'admin@blog.com'],
                [
                    'name' => 'Blogueur',
                    'password' => bcrypt('password'),
                ]
            );
        }

        $articles = [
            [
                'title'        => 'Débuter avec Laravel 11',
                'content'      => 'Laravel est un framework PHP élégant...',
                'status'       => 'published',
                'category'     => 'Laravel',
                'published_at' => Carbon::now()->subDays(10),
            ],
            [
                'title'        => 'Les relations Eloquent expliquées',
                'content'      => 'Eloquent ORM est l\'une des fonctionnalités...',
                'status'       => 'published',
                'category'     => 'Laravel',
                'published_at' => Carbon::now()->subDays(7),
            ],
            [
                'title'        => 'PHP 8.3 : les nouveautés',
                'content'      => 'PHP 8.3 apporte plusieurs améliorations...',
                'status'       => 'published',
                'category'     => 'PHP',
                'published_at' => Carbon::now()->subDays(5),
            ],
            [
                'title'        => 'Déployer Laravel sur un VPS',
                'content'      => 'Déployer une application Laravel...',
                'status'       => 'published',
                'category'     => 'DevOps',
                'published_at' => Carbon::now()->subDays(3),
            ],
            [
                'title'        => 'Mon premier client en freelance',
                'content'      => 'Se lancer en freelance...',
                'status'       => 'published',
                'category'     => 'Freelance',
                'published_at' => Carbon::now()->subDays(1),
            ],
            [
                'title'        => 'Brouillon : Alpine.js avec Laravel',
                'content'      => 'Article en cours de rédaction...',
                'status'       => 'draft',
                'category'     => 'JavaScript',
                'published_at' => null,
            ],
        ];

        foreach ($articles as $data) {

            $category = Category::where('name', $data['category'])->first();

            if (!$category) continue;

            Article::firstOrCreate(
                ['title' => $data['title']], // avoid duplicates
                [
                    'content'      => $data['content'],
                    'status'       => $data['status'],
                    'category_id'  => $category->id,
                    'user_id'      => $user->id,
                    'published_at' => $data['published_at'],
                ]
            );
        }
    }
}
