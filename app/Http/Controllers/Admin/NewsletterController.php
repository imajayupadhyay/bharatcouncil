<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NewsletterController extends Controller
{
    public function index(Request $request)
    {
        $query = NewsletterSubscriber::latest();

        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        $subscribers = $query->paginate(20)->withQueryString();

        return Inertia::render('Admin/Newsletters', [
            'admin'       => Auth::guard('admin')->user(),
            'subscribers' => $subscribers,
            'filters'     => $request->only('source'),
            'total'       => NewsletterSubscriber::count(),
        ]);
    }
}
