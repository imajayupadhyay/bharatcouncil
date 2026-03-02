<?php

use App\Http\Controllers\InsightsController;
use App\Http\Controllers\InternApplicationController;
use App\Http\Controllers\MemberApplicationController;
use App\Http\Controllers\NewsletterController;
use App\Models\BlogPost;
use App\Models\HomepageSection;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    $sections = HomepageSection::all()->keyBy('section')->map->data;

    // Featured blog posts for the Featured section
    $featuredBlogPost = BlogPost::with('category')
        ->published()
        ->featured()
        ->orderByDesc('published_at')
        ->first();

    $latestPosts = BlogPost::with('category')
        ->published()
        ->when($featuredBlogPost, fn ($q) => $q->where('id', '!=', $featuredBlogPost->id))
        ->orderByDesc('published_at')
        ->limit(3)
        ->get();

    return Inertia::render('Home/Index', [
        'sections'         => $sections,
        'featuredBlogPost' => $featuredBlogPost,
        'latestPosts'      => $latestPosts,
    ]);
});

Route::get('/insights', [InsightsController::class, 'index'])->name('insights.index');
Route::get('/insights/{slug}', [InsightsController::class, 'show'])->name('insights.show');

Route::get('/work-with-us', function () {
    return Inertia::render('WorkWithUs/Index');
});
Route::post('/work-with-us/apply', [MemberApplicationController::class, 'store'])->name('application.store');
Route::post('/work-with-us/intern-apply', [InternApplicationController::class, 'store'])->name('intern-application.store');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

Route::get('/who-we-are', function () {
    return Inertia::render('WhoWeAre/Index');
});

Route::get('/governing-board', function () {
    return Inertia::render('GoverningBoard/Index');
});
