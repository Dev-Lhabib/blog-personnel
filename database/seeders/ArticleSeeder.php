<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use Carbon\Carbon;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $userId = \App\Models\User::first()->id;

        $articles = [
            [
                'title'        => 'Débuter avec Laravel 11',
                'content'      => 'Laravel est un framework PHP élégant...',
                'status'       => 'published',
                'category_id'  => 1,
                'user_id'      => $userId,
                'published_at' => Carbon::now()->subDays(10),
            ],
            [
                'title'        => 'Les relations Eloquent expliquées',
                'content'      => 'Eloquent ORM est l\'une des fonctionnalités...',
                'status'       => 'published',
                'category_id'  => 1,
                'user_id'      => $userId,
                'published_at' => Carbon::now()->subDays(7),
            ],
            [
                'title'        => 'PHP 8.3 : les nouveautés',
                'content'      => 'PHP 8.3 apporte plusieurs améliorations...',
                'status'       => 'published',
                'category_id'  => 2,
                'user_id'      => $userId,
                'published_at' => Carbon::now()->subDays(5),
            ],
            [
                'title'        => 'Déployer Laravel sur un VPS',
                'content'      => 'Déployer une application Laravel...',
                'status'       => 'published',
                'category_id'  => 4,
                'user_id'      => $userId,
                'published_at' => Carbon::now()->subDays(3),
            ],
            [
                'title'        => 'Mon premier client en freelance',
                'content'      => 'Se lancer en freelance...',
                'status'       => 'published',
                'category_id'  => 5,
                'user_id'      => $userId,
                'published_at' => Carbon::now()->subDays(1),
            ],
            [
                'title'        => 'Brouillon : Alpine.js avec Laravel',
                'content'      => 'Article en cours de rédaction...',
                'status'       => 'draft',
                'category_id'  => 3,
                'user_id'      => $userId,
                'published_at' => null,
            ],
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }
    }
}
