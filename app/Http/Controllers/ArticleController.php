<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::withCount([
            'articles' => fn ($q) => $q->where('status', 'published'),
            // $q mean: Query Builder
            // fn means: function صغيرة كتتبعث لـ Laravel باش تعدل Query
            // used with: whereHas(), with(), withCount(), filter()
            // function ($q) {
            //     return $q->where('status', 'published');
            // }
        ])->get();

        $query = Article::with(['category', 'user'])
            ->published()
            ->latest('published_at');

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $articles       = $query->paginate(6)->withQueryString();
        $activeCategory = $request->category;

        return view('articles.index', compact('articles', 'categories', 'activeCategory'));
    }

    public function show(Article $article): View
    {
        if ($article->status !== 'published') {
            abort(404);
        }

        return view('articles.show', compact('article'));
    }
}
