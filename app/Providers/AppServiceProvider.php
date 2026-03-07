<?php

namespace App\Providers;

use App\Models\FooterSection;
use App\Models\HeaderSection;
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

        Inertia::share('header', function () {
            return HeaderSection::all()->keyBy('section')->map->data;
        });
    }
}
