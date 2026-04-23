<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $articles = Article::with('category')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('dashboard.index', compact('articles'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('dashboard.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'content'     => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'status'      => ['required', 'in:draft,published'],
        ]);

        $data['user_id']      = Auth::id();
        $data['slug']         = Str::slug($data['title']) . '-' . uniqid();
        $data['published_at'] = $data['status'] === 'published' ? now() : null;

        Article::create($data);

        return redirect()->route('dashboard.index')
            ->with('success', 'Article créé avec succès.');
    }

    public function edit(Article $article): View
    {
        $this->authorizeArticle($article);

        $categories = Category::orderBy('name')->get();

        return view('dashboard.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $this->authorizeArticle($article);

        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'content'     => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'status'      => ['required', 'in:draft,published'],
        ]);

        if ($data['status'] === 'published' && $article->status !== 'published') {
            $data['published_at'] = now();
        } elseif ($data['status'] === 'draft') {
            $data['published_at'] = null;
        }

        $article->update($data);

        return redirect()->route('dashboard.index')
            ->with('success', 'Article mis à jour.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $this->authorizeArticle($article);

        $article->delete();

        return redirect()->route('dashboard.index')
            ->with('success', 'Article supprimé.');
    }

    private function authorizeArticle(Article $article): void
    {
        if ($article->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
