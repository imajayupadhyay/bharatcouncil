<?php

use App\Http\Controllers\MemberApplicationController;
use App\Http\Controllers\NewsletterController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home/Index');
});

Route::get('/insights', function () {
    return Inertia::render('Insights/Index');
});

Route::get('/insights/{slug}', function (string $slug) {
    return Inertia::render('Insights/Show', ['slug' => $slug]);
});

Route::get('/work-with-us', function () {
    return Inertia::render('WorkWithUs/Index');
});
Route::post('/work-with-us/apply', [MemberApplicationController::class, 'store'])->name('application.store');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

Route::get('/who-we-are', function () {
    return Inertia::render('WhoWeAre/Index');
});

Route::get('/governing-board', function () {
    return Inertia::render('GoverningBoard/Index');
});
