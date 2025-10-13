<?php
namespace App\Http\Controllers;

use App\Models\SjlContact;
use Illuminate\Http\Request;
use App\Mail\ContactSubmitted;
use Illuminate\Support\Facades\Mail;

class SjlContactController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required','string','max:255'],
            'mobile'  => ['nullable','string','max:30'],
            'email'   => ['required','email','max:255'],
            'message' => ['nullable','string','max:5000'],
        ]);

        // Save and keep the created record
        $contact = SjlContact::create([
            ...$data,
            'ip'         => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ]);

        // Send emails (one file, condition flag)
        $adminEmail = env('MAIL_ADMIN_ADDRESS', config('mail.from.address'));
        Mail::to($contact->email)->send(new ContactSubmitted($contact, toAdmin: false));
        Mail::to($adminEmail)->send(new ContactSubmitted($contact, toAdmin: true));

        return redirect()->to(url()->previous() . '#contact')
            ->with('status', 'Thanks! Your message has been sent. Will contact you soon!');
    }
}

