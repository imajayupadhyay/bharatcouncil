<?php

namespace App\Providers;

use App\Models\FooterSection;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Inertia::share('footer', function () {
            return FooterSection::all()->keyBy('section')->map->data;
        });
    }
}
