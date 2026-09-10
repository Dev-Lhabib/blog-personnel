<nav x-data="{ open: false }" class="sticky top-0 z-50 border-b border-slate-200/70 bg-white/80 backdrop-blur-xl dark:border-white/10 dark:bg-[#0b0e1a]/80">
    <div class="container-blog">
        <div class="flex h-[68px] items-center justify-between gap-4">
            <!-- Brand -->
            <div class="flex items-center gap-10">
                <a href="{{ route('articles.index') }}" class="group flex items-center gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded-2xl bg-[#173f3a] text-lg font-black text-[#f6c453] shadow-lg shadow-teal-900/20 transition group-hover:rotate-[-4deg] group-hover:scale-105">
                        B
                    </span>
                    <span class="leading-tight">
                        <span class="font-display block text-[17px] font-bold tracking-tight text-slate-900 dark:text-white">Mon Blog</span>
                        <span class="block text-[11px] font-semibold uppercase tracking-[0.18em] text-teal-700 dark:text-teal-400">Notes &amp; idées</span>
                    </span>
                </a>

                <div class="hidden items-center gap-1 lg:flex">
                    <a href="{{ route('articles.index') }}"
                       class="rounded-xl px-4 py-2 text-sm font-semibold transition {{ request()->routeIs('articles.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/15 dark:text-indigo-300' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-white/5 dark:hover:text-white' }}">
                        Articles
                    </a>
                    @auth
                    <a href="{{ route('dashboard.index') }}"
                       class="rounded-xl px-4 py-2 text-sm font-semibold transition {{ request()->routeIs('dashboard.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/15 dark:text-indigo-300' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-white/5 dark:hover:text-white' }}">
                        Tableau de bord
                    </a>
                    @endauth
                </div>
            </div>

            <!-- Right -->
            <div class="flex items-center gap-2 sm:gap-3">
                <button onclick="toggleDarkMode()" aria-label="Basculer le thème"
                    class="grid h-10 w-10 place-items-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:border-indigo-300 hover:text-indigo-600 dark:border-white/10 dark:bg-white/5 dark:text-slate-300 dark:hover:text-yellow-300">
                    <svg class="h-5 w-5 hidden dark:block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
                    <svg class="h-5 w-5 block dark:hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
                </button>

                @guest
                    <a href="{{ route('login') }}" class="hidden rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:text-slate-900 sm:block dark:text-slate-300 dark:hover:text-white">Se connecter</a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-primary hidden !px-4 !py-2.5 lg:inline-flex">Créer un compte</a>
                    @endif
                @endguest

                @auth
                <div class="hidden lg:block">
                    <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2.5 rounded-xl border border-slate-200 bg-white py-1.5 pl-1.5 pr-3 transition hover:border-indigo-300 hover:shadow-soft dark:border-white/10 dark:bg-white/5">
                            <span class="grid h-8 w-8 place-items-center rounded-lg bg-gradient-to-br from-indigo-500 to-violet-500 text-xs font-black text-white">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <span class="hidden text-sm font-semibold text-slate-700 sm:block dark:text-slate-200">{{ Str::limit(Auth::user()->name, 14) }}</span>
                            <svg class="h-4 w-4 fill-current text-slate-400" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="border-b border-slate-100 px-4 py-3 dark:border-white/10">
                            <p class="truncate text-sm font-bold text-slate-800 dark:text-slate-100">{{ Auth::user()->name }}</p>
                            <p class="truncate text-xs text-slate-500">{{ Auth::user()->email }}</p>
                        </div>
                        <x-dropdown-link :href="route('dashboard.index')">Tableau de bord</x-dropdown-link>
                        <x-dropdown-link :href="route('articles.index')">Voir le blog</x-dropdown-link>
                        <x-dropdown-link :href="route('profile.edit')">Profil</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Se déconnecter
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                    </x-dropdown>
                </div>
                @endauth

                <button @click="open = ! open" class="grid h-10 w-10 place-items-center rounded-xl border border-slate-200 text-slate-500 lg:hidden dark:border-white/10 dark:text-slate-300" aria-label="Menu">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/><path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-slate-200/70 lg:hidden dark:border-white/10">
        <div class="container-blog space-y-1 py-4">
            <x-responsive-nav-link :href="route('articles.index')" :active="request()->routeIs('articles.*')">Articles</x-responsive-nav-link>
            @auth
            <x-responsive-nav-link :href="route('dashboard.index')" :active="request()->routeIs('dashboard.*')">Tableau de bord</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('profile.edit')">Profil</x-responsive-nav-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Se déconnecter</x-responsive-nav-link>
            </form>
            @else
            <x-responsive-nav-link :href="route('login')">Se connecter</x-responsive-nav-link>
            @if (Route::has('register'))
            <x-responsive-nav-link :href="route('register')">Créer un compte</x-responsive-nav-link>
            @endif
            @endauth
        </div>
    </div>
</nav>
