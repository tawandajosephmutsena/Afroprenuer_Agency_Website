<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::with(['author', 'category', 'featuredImage'])
            ->published()
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('articles.index', compact('articles'));
    }

    public function show(string $slug): View
    {
        $article = Article::where('slug', $slug)
            ->with(['author', 'category', 'featuredImage'])
            ->firstOrFail();

        $relatedArticles = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->published()
            ->latest()
            ->take(3)
            ->get();

        return view('articles.show', compact('article', 'relatedArticles'));
    }

    
}