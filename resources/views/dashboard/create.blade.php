@extends('layouts.app')

@section('title', 'Créer un article')

@section('content')
    <div class="max-w-3xl mx-auto">
        <a href="{{ route('dashboard.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 mb-6 inline-block">
            &larr; Retour au tableau de bord
        </a>

        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Créer un article</h1>

        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm p-8">
            <form method="POST" action="{{ route('dashboard.articles.store') }}">
                @csrf

                {{-- Titre --}}
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Titre <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="Titre de votre article"
                        class="w-full border rounded-lg px-3 py-2 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 dark:focus:ring-indigo-600
                            {{ $errors->has('title') ? 'border-red-400 bg-red-50 dark:bg-red-900/20' : 'border-gray-300 dark:border-gray-600' }}"
                        required
                    >
                    @error('title')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Catégorie --}}
                <div class="mb-6">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Catégorie <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="category_id"
                        name="category_id"
                        class="w-full border rounded-lg px-3 py-2 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-300 dark:focus:ring-indigo-600
                            {{ $errors->has('category_id') ? 'border-red-400 bg-red-50 dark:bg-red-900/20' : 'border-gray-300 dark:border-gray-600' }}"
                        required
                    >
                        <option value="">— Choisir une catégorie —</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Contenu --}}
                <div class="mb-6">
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Contenu <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        id="content"
                        name="content"
                        rows="16"
                        placeholder="Rédigez votre article ici..."
                        class="w-full border rounded-lg px-3 py-2 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 dark:focus:ring-indigo-600 resize-y
                            {{ $errors->has('content') ? 'border-red-400 bg-red-50 dark:bg-red-900/20' : 'border-gray-300 dark:border-gray-600' }}"
                        required
                    >{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Statut --}}
                <div class="mb-8">
                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Statut <span class="text-red-500">*</span>
                    </span>
                    <div class="flex gap-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input
                                type="radio"
                                name="status"
                                value="draft"
                                {{ old('status', 'draft') === 'draft' ? 'checked' : '' }}
                                class="text-indigo-600"
                            >
                            <span class="text-sm text-gray-700 dark:text-gray-300">Brouillon</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input
                                type="radio"
                                name="status"
                                value="published"
                                {{ old('status') === 'published' ? 'checked' : '' }}
                                class="text-indigo-600"
                            >
                            <span class="text-sm text-gray-700 dark:text-gray-300">Publier maintenant</span>
                        </label>
                    </div>
                    @error('status')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="flex gap-3">
                    <button
                        type="submit"
                        class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-indigo-700 transition text-sm"
                    >
                        Créer l'article
                    </button>
                    <a
                        href="{{ route('dashboard.index') }}"
                        class="border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 px-6 py-2.5 rounded-lg font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition text-sm"
                    >
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
