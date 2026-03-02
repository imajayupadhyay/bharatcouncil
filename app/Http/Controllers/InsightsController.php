<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InsightsController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::with('category')
            ->published()
            ->orderByDesc('published_at');

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        $posts = $query->paginate(12)->withQueryString();

        // Featured post: latest featured published post (excluded from main listing)
        $featuredPost = BlogPost::with('category')
            ->published()
            ->featured()
            ->orderByDesc('published_at')
            ->first();

        $categories = BlogCategory::withCount(['posts' => fn ($q) => $q->where('status', 'published')])
            ->having('posts_count', '>', 0)
            ->orderBy('name')
            ->get();

        $totalArticles = BlogPost::published()->count();
        $totalAuthors = BlogPost::published()->distinct('author_name')->count('author_name');
        $totalCategories = $categories->count();

        return Inertia::render('Insights/Index', [
            'posts'          => $posts,
            'featuredPost'   => $featuredPost,
            'categories'     => $categories,
            'filters'        => $request->only('category'),
            'stats'          => [
                'articles'   => $totalArticles,
                'authors'    => $totalAuthors,
                'topics'     => $totalCategories,
            ],
        ]);
    }

    public function show(string $slug)
    {
        $post = BlogPost::with('category')
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Related articles: same category, excluding current, limit 3
        $relatedPosts = BlogPost::with('category')
            ->published()
            ->where('blog_category_id', $post->blog_category_id)
            ->where('id', '!=', $post->id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        // If not enough related posts from same category, fill from other categories
        if ($relatedPosts->count() < 3) {
            $remaining = 3 - $relatedPosts->count();
            $extraPosts = BlogPost::with('category')
                ->published()
                ->where('id', '!=', $post->id)
                ->whereNotIn('id', $relatedPosts->pluck('id'))
                ->orderByDesc('published_at')
                ->limit($remaining)
                ->get();
            $relatedPosts = $relatedPosts->concat($extraPosts);
        }

        return Inertia::render('Insights/Show', [
            'post'         => $post,
            'relatedPosts' => $relatedPosts,
        ]);
    }
}
