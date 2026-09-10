@extends('layouts.app')

@section('title', 'Tableau de bord')

@php
    $published = $articles->where('status', 'published')->count();
    $drafts = $articles->where('status', 'draft')->count();
@endphp

@section('content')
    <div class="hero-grid border-b border-slate-200/70 dark:border-white/10">
        <div class="container-blog py-10">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="eyebrow">Espace auteur</p>
                    <h1 class="font-display mt-3 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl dark:text-white">
                        Bonjour, {{ Str::words(auth()->user()->name, 2, '') }} 👋
                    </h1>
                    <p class="mt-2 text-slate-500 dark:text-slate-400">Gérez vos articles, brouillons et publications.</p>
                </div>
                <div class="flex flex-wrap gap-2.5">
                    <a href="{{ route('articles.index') }}" class="btn-ghost">Voir le blog</a>
                    <a href="{{ route('dashboard.articles.create') }}" class="btn-primary">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Nouvel article
                    </a>
                </div>
            </div>

            <div class="mt-7 grid grid-cols-3 gap-4">
                <div class="card-blog p-4 sm:p-5">
                    <p class="text-2xl font-black text-slate-900 sm:text-3xl dark:text-white">{{ $articles->count() }}</p>
                    <p class="mt-1 text-xs font-semibold uppercase tracking-widest text-slate-400">Total</p>
                </div>
                <div class="card-blog border-green-200/70 p-4 sm:p-5 dark:border-green-500/20">
                    <p class="text-2xl font-black text-green-600 sm:text-3xl dark:text-green-400">{{ $published }}</p>
                    <p class="mt-1 text-xs font-semibold uppercase tracking-widest text-slate-400">Publiés</p>
                </div>
                <div class="card-blog border-amber-200/70 p-4 sm:p-5 dark:border-amber-500/20">
                    <p class="text-2xl font-black text-amber-600 sm:text-3xl dark:text-amber-400">{{ $drafts }}</p>
                    <p class="mt-1 text-xs font-semibold uppercase tracking-widest text-slate-400">Brouillons</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-blog py-8">
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-2xl border border-green-200 bg-green-50 px-5 py-3.5 text-sm font-medium text-green-800 dark:border-green-500/20 dark:bg-green-500/10 dark:text-green-300">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @if($articles->isEmpty())
            <div class="card-blog mx-auto max-w-xl px-8 py-16 text-center">
                <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-indigo-50 text-2xl dark:bg-indigo-500/10">✍️</div>
                <h2 class="font-display mt-5 text-xl font-bold text-slate-900 dark:text-white">Aucun article pour l'instant</h2>
                <p class="mx-auto mt-2 max-w-sm text-sm leading-relaxed text-slate-500 dark:text-slate-400">Rédigez votre premier guide : ajoutez un titre, une image de couverture et un contenu détaillé.</p>
                <a href="{{ route('dashboard.articles.create') }}" class="btn-primary mt-6">Créer votre premier article</a>
            </div>
        @else
            <div class="card-blog overflow-hidden">
                <div class="hidden grid-cols-[1fr_140px_120px_110px_170px] gap-4 border-b border-slate-100 bg-slate-50/70 px-6 py-3 text-[11px] font-bold uppercase tracking-[0.14em] text-slate-400 md:grid dark:border-white/10 dark:bg-white/[0.03] dark:text-slate-500">
                    <span>Titre</span><span>Catégorie</span><span>Statut</span><span>Créé le</span><span class="text-right">Actions</span>
                </div>
                <div class="divide-y divide-slate-100 dark:divide-white/5">
                    @foreach($articles as $article)
                        <div class="grid gap-3 px-6 py-4 transition hover:bg-slate-50/70 md:grid-cols-[1fr_140px_120px_110px_170px] md:items-center md:gap-4 dark:hover:bg-white/[0.03]">
                            <div class="flex min-w-0 items-center gap-3">
                                @if($article->image)
                                    <img src="{{ \Illuminate\Support\Str::startsWith($article->image, ['http://','https://']) ? $article->image : asset('storage/' . $article->image) }}" alt="" class="hidden h-11 w-16 shrink-0 rounded-lg object-cover sm:block">
                                @else
                                    <span class="hidden h-11 w-16 shrink-0 place-items-center rounded-lg bg-gradient-to-br from-indigo-100 to-violet-100 text-indigo-500 sm:grid dark:from-indigo-500/20 dark:to-violet-500/20">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4-4 4 4 4-5 4 4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </span>
                                @endif
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-bold text-slate-900 dark:text-white">{{ $article->title }}</p>
                                    <p class="text-xs text-slate-400">{{ $article->reading_time ?? 1 }} min · {{ $article->category->name }}</p>
                                </div>
                            </div>
                            <div>
                                <span class="rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-bold text-indigo-700 dark:bg-indigo-500/15 dark:text-indigo-300">{{ $article->category->name }}</span>
                            </div>
                            <div>
                                @if($article->status === 'published')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-2.5 py-1 text-xs font-bold text-green-700 dark:bg-green-500/15 dark:text-green-300"><span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>Publié</span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-700 dark:bg-amber-500/15 dark:text-amber-300"><span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>Brouillon</span>
                                @endif
                            </div>
                            <div class="text-[13px] text-slate-400">{{ $article->created_at->format('d/m/Y') }}</div>
                            <div class="flex items-center gap-4 md:justify-end">
                                @if($article->status === 'published')
                                    <a href="{{ route('articles.show', $article) }}" target="_blank" class="text-[13px] font-semibold text-slate-400 transition hover:text-slate-700 dark:hover:text-slate-200">Voir</a>
                                @endif
                                <a href="{{ route('dashboard.articles.edit', $article) }}" class="text-[13px] font-bold text-indigo-600 transition hover:text-indigo-800 dark:text-indigo-400">Modifier</a>
                                <form method="POST" action="{{ route('dashboard.articles.destroy', $article) }}" onsubmit="return confirm('Supprimer cet article ? Cette action est irréversible.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[13px] font-bold text-red-500 transition hover:text-red-700">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <p class="mt-3 text-right text-xs text-slate-400">{{ $articles->count() }} article(s) au total</p>
        @endif
    </div>
@endsection
