<footer class="mt-20 border-t border-slate-200/70 bg-white dark:border-white/10 dark:bg-white/[0.02]">
    <div class="container-blog py-14">
        <div class="grid gap-10 md:grid-cols-[1.4fr_1fr_1fr_1fr]">
            <div>
                <a href="{{ route('articles.index') }}" class="flex items-center gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded-2xl bg-gradient-to-br from-indigo-600 via-indigo-500 to-violet-500 text-lg font-black text-white shadow-lg shadow-indigo-600/30">M</span>
                    <span class="leading-tight">
                        <span class="font-display block text-lg font-bold tracking-tight text-slate-900 dark:text-white">Mon Blog</span>
                        <span class="block text-[11px] font-semibold uppercase tracking-[0.18em] text-indigo-600 dark:text-indigo-400">Tech &amp; Code</span>
                    </span>
                </a>
                <p class="mt-4 max-w-sm text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                    Guides approfondis sur Laravel, PHP, JavaScript, DevOps et Freelance.
                    Des articles longs, concrets et illustrés pour progresser durablement.
                </p>
                <div class="mt-5 flex items-center gap-2">
                    <a href="#" aria-label="X" class="grid h-9 w-9 place-items-center rounded-xl border border-slate-200 text-slate-500 transition hover:border-indigo-300 hover:text-indigo-600 dark:border-white/10 dark:text-slate-400 dark:hover:text-indigo-300">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.9 2H22l-6.8 7.8L23 22h-6.3l-4.9-6.4L6.2 22H3l7.3-8.3L1.5 2h6.4l4.4 5.9L18.9 2zm-1.1 18h1.7L7 3.9H5.2L17.8 20z"/></svg>
                    </a>
                    <a href="#" aria-label="GitHub" class="grid h-9 w-9 place-items-center rounded-xl border border-slate-200 text-slate-500 transition hover:border-indigo-300 hover:text-indigo-600 dark:border-white/10 dark:text-slate-400 dark:hover:text-indigo-300">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 00-3.16 19.49c.5.09.68-.22.68-.48v-1.7c-2.78.6-3.37-1.34-3.37-1.34-.45-1.16-1.11-1.47-1.11-1.47-.9-.62.07-.6.07-.6 1 .07 1.53 1.03 1.53 1.03.9 1.52 2.35 1.08 2.92.83.09-.65.35-1.09.63-1.34-2.22-.25-4.56-1.11-4.56-4.94 0-1.1.39-1.99 1.03-2.69-.1-.25-.45-1.27.1-2.64 0 0 .84-.27 2.75 1.02a9.56 9.56 0 015 0c1.91-1.3 2.75-1.02 2.75-1.02.55 1.37.2 2.39.1 2.64.64.7 1.03 1.6 1.03 2.69 0 3.84-2.34 4.68-4.57 4.93.36.31.68.92.68 1.85V21c0 .27.18.58.69.48A10 10 0 0012 2z"/></svg>
                    </a>
                    <a href="#" aria-label="LinkedIn" class="grid h-9 w-9 place-items-center rounded-xl border border-slate-200 text-slate-500 transition hover:border-indigo-300 hover:text-indigo-600 dark:border-white/10 dark:text-slate-400 dark:hover:text-indigo-300">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.45 20.45h-3.55v-5.57c0-1.33-.03-3.04-1.85-3.04-1.86 0-2.14 1.45-2.14 2.94v5.67H9.35V9h3.41v1.56h.05c.47-.9 1.63-1.85 3.36-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28zM5.34 7.43a2.06 2.06 0 110-4.12 2.06 2.06 0 010 4.12zM7.12 20.45H3.56V9h3.56v11.45z"/></svg>
                    </a>
                    <a href="#" aria-label="RSS" class="grid h-9 w-9 place-items-center rounded-xl border border-slate-200 text-slate-500 transition hover:border-indigo-300 hover:text-indigo-600 dark:border-white/10 dark:text-slate-400 dark:hover:text-indigo-300">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M4 11a9 9 0 019 9M4 4a16 16 0 0116 16"/><circle cx="5" cy="19" r="1.5" fill="currentColor" stroke="none"/></svg>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="text-xs font-bold uppercase tracking-[0.16em] text-slate-400 dark:text-slate-500">Explorer</h4>
                <ul class="mt-4 space-y-2.5 text-sm font-medium">
                    <li><a href="{{ route('articles.index') }}" class="text-slate-600 transition hover:text-indigo-600 dark:text-slate-300 dark:hover:text-indigo-300">Tous les articles</a></li>
                    @auth
                    <li><a href="{{ route('dashboard.index') }}" class="text-slate-600 transition hover:text-indigo-600 dark:text-slate-300 dark:hover:text-indigo-300">Tableau de bord</a></li>
                    <li><a href="{{ route('dashboard.articles.create') }}" class="text-slate-600 transition hover:text-indigo-600 dark:text-slate-300 dark:hover:text-indigo-300">Écrire un article</a></li>
                    @else
                    <li><a href="{{ route('login') }}" class="text-slate-600 transition hover:text-indigo-600 dark:text-slate-300 dark:hover:text-indigo-300">Se connecter</a></li>
                    @if (Route::has('register'))
                    <li><a href="{{ route('register') }}" class="text-slate-600 transition hover:text-indigo-600 dark:text-slate-300 dark:hover:text-indigo-300">Créer un compte</a></li>
                    @endif
                    @endauth
                </ul>
            </div>

            <div>
                <h4 class="text-xs font-bold uppercase tracking-[0.16em] text-slate-400 dark:text-slate-500">Catégories</h4>
                <ul class="mt-4 space-y-2.5 text-sm font-medium">
                    @php
                        $footerCats = \App\Models\Category::withCount(['articles' => fn($q) => $q->where('status','published')])->orderByDesc('articles_count')->take(5)->get();
                    @endphp
                    @forelse($footerCats as $cat)
                        <li><a href="{{ route('articles.index', ['category' => $cat->slug]) }}" class="text-slate-600 transition hover:text-indigo-600 dark:text-slate-300 dark:hover:text-indigo-300">{{ $cat->name }}</a></li>
                    @empty
                        <li class="text-slate-400">Laravel · PHP · JavaScript</li>
                    @endforelse
                </ul>
            </div>

            <div>
                <h4 class="text-xs font-bold uppercase tracking-[0.16em] text-slate-400 dark:text-slate-500">Newsletter</h4>
                <p class="mt-4 text-sm leading-relaxed text-slate-500 dark:text-slate-400">Un résumé mensuel des nouveaux guides. Zéro spam.</p>
                <form class="mt-4 flex gap-2" onsubmit="return false;">
                    <input type="email" required placeholder="vous@exemple.fr" class="input-blog !py-2.5">
                    <button class="btn-primary shrink-0 !px-4">OK</button>
                </form>
            </div>
        </div>

        <div class="mt-12 flex flex-col items-center justify-between gap-3 border-t border-slate-200/70 pt-6 text-[13px] text-slate-400 sm:flex-row dark:border-white/10 dark:text-slate-500">
            <p>© {{ date('Y') }} Mon Blog — Fait avec Laravel &amp; Tailwind.</p>
            <p class="flex items-center gap-4">
                <a href="{{ route('articles.index') }}" class="transition hover:text-indigo-600">Blog</a>
                <span aria-hidden="true">·</span>
                <span>Lecture estimée sur chaque article</span>
            </p>
        </div>
    </div>
</footer>
