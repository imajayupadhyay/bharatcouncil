<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email'  => 'required|email|max:255',
            'source' => 'nullable|in:homepage,footer',
        ]);

        $email  = strtolower(trim($request->email));
        $source = $request->source ?? 'homepage';

        // Silently succeed for already-subscribed emails (no error shown to user)
        if (!NewsletterSubscriber::where('email', $email)->exists()) {
            NewsletterSubscriber::create(['email' => $email, 'source' => $source]);
        }

        return response()->json(['success' => true]);
    }
}
