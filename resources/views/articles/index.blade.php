@extends('layouts.app')

@section('title', 'Articles')

@php
    $coverFor = function ($article) {
        if (!empty($article->image) && \Illuminate\Support\Str::startsWith($article->image, ['http://', 'https://'])) {
            return $article->image;
        }
        if (!empty($article->image)) {
            return asset('storage/' . $article->image);
        }
        $map = [
            'laravel'    => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=1200&q=80',
            'php'        => 'https://images.unsplash.com/photo-1526379095098-d400fd0bf935?auto=format&fit=crop&w=1200&q=80',
            'javascript' => 'https://images.unsplash.com/photo-1627398242454-45a1465c2479?auto=format&fit=crop&w=1200&q=80',
            'devops'     => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=1200&q=80',
            'freelance'  => 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=1200&q=80',
        ];
        $slug = optional($article->category)->slug ?? '';
        return $map[$slug] ?? 'https://images.unsplash.com/photo-1488190211105-8b0e65b80b4e?auto=format&fit=crop&w=1200&q=80';
    };
    $excerptFor = function ($article) {
        if (!empty($article->excerpt)) return $article->excerpt;
        $plain = trim(preg_replace('/\s+/', ' ', strip_tags(str_replace(['##', '###', '**', '```', '> ', '- '], '', $article->content ?? ''))));
        return \Illuminate\Support\Str::limit($plain, 220);
    };
    $isFiltered = request()->filled('search') || !empty($activeCategory);
    $featured = (!$isFiltered && $articles->currentPage() === 1 && $articles->count() > 0) ? $articles->first() : null;
    $list = ($featured && !$isFiltered) ? $articles->slice(1) : $articles;
    $totalPublished = $articles->total();
@endphp

@section('content')
    {{-- HERO --}}
    <section class="hero-grid border-b border-slate-200/70 dark:border-white/10">
        <div class="container-blog pb-10 pt-12 sm:pt-16">
            <div class="max-w-3xl animate-fade-up">
                <span class="eyebrow">
                    <span class="h-1.5 w-1.5 rounded-full bg-indigo-500"></span>
                    Journal de bord numérique
                </span>
                <h1 class="font-display mt-5 text-4xl font-bold leading-[1.05] tracking-tight text-slate-900 sm:text-5xl lg:text-[3.4rem] dark:text-white">
                    Des idées pour <span class="bg-gradient-to-r from-teal-700 to-orange-500 bg-clip-text text-transparent">mieux créer</span> sur le web.
                </h1>
                <p class="mt-4 max-w-2xl text-[15.5px] leading-relaxed text-slate-500 sm:text-lg dark:text-slate-400">
                    Des récits, des méthodes et des guides qui vont au-delà du snippet rapide.
                    Chaque article prend le temps de donner le contexte, les choix et les détails utiles.
                </p>
                <div class="mt-6 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-slate-500 dark:text-slate-400">
                    <span class="inline-flex items-center gap-2">
                        <svg class="h-4 w-4 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.25v11.5m-7.5-7.5h15M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" opacity="0"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5A2.5 2.5 0 016.5 17H20V5a2 2 0 00-2-2H6a2 2 0 00-2 2v14.5zM4 19.5A2.5 2.5 0 006.5 22H20v-5"/></svg>
                        <strong class="text-slate-800 dark:text-slate-100">{{ $totalPublished }}</strong>&nbsp;article{{ $totalPublished > 1 ? 's' : '' }} publié{{ $totalPublished > 1 ? 's' : '' }}
                    </span>
                    <span class="inline-flex items-center gap-2">
                        <svg class="h-4 w-4 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h10v10H7zM4 4h13v13"/></svg>
                        <strong class="text-slate-800 dark:text-slate-100">{{ $categories->count() }}</strong>&nbsp;catégories
                    </span>
                    <span class="inline-flex items-center gap-2">
                        <svg class="h-4 w-4 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z"/></svg>
                        Temps de lecture indiqué
                    </span>
                </div>
            </div>

            {{-- SEARCH + FILTERS --}}
            <div id="recherche" class="card-blog mt-8 scroll-mt-24 p-4 sm:p-5">
                <form method="GET" action="{{ route('articles.index') }}" class="flex flex-col gap-3 sm:flex-row">
                    @if($activeCategory)
                        <input type="hidden" name="category" value="{{ $activeCategory }}">
                    @endif
                    <div class="relative flex-grow">
                        <svg class="pointer-events-none absolute left-4 top-1/2 h-4.5 w-4.5 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un article : Laravel, Eloquent, freelance…"
                            class="input-blog !pl-11 !py-3">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="btn-primary flex-1 sm:flex-none">Rechercher</button>
                        @if(request('search'))
                            <a href="{{ route('articles.index', $activeCategory ? ['category' => $activeCategory] : []) }}" class="btn-ghost">Effacer</a>
                        @endif
                    </div>
                </form>

                <div class="mt-4 flex flex-wrap gap-2 border-t border-slate-100 pt-4 dark:border-white/10">
                    <a href="{{ route('articles.index', request('search') ? ['search' => request('search')] : []) }}"
                        class="pill {{ !$activeCategory ? 'border-indigo-600 bg-indigo-600 text-white shadow-lg shadow-indigo-600/25' : 'border-slate-200 bg-white text-slate-600 hover:border-indigo-300 hover:text-indigo-700 dark:border-white/10 dark:bg-white/5 dark:text-slate-300 dark:hover:text-indigo-300' }}">
                        Toutes
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('articles.index', array_filter(['category' => $category->slug, 'search' => request('search')])) }}"
                            class="pill {{ $activeCategory === $category->slug ? 'border-indigo-600 bg-indigo-600 text-white shadow-lg shadow-indigo-600/25' : 'border-slate-200 bg-white text-slate-600 hover:border-indigo-300 hover:text-indigo-700 dark:border-white/10 dark:bg-white/5 dark:text-slate-300 dark:hover:text-indigo-300' }}">
                            {{ $category->name }}
                            <span class="rounded-full px-1.5 text-xs font-bold {{ $activeCategory === $category->slug ? 'bg-white/20' : 'bg-slate-100 text-slate-500 dark:bg-white/10 dark:text-slate-400' }}">{{ $category->articles_count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <div class="container-blog py-10">
        @if($articles->isEmpty())
            <div class="card-blog mx-auto max-w-xl px-8 py-16 text-center">
                <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-indigo-50 text-2xl dark:bg-indigo-500/10">🔍</div>
                <h2 class="font-display mt-5 text-xl font-bold text-slate-900 dark:text-white">Aucun article trouvé</h2>
                <p class="mt-2 text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                    @if(request('search'))
                        Aucun résultat pour « <strong>{{ request('search') }}</strong> ».
                    @endif
                    Essayez un autre mot-clé ou explorez une catégorie.
                </p>
                <a href="{{ route('articles.index') }}" class="btn-primary mt-6">Voir tous les articles</a>
            </div>
        @else
            {{-- FEATURED --}}
            @if($featured)
                <a href="{{ route('articles.show', $featured) }}"
                   class="card-blog card-blog-hover img-zoom group grid overflow-hidden md:grid-cols-2">
                    <div class="relative min-h-[260px] overflow-hidden md:min-h-[340px]">
                        <img src="{{ $coverFor($featured) }}" alt="{{ $featured->title }}" loading="eager"
                             class="absolute inset-0 h-full w-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent md:bg-gradient-to-r"></div>
                        <span class="absolute left-4 top-4 inline-flex items-center gap-1.5 rounded-full bg-white/95 px-3 py-1.5 text-xs font-bold text-indigo-700 shadow">
                            ⭐ À la une
                        </span>
                    </div>
                    <div class="flex flex-col justify-center p-7 sm:p-10">
                        <div class="flex flex-wrap items-center gap-2 text-xs">
                            <span class="rounded-full bg-indigo-50 px-3 py-1 font-bold text-indigo-700 dark:bg-indigo-500/15 dark:text-indigo-300">{{ $featured->category->name }}</span>
                            <span class="font-medium text-slate-400">{{ $featured->reading_time }} min de lecture · {{ $featured->published_at->format('d M Y') }}</span>
                        </div>
                        <h2 class="font-display mt-4 text-2xl font-bold leading-tight tracking-tight text-slate-900 transition group-hover:text-indigo-700 sm:text-[2rem] dark:text-white dark:group-hover:text-indigo-300">
                            {{ $featured->title }}
                        </h2>
                        <p class="clamp-3 mt-3 leading-relaxed text-slate-500 dark:text-slate-400">{{ $excerptFor($featured) }}</p>
                        <div class="mt-6 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="grid h-10 w-10 place-items-center rounded-full bg-gradient-to-br from-indigo-500 to-violet-500 text-sm font-black text-white">{{ strtoupper(substr($featured->user->name, 0, 1)) }}</span>
                                <div class="text-sm">
                                    <p class="font-bold text-slate-800 dark:text-slate-100">{{ $featured->user->name }}</p>
                                    <p class="text-xs text-slate-400">Auteur</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1.5 text-sm font-bold text-indigo-600 dark:text-indigo-400">
                                Lire l'article
                                <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg>
                            </span>
                        </div>
                    </div>
                </a>
            @endif

            {{-- GRID --}}
            <div class="mt-8 flex items-center justify-between">
                <h2 class="font-display text-xl font-bold tracking-tight text-slate-900 dark:text-white">
                    {{ $isFiltered ? 'Résultats' : 'Derniers articles' }}
                </h2>
                <p class="text-sm text-slate-400">{{ $articles->total() }} article{{ $articles->total() > 1 ? 's' : '' }} publié{{ $articles->total() > 1 ? 's' : '' }}</p>
            </div>

            <div class="mt-5 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($list as $article)
                    <article class="card-blog card-blog-hover img-zoom group flex flex-col overflow-hidden">
                        <a href="{{ route('articles.show', $article) }}" class="relative block aspect-[16/10] overflow-hidden bg-slate-100 dark:bg-white/5">
                            <img src="{{ $coverFor($article) }}" alt="{{ $article->title }}" loading="lazy" class="absolute inset-0 h-full w-full object-cover">
                            <span class="absolute left-3 top-3 rounded-full bg-white/95 px-2.5 py-1 text-[11px] font-bold text-indigo-700 shadow backdrop-blur">
                                {{ $article->category->name }}
                            </span>
                        </a>
                        <div class="flex flex-grow flex-col p-5">
                            <p class="text-xs font-medium text-slate-400">{{ $article->reading_time }} min · {{ $article->published_at->format('d/m/Y') }}</p>
                            <h3 class="font-display mt-1.5 text-[17px] font-bold leading-snug tracking-tight text-slate-900 dark:text-white">
                                <a href="{{ route('articles.show', $article) }}" class="transition group-hover:text-indigo-700 dark:group-hover:text-indigo-300">
                                    {{ $article->title }}
                                </a>
                            </h3>
                                <p class="clamp-3 mt-2 flex-grow text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                                {{ $excerptFor($article) }}
                            </p>
                            <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-4 dark:border-white/10">
                                <div class="flex items-center gap-2">
                                    <span class="grid h-7 w-7 place-items-center rounded-full bg-gradient-to-br from-slate-700 to-slate-900 text-[11px] font-black text-white dark:from-indigo-500 dark:to-violet-500">{{ strtoupper(substr($article->user->name, 0, 1)) }}</span>
                                    <span class="max-w-[110px] truncate text-[13px] font-semibold text-slate-600 dark:text-slate-300">{{ $article->user->name }}</span>
                                </div>
                                <a href="{{ route('articles.show', $article) }}" class="inline-flex items-center gap-1 text-[13px] font-bold text-indigo-600 transition hover:gap-2 dark:text-indigo-400">
                                    Lire &rarr;
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-10 flex justify-center">
                {{ $articles->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        document.addEventListener('keydown', (e) => {
            if (e.key === '/' && document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
                e.preventDefault();
                document.querySelector('input[name="search"]')?.focus();
            }
        });
    </script>
    @endpush
@endsection
