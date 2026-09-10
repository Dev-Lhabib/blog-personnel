@extends('layouts.app')

@section('title', 'Modifier : ' . $article->title)

@section('content')
    <div class="container-blog max-w-3xl py-10">
        <a href="{{ route('dashboard.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-indigo-600 transition hover:gap-2.5 dark:text-indigo-400">
            &larr; Retour au tableau de bord
        </a>

        <div class="mt-4">
            <p class="eyebrow">Édition</p>
            <h1 class="font-display mt-3 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl dark:text-white">Modifier l'article</h1>
            <p class="mt-2 truncate text-slate-500 dark:text-slate-400">{{ $article->title }}</p>
        </div>

        <div class="card-blog mt-7 p-6 sm:p-9">
            <form method="POST" action="{{ route('dashboard.articles.update', $article) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="title" class="mb-1.5 block text-sm font-bold text-slate-700 dark:text-slate-200">Titre <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title', $article->title) }}"
                        class="input-blog {{ $errors->has('title') ? '!border-red-400' : '' }}" required>
                    @error('title')<p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="mb-6 grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="category_id" class="mb-1.5 block text-sm font-bold text-slate-700 dark:text-slate-200">Catégorie <span class="text-red-500">*</span></label>
                        <select id="category_id" name="category_id" class="input-blog {{ $errors->has('category_id') ? '!border-red-400' : '' }}" required>
                            <option value="">— Choisir une catégorie —</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        @if($article->image)
                            <img src="{{ \Illuminate\Support\Str::startsWith($article->image, ['http://','https://']) ? $article->image : asset('storage/' . $article->image) }}" alt="" class="mb-3 max-h-44 w-full rounded-xl border border-slate-200 object-cover dark:border-white/10">
                        @endif
                        <label for="image" class="mb-1.5 block text-sm font-bold text-slate-700 dark:text-slate-200">{{ $article->image ? "Remplacer l'image" : 'Image de couverture' }}</label>
                        <input type="file" id="image" name="image" accept="image/*" onchange="previewCover(this)"
                            class="w-full rounded-xl border border-dashed border-slate-300 bg-slate-50/50 px-3 py-2.5 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-sm file:font-bold file:text-white hover:file:bg-indigo-700 dark:border-white/15 dark:bg-white/5">
                        <p class="mt-1 text-xs text-slate-400">JPG, PNG ou WebP — max 2 Mo</p>
                        @error('image')<p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                        <img id="cover-preview" alt="" class="mt-3 hidden max-h-44 w-full rounded-xl border border-slate-200 object-cover dark:border-white/10">
                    </div>
                </div>

                <div class="mb-6">
                    <label for="content" class="mb-1.5 block text-sm font-bold text-slate-700 dark:text-slate-200">Contenu <span class="text-red-500">*</span></label>
                    <textarea id="content" name="content" rows="16" class="input-blog resize-y leading-relaxed {{ $errors->has('content') ? '!border-red-400' : '' }}" required>{{ old('content', $article->content) }}</textarea>
                    @error('content')<p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="mb-8 rounded-2xl border border-slate-200 bg-slate-50/60 p-4 dark:border-white/10 dark:bg-white/[0.03]">
                    <span class="block text-sm font-bold text-slate-700 dark:text-slate-200">Statut</span>
                    <div class="mt-3 grid gap-3 sm:grid-cols-2">
                        <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 bg-white p-3.5 transition has-[:checked]:border-indigo-500 has-[:checked]:ring-4 has-[:checked]:ring-indigo-500/15 dark:border-white/10 dark:bg-white/5">
                            <input type="radio" name="status" value="draft" {{ old('status', $article->status) === 'draft' ? 'checked' : '' }} class="h-4 w-4 text-indigo-600">
                            <span><span class="block text-sm font-bold">Brouillon</span><span class="block text-xs text-slate-400">Masqué du blog</span></span>
                        </label>
                        <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 bg-white p-3.5 transition has-[:checked]:border-indigo-500 has-[:checked]:ring-4 has-[:checked]:ring-indigo-500/15 dark:border-white/10 dark:bg-white/5">
                            <input type="radio" name="status" value="published" {{ old('status', $article->status) === 'published' ? 'checked' : '' }} class="h-4 w-4 text-indigo-600">
                            <span><span class="block text-sm font-bold">Publié</span><span class="block text-xs text-slate-400">Visible par tous</span></span>
                        </label>
                    </div>
                    @error('status')<p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="flex flex-col-reverse gap-3 sm:flex-row">
                    <a href="{{ route('dashboard.index') }}" class="btn-ghost flex-1">Annuler</a>
                    <button type="submit" class="btn-primary flex-1">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewCover(input) {
            const img = document.getElementById('cover-preview');
            if (input.files && input.files[0]) {
                img.src = URL.createObjectURL(input.files[0]);
                img.classList.remove('hidden');
            }
        }
    </script>
    @endpush
@endsection
