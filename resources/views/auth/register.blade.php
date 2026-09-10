<x-guest-layout>
    <div class="mb-7">
        <h2 class="font-display text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Créer un compte ✨</h2>
        <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">Rejoignez le blog et publiez votre premier guide.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nom complet')" class="mb-1.5 !font-bold" />
            <x-text-input id="name" class="block w-full !rounded-xl !py-2.5" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Votre nom" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Adresse e-mail')" class="mb-1.5 !font-bold" />
            <x-text-input id="email" class="block w-full !rounded-xl !py-2.5" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="vous@exemple.fr" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="password" :value="__('Mot de passe')" class="mb-1.5 !font-bold" />
                <x-text-input id="password" class="block w-full !rounded-xl !py-2.5"
                                type="password"
                                name="password"
                                required autocomplete="new-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirmation')" class="mb-1.5 !font-bold" />
                <x-text-input id="password_confirmation" class="block w-full !rounded-xl !py-2.5"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <x-primary-button class="w-full !py-3 !text-[15px]">
            {{ __('Créer mon compte') }}
        </x-primary-button>

        <p class="text-center text-sm text-slate-500 dark:text-slate-400">
            Déjà inscrit ?
            <a class="font-bold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400" href="{{ route('login') }}">Se connecter</a>
        </p>
    </form>
</x-guest-layout>
