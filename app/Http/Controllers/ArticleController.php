<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // GET /api/articles
    public function index()
    {
        $articles = Article::select('id', 'title', 'created_at')
            ->orderByDesc('created_at')
            ->get();

        return response()->json($articles);
    }

    // GET /api/articles/{id}
    public function show($id)
    {
        $article = Article::with('comments')->find($id);

        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        }

        return response()->json($article);
    }

    // POST /api/articles
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $article = Article::create($validated);

        return response()->json($article, 201);
    }
}
