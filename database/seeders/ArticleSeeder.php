<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use Carbon\Carbon;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title'        => 'Débuter avec Laravel 11',
                'content'      => 'Laravel est un framework PHP élégant qui facilite le développement web. Dans cet article, nous allons explorer les bases de Laravel 11, ses nouvelles fonctionnalités et comment démarrer un projet from scratch. Laravel suit le pattern MVC et propose des outils puissants comme Eloquent ORM, Blade templating, et bien plus encore. La courbe d\'apprentissage est douce grâce à une documentation excellente et une communauté active.',
                'status'       => 'published',
                'category_id'  => 1,
                'published_at' => Carbon::now()->subDays(10),
            ],
            [
                'title'        => 'Les relations Eloquent expliquées',
                'content'      => 'Eloquent ORM est l\'une des fonctionnalités les plus puissantes de Laravel. Les relations comme hasMany, belongsTo, hasOne, et belongsToMany permettent de modéliser vos données de façon intuitive. Dans cet article, on explore chaque type de relation avec des exemples concrets tirés d\'un blog personnel.',
                'status'       => 'published',
                'category_id'  => 1,
                'published_at' => Carbon::now()->subDays(7),
            ],
            [
                'title'        => 'PHP 8.3 : les nouveautés',
                'content'      => 'PHP 8.3 apporte plusieurs améliorations notables : les typed class constants, json_validate(), la lisibilité des stack traces améliorée, et des optimisations de performance. Dans cet article, on passe en revue les changements les plus impactants pour un développeur Laravel.',
                'status'       => 'published',
                'category_id'  => 2,
                'published_at' => Carbon::now()->subDays(5),
            ],
            [
                'title'        => 'Déployer Laravel sur un VPS',
                'content'      => 'Déployer une application Laravel en production demande de configurer un serveur web (Nginx ou Apache), PHP-FPM, une base de données MySQL, et de gérer les variables d\'environnement. Cet article couvre chaque étape du déploiement sur un VPS Ubuntu.',
                'status'       => 'published',
                'category_id'  => 4,
                'published_at' => Carbon::now()->subDays(3),
            ],
            [
                'title'        => 'Mon premier client en freelance',
                'content'      => 'Se lancer en freelance après une formation est excitant mais intimidant. Dans cet article, je partage mon expérience pour trouver mon premier client, négocier le tarif, rédiger un devis et gérer la relation client. Des conseils pratiques pour ceux qui démarrent.',
                'status'       => 'published',
                'category_id'  => 5,
                'published_at' => Carbon::now()->subDays(1),
            ],
            [
                'title'        => 'Brouillon : Alpine.js avec Laravel',
                'content'      => 'Article en cours de rédaction sur l\'intégration d\'Alpine.js dans un projet Laravel Blade sans bundler.',
                'status'       => 'draft',
                'category_id'  => 3,
                'published_at' => null,
            ],
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }
    }
}
