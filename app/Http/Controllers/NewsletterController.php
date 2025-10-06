<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required','email','max:255']
        ]);

        DB::table('newsletter_subscribers')->insert(
            [
                'email' => strtolower($validated['email']),
                'ip_address' => $request->ip(),
                'user_agent' => (string) $request->userAgent(),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
        return response()->json(['message' => 'Subscribed'], 200);
    }
}
