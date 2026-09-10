@extends('layouts.app')

@section('title', $article->title)

@php
    if (!empty($article->image) && \Illuminate\Support\Str::startsWith($article->image, ['http://', 'https://'])) {
        $cover = $article->image;
    } elseif (!empty($article->image)) {
        $cover = asset('storage/' . $article->image);
    } else {
        $map = [
            'laravel'    => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=1600&q=80',
            'php'        => 'https://images.unsplash.com/photo-1526379095098-d400fd0bf935?auto=format&fit=crop&w=1600&q=80',
            'javascript' => 'https://images.unsplash.com/photo-1627398242454-45a1465c2479?auto=format&fit=crop&w=1600&q=80',
            'devops'     => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=1600&q=80',
            'freelance'  => 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=1600&q=80',
        ];
        $cover = $map[$article->category->slug] ?? 'https://images.unsplash.com/photo-1488190211105-8b0e65b80b4e?auto=format&fit=crop&w=1600&q=80';
    }

    $standfirst = !empty($article->excerpt)
        ? $article->excerpt
        : \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags(str_replace(['##','###','**','```','> ','- '], '', $article->content)))), 180);

    // Lightweight markdown-lite renderer (frontend only)
    $renderBody = function (string $text) {
        $text = str_replace(["\r\n", "\r"], "\n", $text);
        $lines = explode("\n", $text);
        $html = ''; $inList = false; $inCode = false; $codeBuf = [];
        $closeList = function () use (&$html, &$inList) { if ($inList) { $html .= '</ul>'; $inList = false; } };
        foreach ($lines as $line) {
            $trim = trim($line);
            if (str_starts_with($trim, '```')) {
                if (!$inCode) { $closeList(); $inCode = true; $codeBuf = []; }
                else { $inCode = false; $html .= '<pre><code>' . e(implode("\n", $codeBuf)) . '</code></pre>'; }
                continue;
            }
            if ($inCode) { $codeBuf[] = $line; continue; }
            if ($trim === '') { $closeList(); continue; }
            if ($trim === '---') { $closeList(); $html .= '<hr>'; continue; }
            if (str_starts_with($trim, '## ')) {
                $closeList();
                $t = substr($trim, 3);
                $html .= '<h2 id="' . \Illuminate\Support\Str::slug($t) . '">' . e($t) . '</h2>';
                continue;
            }
            if (str_starts_with($trim, '### ')) {
                $closeList();
                $t = substr($trim, 4);
                $html .= '<h3 id="' . \Illuminate\Support\Str::slug($t) . '">' . e($t) . '</h3>';
                continue;
            }
            if (str_starts_with($trim, '> ')) {
                $closeList();
                $html .= '<blockquote>' . e(substr($trim, 2)) . '</blockquote>';
                continue;
            }
            if (str_starts_with($trim, '- ')) {
                if (!$inList) { $html .= '<ul>'; $inList = true; }
                $item = e(substr($trim, 2));
                $item = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $item);
                $item = preg_replace('/`([^`]+)`/', '<code>$1</code>', $item);
                $html .= '<li>' . $item . '</li>';
                continue;
            }
            $closeList();
            $p = e($trim);
            $p = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $p);
            $p = preg_replace('/`([^`]+)`/', '<code>$1</code>', $p);
            $html .= '<p>' . $p . '</p>';
        }
        $closeList();
        if ($inCode) { $html .= '<pre><code>' . e(implode("\n", $codeBuf)) . '</code></pre>'; }
        return $html;
    };

    // Table of contents from ## headings
    $toc = [];
    foreach (explode("\n", str_replace(["\r\n","\r"], "\n", $article->content)) as $l) {
        $l = trim($l);
        if (str_starts_with($l, '## ')) {
            $t = substr($l, 3);
            $toc[] = ['title' => $t, 'id' => \Illuminate\Support\Str::slug($t)];
        }
    }

    // Related articles — queried in-view so no controller change is needed
    $related = \App\Models\Article::with(['category', 'user'])
        ->where('status', 'published')
        ->where('id', '!=', $article->id)
        ->where('category_id', $article->category_id)
        ->latest('published_at')->take(3)->get();
    if ($related->count() < 3) {
        $extra = \App\Models\Article::with(['category', 'user'])
            ->where('status', 'published')
            ->where('id', '!=', $article->id)
            ->whereNotIn('id', $related->pluck('id')->all())
            ->latest('published_at')->take(3 - $related->count())->get();
        $related = $related->concat($extra);
    }
    $relatedCover = function ($a) use ($cover) {
        if (!empty($a->image) && \Illuminate\Support\Str::startsWith($a->image, ['http://','https://'])) return $a->image;
        if (!empty($a->image)) return asset('storage/' . $a->image);
        return $cover;
    };
@endphp

@section('content')
    {{-- Reading progress --}}
    <div class="fixed inset-x-0 top-[68px] z-40 h-1 bg-transparent">
        <div id="reading-progress" class="h-full w-0 bg-gradient-to-r from-indigo-600 to-violet-500"></div>
    </div>

    {{-- Hero --}}
    <section class="hero-grid border-b border-slate-200/70 dark:border-white/10">
        <div class="container-blog max-w-4xl pb-8 pt-10 sm:pt-14">
            <nav class="flex items-center gap-2 text-[13px] font-medium text-slate-400">
                <a href="{{ route('articles.index') }}" class="transition hover:text-indigo-600">Articles</a>
                <span aria-hidden="true">/</span>
                <a href="{{ route('articles.index', ['category' => $article->category->slug]) }}" class="transition hover:text-indigo-600">{{ $article->category->name }}</a>
            </nav>

            <div class="mt-5 flex flex-wrap items-center gap-2">
                <a href="{{ route('articles.index', ['category' => $article->category->slug]) }}"
                   class="rounded-full bg-indigo-600 px-3.5 py-1.5 text-xs font-bold text-white shadow-lg shadow-indigo-600/25 transition hover:bg-indigo-700">
                    {{ $article->category->name }}
                </a>
                <span class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-white px-3.5 py-1.5 text-xs font-semibold text-slate-500 dark:border-white/10 dark:bg-white/5 dark:text-slate-300">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z"/></svg>
                    {{ $article->reading_time }} min de lecture
                </span>
                <span class="text-xs font-medium text-slate-400">{{ $article->published_at->format('d F Y') }}</span>
            </div>

            <h1 class="font-display mt-5 text-3xl font-bold leading-[1.12] tracking-tight text-slate-900 sm:text-[2.75rem] dark:text-white">
                {{ $article->title }}
            </h1>
            <p class="mt-4 max-w-2xl text-[16.5px] leading-relaxed text-slate-500 dark:text-slate-400">{{ $standfirst }}</p>

            <div class="mt-6 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <span class="grid h-11 w-11 place-items-center rounded-full bg-gradient-to-br from-indigo-500 to-violet-500 text-base font-black text-white">
                        {{ strtoupper(substr($article->user->name, 0, 1)) }}
                    </span>
                    <div>
                        <p class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $article->user->name }}</p>
                        <p class="text-xs text-slate-400">Publié le {{ $article->published_at->format('d/m/Y') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="copyLink(this)" data-url="{{ url()->current() }}"
                        class="btn-ghost !px-4 !py-2 !text-[13px]">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/></svg>
                        <span>Copier le lien</span>
                    </button>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener"
                       class="btn-ghost !px-4 !py-2 !text-[13px]">Partager</a>
                </div>
            </div>
        </div>
    </section>

    <div class="container-blog max-w-6xl py-10">
        <div class="grid gap-10 lg:grid-cols-[1fr_260px]">
            <article class="min-w-0">
                <figure class="img-zoom overflow-hidden rounded-3xl border border-slate-200/70 shadow-soft dark:border-white/10">
                    <img src="{{ $cover }}" alt="{{ $article->title }}" class="aspect-[16/8] w-full object-cover">
                </figure>
                <p class="mt-3 text-center text-xs text-slate-400">Image d'illustration — {{ $article->category->name }}</p>

                <div class="card-blog mt-6 p-6 sm:p-10">
                    <div class="article-content">
                        {!! $renderBody($article->content) !!}
                    </div>

                    <div class="mt-10 flex flex-wrap items-center gap-2 border-t border-slate-100 pt-6 dark:border-white/10">
                        <span class="text-xs font-bold uppercase tracking-widest text-slate-400">Catégorie :</span>
                        <a href="{{ route('articles.index', ['category' => $article->category->slug]) }}"
                           class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-bold text-indigo-700 transition hover:bg-indigo-100 dark:bg-indigo-500/15 dark:text-indigo-300">
                            {{ $article->category->name }}
                        </a>
                    </div>
                </div>

                {{-- Author --}}
                <div class="card-blog mt-6 flex flex-col gap-4 p-6 sm:flex-row sm:items-center sm:p-8">
                    <span class="grid h-16 w-16 shrink-0 place-items-center rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-500 text-2xl font-black text-white">
                        {{ strtoupper(substr($article->user->name, 0, 1)) }}
                    </span>
                    <div class="flex-1">
                        <p class="text-xs font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Écrit par</p>
                        <p class="font-display text-lg font-bold text-slate-900 dark:text-white">{{ $article->user->name }}</p>
                        <p class="mt-1 text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                            Passionné de développement web, je partage des guides détaillés et des retours
                            d'expérience concrets sur mes technologies favorites.
                        </p>
                    </div>
                    <a href="{{ route('articles.index') }}" class="btn-ghost shrink-0">Tous les articles</a>
                </div>
            </article>

            {{-- Sidebar --}}
            <aside class="hidden lg:block">
                <div class="sticky top-28 space-y-6">
                    @if(count($toc))
                    <div class="card-blog p-5">
                        <h3 class="text-xs font-bold uppercase tracking-[0.16em] text-slate-400">Sommaire</h3>
                        <ul class="mt-3 space-y-2">
                            @foreach($toc as $i => $entry)
                                <li>
                                    <a href="#{{ $entry['id'] }}" class="group flex gap-2.5 text-[13.5px] font-medium leading-snug text-slate-500 transition hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-300">
                                        <span class="font-bold text-indigo-400">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                        <span class="group-hover:underline">{{ $entry['title'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-600 p-6 text-white shadow-lg shadow-indigo-600/30">
                        <h3 class="font-display text-lg font-bold leading-snug">Recevez les nouveaux guides</h3>
                        <p class="mt-2 text-[13px] leading-relaxed text-indigo-100">Un e-mail par mois. Les meilleurs articles, rien d'autre.</p>
                        <form class="mt-4 space-y-2" onsubmit="return false;">
                            <input type="email" required placeholder="vous@exemple.fr" class="w-full rounded-xl border border-white/25 bg-white/15 px-4 py-2.5 text-sm text-white placeholder:text-indigo-200 focus:border-white focus:outline-none">
                            <button class="w-full rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-indigo-700 transition hover:bg-indigo-50">S'abonner</button>
                        </form>
                    </div>
                    <a href="{{ route('articles.index') }}" class="block rounded-2xl border border-dashed border-slate-300 p-5 text-center text-sm font-semibold text-slate-500 transition hover:border-indigo-400 hover:text-indigo-600 dark:border-white/15 dark:text-slate-400">
                        &larr; Retour à tous les articles
                    </a>
                </div>
            </aside>
        </div>

        {{-- Related --}}
        @if($related->isNotEmpty())
        <section class="mt-14">
            <div class="flex items-end justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-indigo-600 dark:text-indigo-400">Continuer la lecture</p>
                    <h2 class="font-display mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl dark:text-white">Articles similaires</h2>
                </div>
                <a href="{{ route('articles.index', ['category' => $article->category->slug]) }}" class="hidden text-sm font-bold text-indigo-600 sm:inline dark:text-indigo-400">Voir la catégorie &rarr;</a>
            </div>
            <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($related as $rel)
                    <article class="card-blog card-blog-hover img-zoom group flex flex-col overflow-hidden">
                        <a href="{{ route('articles.show', $rel) }}" class="relative block aspect-[16/9] overflow-hidden bg-slate-100 dark:bg-white/5">
                            <img src="{{ $relatedCover($rel) }}" alt="{{ $rel->title }}" loading="lazy" class="absolute inset-0 h-full w-full object-cover">
                        </a>
                        <div class="flex flex-grow flex-col p-5">
                            <p class="text-xs font-bold text-indigo-600 dark:text-indigo-400">{{ $rel->category->name }} · {{ $rel->reading_time }} min</p>
                            <h3 class="font-display mt-1.5 leading-snug font-bold text-slate-900 dark:text-white">
                                <a href="{{ route('articles.show', $rel) }}" class="transition group-hover:text-indigo-700 dark:group-hover:text-indigo-300">{{ $rel->title }}</a>
                            </h3>
                            <span class="mt-3 text-[13px] font-bold text-slate-400">Par {{ $rel->user->name }} · {{ $rel->published_at->format('d/m/Y') }}</span>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
        @endif
    </div>

    @push('scripts')
    <script>
        function copyLink(btn) {
            const url = btn.getAttribute('data-url');
            navigator.clipboard?.writeText(url).then(() => {
                const label = btn.querySelector('span');
                if (label) { label.textContent = 'Lien copié ✓'; setTimeout(() => label.textContent = 'Copier le lien', 2000); }
            });
        }
        const bar = document.getElementById('reading-progress');
        addEventListener('scroll', () => {
            const h = document.documentElement;
            const max = h.scrollHeight - h.clientHeight;
            if (bar && max > 0) bar.style.width = (h.scrollTop / max * 100) + '%';
        }, { passive: true });
    </script>
    @endpush
@endsection
