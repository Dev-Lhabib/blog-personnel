<x-guest-layout>
    <div class="mb-7">
        <h2 class="font-display text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Bon retour 👋</h2>
        <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">Connectez-vous pour écrire et gérer vos articles.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Adresse e-mail')" class="mb-1.5 !font-bold" />
            <x-text-input id="email" class="block w-full !rounded-xl !py-2.5" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="vous@exemple.fr" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="mb-1.5 flex items-center justify-between">
                <x-input-label for="password" :value="__('Mot de passe')" class="!font-bold" />
                @if (Route::has('password.request'))
                    <a class="text-[13px] font-semibold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400" href="{{ route('password.request') }}">
                        Mot de passe oublié ?
                    </a>
                @endif
            </div>
            <x-text-input id="password" class="block w-full !rounded-xl !py-2.5"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label for="remember_me" class="flex cursor-pointer items-center gap-2.5 text-sm text-slate-500 dark:text-slate-400">
            <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" name="remember">
            Se souvenir de moi
        </label>

        <x-primary-button class="w-full !py-3 !text-[15px]">
            {{ __('Se connecter') }}
        </x-primary-button>

        @if (Route::has('register'))
            <p class="text-center text-sm text-slate-500 dark:text-slate-400">
                Pas encore de compte ?
                <a class="font-bold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400" href="{{ route('register') }}">Créer un compte</a>
            </p>
        @endif
    </form>
</x-guest-layout>
