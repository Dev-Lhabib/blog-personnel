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
                'title' => 'Débuter avec Laravel 11 : le guide complet',
                'category' => 'Laravel',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(12),
                'image' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=1200&q=80',
                'content' => <<<'MD'
Laravel est aujourd'hui le framework PHP le plus populaire au monde, et la version 11 marque une étape importante : installation simplifiée, structure allégée, performances améliorées. Dans ce guide complet, nous allons passer en revue tout ce dont vous avez besoin pour démarrer sereinement, que vous soyez débutant en PHP ou développeur expérimenté qui découvre l'écosystème.

## Pourquoi choisir Laravel en 2026

Laravel ne se contente pas d'être un framework : c'est un écosystème complet. Authentification, files d'attente, planification de tâches, envoi d'e-mails, cache, tests : tout est intégré et documenté avec un soin rare. La courbe d'apprentissage est douce mais la profondeur est immense.

- Une documentation exemplaire, traduite et illustrée d'exemples réels
- Une communauté énorme : packages, tutoriels, réponses sur tous les problèmes courants
- Eloquent, l'un des ORM les plus agréables à utiliser en PHP
- Blade, un moteur de templates simple mais redoutablement efficace
- Un outillage moderne : Vite, Pint, Sail, Forge, Vapor

> Retenez ceci : Laravel vous fait gagner du temps sur tout ce qui n'est pas votre valeur métier, pour vous concentrer sur l'essentiel.

## Installation et premier projet

Prérequis : PHP 8.2 minimum, Composer, une base de données (SQLite suffit pour débuter). La commande officielle crée un projet prêt à l'emploi.

```
composer create-project laravel/laravel mon-blog
cd mon-blog
php artisan serve
```

Votre application tourne déjà sur http://localhost:8000. La structure de Laravel 11 est volontairement épurée : moins de fichiers de configuration, des valeurs par défaut sensées, et la possibilité de publier uniquement ce que vous personnalisez.

## Comprendre la structure d'un projet

Voici les dossiers que vous manipulerez quotidiennement et leur rôle exact.

- `routes/web.php` : vos pages web classiques avec sessions et CSRF
- `routes/api.php` : vos endpoints JSON pour applications mobiles ou SPA
- `app/Models` : vos modèles Eloquent, le coeur de vos données
- `app/Http/Controllers` : la logique qui relie requêtes HTTP et réponses
- `resources/views` : vos templates Blade
- `database/migrations` : l'historique versionné de votre schéma de base
- `database/seeders` : les jeux de données de démonstration et de test

## Les routes : le point d'entrée de tout

Tout commence par une route. Une route associe une URL à une action. Commencez par des closures pour prototyper, puis basculez vers des contrôleurs dès que la logique grandit.

```
Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{article}', [ArticleController::class, 'show']);
Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
});
```

Nommez systématiquement vos routes avec `->name('articles.index')`. Vous pourrez ensuite générer des URLs avec `route('articles.index')` dans tout votre code et vos vues, sans jamais écrire d'URL en dur.

## Eloquent en cinq minutes

Créez un modèle et sa migration d'une seule commande, puis décrivez vos données en PHP plutôt qu'en SQL.

```
php artisan make:model Article -m
```

Dans la migration, définissez vos colonnes. Dans le modèle, déclarez les relations. Ensuite, tout devient limpide : `Article::published()->latest()->paginate(6)` récupère vos articles publiés, triés et paginés. C'est lisible, testable et sécurisé contre les injections SQL.

## Blade : des vues propres et dynamiques

Blade compile vos templates en PHP pur, avec un système de cache très performant. Héritage de layouts avec `@extends`, sections, composants `<x-...>`, directives `@auth`, `@foreach`, `@if` : vous construisez des interfaces cohérentes sans duplication.

## Les erreurs classiques des débutants

- Mettre trop de logique dans les routes au lieu des contrôleurs et des modèles
- Oublier les validations avec `$request->validate()` et exposer l'application aux données invalides
- Négliger les seeders : sans données réalistes, impossible de tester la pagination, la recherche ou le design
- Ne pas utiliser les factories et les tests dès le début du projet

## Plan d'action pour vos 7 prochains jours

1. Installez Laravel 11 et explorez la page d'accueil générée
2. Créez un modèle `Article` avec migration, contrôleur et vues Blade
3. Ajoutez validation, pagination et upload d'image
4. Écrivez un seeder avec 10 articles réalistes
5. Déployez sur un hébergement simple pour montrer votre travail

## Conclusion

Laravel 11 est la meilleure porte d'entrée du développement PHP moderne : exigeant sur les bonnes pratiques, généreux sur la productivité. Construisez un vrai projet de blog comme celui-ci, publiez-le, puis revenez lire le guide sur Eloquent pour passer au niveau supérieur.
MD,
            ],
            [
                'title' => 'Les relations Eloquent expliquées avec exemples',
                'category' => 'Laravel',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(10),
                'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1200&q=80',
                'content' => <<<'MD'
Eloquent est l'ORM de Laravel et l'une des raisons principales de son succès. Mais sa vraie puissance se révèle quand on maîtrise les relations entre modèles. Un article appartient à une catégorie et à un auteur, une catégorie contient plusieurs articles : modéliser cela proprement change tout, en lisibilité comme en performance.

## Les quatre relations à connaître absolument

On peut tout construire avec quatre relations. Le reste n'est que combinaison de celles-ci.

- `belongsTo` : l'enfant pointe vers le parent (un article appartient à une catégorie)
- `hasMany` : le parent possède plusieurs enfants (une catégorie a plusieurs articles)
- `belongsToMany` : relation plusieurs-à-plusieurs via une table pivot (articles et tags)
- `hasOne` / `hasManyThrough` : cas avancés comme le profil d'un utilisateur

## belongsTo et hasMany : le duo quotidien

Côté modèle `Article`, déclarez à qui il appartient. Côté `Category`, déclarez ce qu'elle possède. Laravel devine les clés étrangères par convention : `category_id` et `user_id`.

```
class Article extends Model {
    public function category() {
        return $this->belongsTo(Category::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}

class Category extends Model {
    public function articles() {
        return $this->hasMany(Article::class);
    }
}
```

Ensuite, `$article->category->name` et `$category->articles` fonctionnent naturellement dans vos vues Blade, vos contrôleurs et même vos seeders.

## Le piège N+1 et comment l'éviter

Sans précaution, afficher 20 articles avec leur catégorie et leur auteur exécute 41 requêtes : 1 pour les articles, puis 2 par article. C'est le problème N+1, classique et dévastateur en production.

La solution tient en un mot : **eager loading**.

```
Article::with(['category', 'user'])
    ->published()
    ->latest('published_at')
    ->paginate(6);
```

Avec `with()`, Laravel charge toutes les relations en 3 requêtes au total. Ajoutez `withCount()` quand vous n'avez besoin que du nombre : `$category->articles_count` sans charger les articles eux-mêmes.

## Les scopes : des requêtes réutilisables

Au lieu de répéter `where('status', 'published')` partout, encapsulez vos filtres métier dans des scopes locaux sur le modèle.

```
public function scopePublished($query) {
    return $query->where('status', 'published');
}

// Usage : Article::published()->latest()->get();
```

Vos contrôleurs deviennent courts et expressifs, vos intentions métier sont centralisées au même endroit, et vos tests sont simplifiés.

## belongsToMany : articles et tags

Quand un article peut avoir plusieurs tags et qu'un tag couvre plusieurs articles, créez une table pivot `article_tag` avec une migration, puis déclarez `belongsToMany` des deux côtés. Vous pourrez attacher, détacher et synchroniser avec `attach()`, `detach()` et `sync()`.

## Valider et sécuriser les clés étrangères

Côté contrôleur, validez toujours les relations entrantes : `'category_id' => ['required', 'exists:categories,id']`. Côté base, ajoutez `->constrained()->onDelete('cascade')` dans vos migrations pour garantir l'intégrité référentielle même en cas de suppression.

## Trois requêtes à maîtriser par coeur

- Lister avec relations : `Article::with('category')->published()->latest()->paginate(6)`
- Filtrer par relation : `Article::whereHas('category', fn($q) => $q->where('slug', $slug))->get()`
- Compter par parent : `Category::withCount(['articles' => fn($q) => $q->published()])->get()`

## Conclusion

Maîtriser `belongsTo`, `hasMany`, l'eager loading et les scopes, c'est passer de code qui fonctionne à du code professionnel. Appliquez ces patterns à ce blog : catégories avec compteurs, articles paginés avec auteurs, recherche combinée aux filtres. Vous verrez immédiatement la différence en clarté et en performance.
MD,
            ],
            [
                'title' => 'PHP 8.3 : les nouveautés à connaître absolument',
                'category' => 'PHP',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(8),
                'image' => 'https://images.unsplash.com/photo-1526379095098-d400fd0bf935?auto=format&fit=crop&w=1200&q=80',
                'content' => <<<'MD'
PHP 8.3 n'est pas une révolution spectaculaire, mais une version de maturité qui rend le quotidien des développeurs plus sûr et plus expressif. Constantes typées, attributs `#[Override]`, clonage profond des readonly, JSON amélioré : voici tout ce qui mérite vraiment votre attention, avec des exemples concrets tirés de projets Laravel réels.

## Les constantes de classe typées

C'est la nouveauté la plus visible. Vous pouvez désormais typer les constantes, et PHP vérifiera les affectations et les surcharges dans les classes enfants.

```
class Article {
    public const string STATUS_DRAFT = 'draft';
    public const string STATUS_PUBLISHED = 'published';
    public const int PER_PAGE = 6;
}
```

Fini les constantes dont la valeur change de type silencieusement au fil des refontes. Vos IDE autocomplètent mieux, vos erreurs sont détectées plus tôt, votre code est auto-documenté.

## L'attribut #[Override] : fini les fautes silencieuses

Combien de fois avez-vous cru surcharger une méthode du parent en vous trompant dans le nom ou la signature ? Avec `#[Override]`, PHP vérifie qu'une méthode parent correspondante existe vraiment.

```
class ArticleController extends Controller {
    #[Override]
    public function index(Request $request): View {
        // ...
    }
}
```

Adoptez-le systématiquement dans vos contrôleurs, modèles et classes de test. C'est une sécurité gratuite contre toute une famille de bugs furtifs.

## Clonage profond des propriétés readonly

Les classes readonly, introduites en PHP 8.2, pouvaient poser problème au clonage : les objets internes restaient partagés entre l'original et le clone. PHP 8.3 autorise la réinitialisation des propriétés readonly dans `__clone`, ce qui rend le clonage profond propre et prévisible.

## json_validate() : valider sans décoder

Avant, pour savoir si une chaîne était du JSON valide, il fallait la décoder puis inspecter les erreurs. Désormais, une fonction dédiée fait le travail proprement et rapidement.

```
if (json_validate($payload)) {
    $data = json_decode($payload, true);
}
```

Idéal pour valider des webhooks, des imports ou des réponses d'API avant tout traitement coûteux.

## Des fonctions array plus expressives

`array_find()`, `array_any()`, `array_all()` arrivent pour exprimer directement vos intentions sur les collections, sans écrire de boucles manuelles. Combinez-les avec les fonctions fléchées `fn` pour un code dense mais lisible.

```
$hasPublished = array_any($articles, fn($a) => $a['status'] === 'published');
```

## Ce que cela change pour Laravel

- Des modèles avec des constantes typées pour les statuts, les rôles et les limites de pagination
- Des contrôleurs et des jobs où `#[Override]` sécurise les surcharges
- Des API plus robustes grâce à `json_validate()` sur les payloads entrants
- Un code globalement plus strict, donc plus facile à refactorer

> La philosophie de PHP 8.x est claire : ajouter du typage et des garde-fous sans casser la flexibilité historique du langage. Chaque version rend les erreurs plus précoces et les intentions plus explicites.

## Faut-il migrer dès maintenant ?

Oui, dans la grande majorité des cas. PHP 8.3 est stable, rapide et rétro-compatible avec le code 8.1 et 8.2 bien écrit. Vérifiez vos dépendances avec Composer, lancez votre suite de tests, surveillez les dépréciations, puis mettez à jour vos environnements de staging avant la production.

## Checklist de migration en 6 étapes

1. Sauvegardez et figez la version actuelle qui fonctionne
2. Mettez à jour en local et corrigez les dépréciations signalées
3. Lancez PHPUnit et vos tests navigateur
4. Auditez les packages tiers et leurs versions compatibles
5. Déployez sur staging et testez les parcours critiques
6. Basculez la production en heures creuses avec rollback préparé

## Conclusion

PHP 8.3 récompense les développeurs rigoureux : typage renforcé, intentions explicites, bugs détectés plus tôt. Adoptez les constantes typées et `#[Override]` dès votre prochain commit, et votre base Laravel vous remerciera à chaque refactoring.
MD,
            ],
            [
                'title' => 'JavaScript moderne : Alpine.js avec Laravel',
                'category' => 'JavaScript',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(6),
                'image' => 'https://images.unsplash.com/photo-1627398242454-45a1465c2479?auto=format&fit=crop&w=1200&q=80',
                'content' => <<<'MD'
Faut-il systématiquement sortir React ou Vue pour chaque interaction ? Certainement pas. Alpine.js apporte la réactivité exactement là où Blade s'arrête : menus déroulants, modales, onglets, aperçus en direct. Léger, sans étape de build, il est le compagnon idéal de Laravel. Voici comment l'utiliser comme un professionnel.

## Pourquoi Alpine.js plutôt qu'un gros framework

Un dropdown de navigation ou une modale de confirmation ne justifient pas 200 Ko de JavaScript et une architecture SPA. Alpine.js pèse environ 15 Ko, se déclare directement dans le HTML avec `x-data`, et disparaît presque de votre charge mentale.

- Zéro build : fonctionne avec le `app.js` par défaut de Laravel Breeze
- Syntaxe déclarative dans le HTML, proche de Vue mais minimaliste
- Parfait pour 90 % des interactions d'un blog ou d'un back-office
- Coexiste très bien avec Blade et Tailwind CSS

## Installation en une minute

Alpine est souvent déjà présent avec les starters Laravel. Sinon, ajoutez-le via npm et initialisez-le dans votre JavaScript.

```
npm install alpinejs
```

```
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();
```

Recompilez avec Vite et toutes vos directives `x-...` deviennent actives dans vos vues Blade.

## Le pattern x-data : votre état local

Tout commence par `x-data`, qui déclare l'état d'un composant directement sur un élément HTML.

```
<nav x-data="{ open: false }">
    <button @click="open = !open">Menu</button>
    <div x-show="open">Contenu du menu</div>
</nav>
```

`@click` écoute les événements, `x-show` affiche ou masque, `:class` bascule des classes Tailwind. C'est tout : pas de store, pas de cycle de vie complexe pour les cas courants.

## Cinq composants indispensables pour un blog

Voici les patterns que vous réutiliserez sur presque tous vos projets.

### 1. Menu mobile responsive

Un booléen `open`, un bouton hamburger, un panneau qui s'affiche avec `:class="{ 'block': open, 'hidden': !open }"`. Ajoutez `x-transition` pour une ouverture animée élégante.

### 2. Dropdown utilisateur

Combinez `@click` pour ouvrir, `@click.away` pour fermer en cliquant ailleurs, et `x-transition` pour l'animation. C'est exactement le pattern utilisé dans la navigation de ce blog.

### 3. Modale de confirmation de suppression

Évitez les suppressions accidentelles : stockez l'URL à supprimer dans `x-data`, affichez une modale centrée avec fond flouté, confirmez avant de soumettre le formulaire DELETE.

### 4. Aperçu d'image avant upload

Quand l'auteur choisit une couverture, affichez-la immédiatement avec `URL.createObjectURL()`. Le retour visuel instantané change complètement l'expérience du formulaire de création d'article.

### 5. Barre de progression de lecture

Quelques lignes suffisent : écoutez le scroll, calculez le pourcentage de page parcouru, ajustez la largeur d'une barre fixe en haut. C'est la barre dégradée que vous voyez sur chaque article de ce blog.

## Organiser son code quand ça grandit

Tant que vos composants tiennent en quelques lignes d'attributs, restez dans le HTML. Quand la logique dépasse une dizaine de lignes, extrayez-la dans des fonctions `Alpine.data()` dans `resources/js/app.js`. Vous gardez des vues lisibles et un JavaScript testable.

## Les erreurs à éviter

- Parsemer du `document.querySelector` impératif partout au lieu d'utiliser l'état déclaratif
- Oublier `x-cloak` : sans lui, les éléments masqués clignotent brièvement au chargement
- Charger jQuery en plus d'Alpine pour des besoins qu'Alpine couvre déjà
- Vouloir tout faire en Alpine quand un vrai composant Livewire ou une API serait plus adapté

## Quand passer à Vue, React ou Livewire

Alpine couvre l'interactivité locale. Basculez vers Livewire quand l'état doit vivre côté serveur (recherche instantanée, pagination dynamique, formulaires complexes). Réservez Vue ou React aux interfaces très riches : éditeurs, tableaux de bord temps réel, applications collaboratives.

## Conclusion

Alpine.js incarne une sagesse trop oubliée : choisir l'outil le plus simple qui fait le travail. Sur ce blog, il gère la navigation, les dropdowns, les aperçus d'images et la progression de lecture, pour quelques kilo-octets. Maîtrisez ces cinq patterns et 90 % de vos besoins frontend Blade seront couverts durablement.
MD,
            ],
            [
                'title' => 'Déployer Laravel sur un VPS pas à pas',
                'category' => 'DevOps',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(4),
                'image' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=1200&q=80',
                'content' => <<<'MD'
Mettre en ligne un projet Laravel fait peur la première fois : serveur, PHP, base de données, HTTPS, files d'attente, permissions. Ce guide décompose le déploiement sur VPS en étapes claires et vérifiables, avec les commandes essentielles et les pièges à éviter. Suivez-le dans l'ordre et votre blog tournera en production en une après-midi.

## Choisir son infrastructure sans se tromper

Pour un blog ou un MVP, un VPS modeste suffit largement : 2 Go de RAM, 1 vCPU, 25 Go de SSD. Choisissez une distribution LTS (Ubuntu 24.04), activez les sauvegardes automatiques, et préférez un fournisseur avec console web en cas de perte d'accès SSH.

- Un VPS chez Hetzner, DigitalOcean, OVH ou Scaleway
- Ubuntu LTS pour la documentation abondante et les paquets récents
- Un nom de domaine avec accès à la zone DNS pour les certificats HTTPS
- Des sauvegardes automatiques dès le premier jour, sans exception

## Préparer le serveur : la base saine

Connectez-vous en SSH, créez un utilisateur non-root avec sudo, désactivez la connexion root par mot de passe, installez PHP 8.2+, Nginx, MySQL ou PostgreSQL, Redis, Composer et Node.js. Automatisez avec un script pour pouvoir reconstruire le serveur à l'identique.

```
sudo apt update && sudo apt upgrade -y
sudo apt install nginx mysql-server php8.3-fpm php8.3-mysql redis composer -y
```

Vérifiez chaque service avec `systemctl status` avant de passer à la suite. Un déploiement réussi repose toujours sur une base saine et comprise.

## Cloner et configurer l'application

Créez `/var/www/mon-blog`, clonez votre dépôt, installez les dépendances PHP sans les packages de développement, copiez `.env.example` vers `.env` et générez la clé d'application.

```
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate --force
```

Renseignez ensuite `APP_URL`, la connexion base de données, le driver de cache Redis, la configuration e-mail et les chemins de stockage. Chaque variable doit être pensée pour la production, jamais copiée aveuglément du développement local.

## Base de données et migrations en production

Créez la base et l'utilisateur dédié avec des privilèges limités à cette base. Lancez les migrations avec `--force` (obligatoire en production), puis exécutez vos seeders de référence : catégories, compte admin initial. Ne seedez jamais de fausses données de test en production.

```
php artisan migrate --force
php artisan db:seed --class=CategorySeeder
```

Testez immédiatement la connexion depuis l'application et sauvegardez la base avant toute opération risquée.

## Nginx, HTTPS et permissions : les trois incontournables

Configurez un virtual host Nginx pointant vers `public/`, avec `try_files` vers `index.php` et un bloc PHP-FPM. Obtenez un certificat gratuit avec Certbot, qui renouvellera automatiquement votre HTTPS. Réglez les permissions : `www-data` propriétaire de `storage` et `bootstrap/cache`, jamais de `777` global.

```
sudo certbot --nginx -d mon-blog.fr -d www.mon-blog.fr
sudo chown -R www-data:www-data storage bootstrap/cache
```

Vérifiez le cadenas dans le navigateur et forcez la redirection HTTP vers HTTPS dans votre configuration.

## Optimiser Laravel pour la production

Laravel propose des commandes d'optimisation qui compilent config, routes et vues en cache. Lancez-les après chaque déploiement, et reconstruisez le frontend avec `npm run build` pour servir des assets versionnés et minifiés.

```
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

Ajoutez un worker Supervisor pour les files d'attente et une entrée cron pour le planificateur : `* * * * * php /var/www/mon-blog/artisan schedule:run`.

## La checklist avant d'annoncer la mise en ligne

1. `APP_DEBUG=false` et page 404/500 personnalisée vérifiée
2. HTTPS valide et renouvellement automatique testé
3. Sauvegardes base + fichiers programmées et restaurées une fois pour preuve
4. Logs surveillés pendant 24 heures après le déploiement
5. Temps de réponse mesuré et cache OPcache activé

> Un déploiement professionnel n'est pas celui qui marche une fois, mais celui que vous pouvez refaire dix fois sans stress grâce à la documentation et à l'automatisation.

## Conclusion

VPS, Nginx, HTTPS, migrations, cache : chaque étape est simple prise isolément, redoutable quand on les découvre en vrac sous pression. Documentez votre procédure exacte pour ce blog, automatisez-la progressivement, et le prochain déploiement ne prendra qu'une vingtaine de minutes sereines.
MD,
            ],
            [
                'title' => 'Mon premier client en freelance : méthode complète',
                'category' => 'Freelance',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(2),
                'image' => 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=1200&q=80',
                'content' => <<<'MD'
Décrocher son premier client freelance est un cap psychologique autant que commercial. On doute de ses compétences, de ses tarifs, de sa légitimité. Ce retour d'expérience détaillé vous donne une méthode complète et honnête : positionnement, prospection, devis, exécution et fidélisation. Appliquez-la pendant 30 jours et vous aurez vos premières conversations sérieuses.

## Changer de posture : du technicien au partenaire

Les clients n'achètent pas du code, ils achètent de la tranquillité : un site qui inspire confiance, un outil qui fait gagner du temps, un interlocuteur qui comprend leur métier. Votre discours doit donc parler résultats avant technologies.

- Ne vendez pas Laravel, vendez un site rapide qui génère des contacts
- Ne vendez pas des heures, vendez une mise en ligne en trois semaines avec formation incluse
- Ne promettez pas tout, promettez peu et livrez plus que prévu

> Votre premier client ne cherche pas le meilleur développeur du monde. Il cherche quelqu'un de sérieux, disponible et pédagogue.

## Construire une offre claire en une page

Une offre floue ne vend pas. Rédigez une page unique avec un titre orienté bénéfice, trois formules (essentiel, recommandé, premium), des exemples concrets et un appel à l'action unique : réserver un appel découverte de 20 minutes.

Précisez ce qui est inclus et exclu : nombre de pages, révisions, formation, maintenance. La clarté protège des malentendus et positionne immédiatement votre professionnalisme.

## Où trouver vos dix premiers prospects

Oubliez les plateformes généralistes saturées au démarrage. Vos premiers clients sont déjà dans votre réseau élargi : anciens employeurs, commerces de votre quartier, associations, indépendants que vous suivez en ligne.

- Listez 50 contacts et entreprises qui pourraient avoir besoin d'un site
- Personnalisez chaque message avec un constat précis sur leur présence actuelle
- Proposez un audit gratuit de 15 minutes plutôt qu'un devis aveugle
- Publiez chaque semaine un article technique comme ceux de ce blog pour prouver votre expertise

## L'appel découverte : écouter avant de vendre

Préparez cinq questions ouvertes sur leur activité, leurs clients, leurs objectifs à six mois et leurs échecs passés avec des prestataires. Parlez 20 % du temps, écoutez 80 %. Reformulez leur besoin avec vos mots avant de parler solution ou tarif.

Envoyez ensuite un compte-rendu écrit sous 24 heures : besoin compris, périmètre proposé, planning, tarif. Ce simple document vous distinguera de 90 % des concurrents qui se contentent d'un prix lâché au téléphone.

## Chiffrer juste : ni bradé ni fantaisiste

Calculez votre taux journalier à partir de vos charges réelles et de vos jours facturables (comptez 150 à 180 jours par an, pas 365). Ajoutez une marge pour les imprévus, les révisions et la gestion de projet, souvent sous-estimée de moitié par les débutants.

- Devis détaillé avec jalons de paiement : 30 % à la signature, 40 % à mi-parcours, 30 % à la livraison
- Contrat écrit même pour les petits montants : périmètre, délais, propriété, maintenance
- Factures et relances professionnelles dès le premier jour de retard

## Livrer une expérience irréprochable

Découpez le projet en lots visibles chaque semaine, partagez une URL de staging, demandez des retours écrits à chaque étape. Documentez : guide d'administration, vidéo de prise en main, identifiants transmis proprement. Le jour de la mise en ligne, vérifiez HTTPS, sauvegardes, formulaires et performances avec le client en appel.

## Transformer un projet en relation durable

La vraie rentabilité du freelance vient de la récurrence. Proposez un forfait de maintenance mensuel : mises à jour, sauvegardes vérifiées, petites évolutions, support prioritaire. Demandez un témoignage écrit et une autorisation de présenter le projet en portfolio. Un client satisfait recommande en moyenne deux nouveaux prospects dans l'année.

## Les erreurs qui coûtent cher au début

- Accepter un projet flou sans périmètre écrit par peur de perdre le client
- Sous-facturer pour décrocher, puis bâcler faute de rentabilité
- Tout miser sur un seul gros client au lieu de diversifier
- Négliger la comptabilité et la trésorerie jusqu'au premier rappel fiscal

## Votre plan de 30 jours

1. Semaine 1 : offre une page, portfolio avec deux projets démo, profils à jour
2. Semaine 2 : 50 prospects listés, 20 messages personnalisés envoyés
3. Semaine 3 : appels découverte, comptes-rendus, premiers devis
4. Semaine 4 : signature, acompte, lancement cadré du projet

## Conclusion

Votre premier client ne récompensera pas votre niveau technique absolu mais votre sérieux relatif : clarté de l'offre, écoute réelle, exécution soignée, suivi professionnel. Construisez cette réputation projet après projet, et le freelance deviendra un flux régulier plutôt qu'une loterie angoissante.
MD,
            ],
            [
                'title' => 'Construire une API REST propre avec Laravel',
                'category' => 'Laravel',
                'status' => 'published',
                'published_at' => Carbon::now()->subDay(),
                'image' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=1200&q=80',
                'content' => <<<'MD'
Une API REST propre est un contrat de confiance avec vos consommateurs : mobiles, frontends, partenaires. Laravel fournit tout le nécessaire — routes API, ressources, validation, authentification Sanctum, pagination — mais c'est votre discipline qui fera la différence entre une API agréable et un champ de mines. Voici les bonnes pratiques qui comptent vraiment.

## Penser ressources avant endpoints

Modélisez votre domaine en ressources nommées au pluriel : `GET /api/articles`, `POST /api/articles`, `GET /api/articles/{article}`, `PUT /api/articles/{article}`, `DELETE /api/articles/{article}`. Utilisez `Route::apiResource()` pour générer ces routes conventionnelles d'un coup.

```
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('articles', ApiArticleController::class);
});
```

Les actions non-ressources (recherche avancée, publication, statistiques) deviennent des endpoints dédiés et explicites : `POST /api/articles/{article}/publish`. La prévisibilité est la première qualité d'une API.

## Les API Resources : votre couche de présentation

Ne retournez jamais vos modèles bruts. Les `JsonResource` transforment vos données, masquent les champs sensibles, formatent les dates et incluent les relations de façon contrôlée.

```
class ArticleResource extends JsonResource {
    public function toArray($request) {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'excerpt' => Str::limit(strip_tags($this->content), 150),
            'category' => $this->whenLoaded('category')->name,
            'reading_time' => $this->reading_time,
            'published_at' => $this->published_at?->toIso8601String(),
        ];
    }
}
```

Versionnez vos réponses dès le premier jour (`/api/v1/...`) : vous pourrez évoluer sans casser les clients existants.

## Validation : des erreurs exploitables

Validez tout ce qui entre avec des `FormRequest` dédiées. Retournez des erreurs structurées avec le champ fautif, le message traduit et la règle violée. Côté client, affichez les messages près des champs correspondants plutôt qu'une alerte générique.

Documentez les codes HTTP que vous utilisez vraiment : 200, 201 avec `Location`, 204 sans contenu, 400, 401, 403, 404, 422 pour la validation, 429 pour le rate limiting, 500 pour l'imprévu. La cohérence vaut mieux que l'exhaustivité théorique.

## Authentification avec Sanctum

Pour une SPA ou une application mobile first-party, Sanctum avec tokens personnels est le choix le plus simple et robuste. Émettez un token à la connexion, révoquez-le à la déconnexion, définissez des expirations et des abilities (`articles:write`) pour limiter les périmètres.

- Jamais de token dans les URLs ou les logs
- Rotation des tokens après incident ou départ d'un collaborateur
- Rate limiting différencié : strict en écriture, souple en lecture
- CORS configuré au plus juste, jamais en wildcard en production

## Pagination, filtres et tri : l'expérience développeur

Exposez les mêmes conventions que votre blog : `?page=`, `?per_page=` plafonné, `?search=`, `?category=`, `?sort=-published_at`. Retournez toujours les métadonnées de pagination (total, page courante, dernière page, liens) dans un format stable.

```
{
  "data": [...],
  "meta": { "current_page": 1, "total": 42, "per_page": 15 },
  "links": { "next": "...", "prev": null }
}
```

## Gestion d'erreurs et observabilité

Centralisez le format d'erreur, loguez avec contexte (utilisateur, endpoint, payload anonymisé), mesurez les temps de réponse par route et alertez sur les 5xx. Ajoutez un identifiant de corrélation propagé dans les headers pour relier logs frontend et backend lors du debug.

## Documenter : OpenAPI dès le début

Une API sans documentation à jour est une API morte. Décrivez vos endpoints en OpenAPI, générez une interface Scalar ou Swagger UI, fournissez des exemples de requêtes et réponses réelles. Mettez la documentation à jour dans la même pull request que le code, jamais après.

## Checklist d'une API prête pour la production

1. Ressources REST cohérentes et versionnées en `/v1`
2. Resources JSON stables avec champs documentés
3. Validation exhaustive avec erreurs 422 exploitables
4. Auth Sanctum, CORS strict, rate limiting actif
5. Pagination, filtres et tri homogènes partout
6. Documentation OpenAPI publiée et exemples testés
7. Logs, métriques et alertes sur les erreurs 5xx

## Conclusion

Une bonne API REST Laravel ne doit rien au hasard : ressources prévisibles, réponses versionnées via Resources, validation stricte, auth Sanctum bien cadrée et documentation vivante. Appliquez cette checklist à votre prochain endpoint et vos consommateurs — y compris vous-même dans six mois — vous remercieront.
MD,
            ],
        ];

        foreach ($articles as $data) {
            $category = Category::where('name', $data['category'])->first();
            if (!$category) continue;

            $existing = Article::where('title', $data['title'])->first();

            if ($existing) {
                $existing->update([
                    'content' => $data['content'],
                    'status' => $data['status'],
                    'category_id' => $category->id,
                    'user_id' => $user->id,
                    'published_at' => $data['published_at'],
                    'image' => $data['image'],
                ]);
            } else {
                Article::create([
                    'title' => $data['title'],
                    'slug' => Article::generateSlug($data['title']),
                    'content' => $data['content'],
                    'status' => $data['status'],
                    'category_id' => $category->id,
                    'user_id' => $user->id,
                    'published_at' => $data['published_at'],
                    'image' => $data['image'],
                ]);
            }
        }
    }
}
