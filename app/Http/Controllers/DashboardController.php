<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $articles = Article::with('category')
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
            'image'       => ['nullable', 'image', 'max:2048'],
        ]);

        $data['user_id']      = Auth::id();
        $data['slug']         = Str::slug($data['title']) . '-' . uniqid();
        $data['published_at'] = $data['status'] === 'published' ? now() : null;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        Article::create($data);

        return redirect()->route('dashboard.index')
            ->with('success', 'Article créé avec succès.');
    }

    public function edit(Article $article): View
    {
        $categories = Category::orderBy('name')->get();

        return view('dashboard.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'content'     => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'status'      => ['required', 'in:draft,published'],
            'image'       => ['nullable', 'image', 'max:2048'],
        ]);

        if ($data['status'] === 'published' && $article->status !== 'published') {
            $data['published_at'] = now();
        } elseif ($data['status'] === 'draft') {
            $data['published_at'] = null;
        }

        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($data);

        return redirect()->route('dashboard.index')
            ->with('success', 'Article mis à jour.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return redirect()->route('dashboard.index')
            ->with('success', 'Article supprimé.');
    }
}
