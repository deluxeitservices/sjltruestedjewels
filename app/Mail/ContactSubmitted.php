<?php

namespace App\Mail;

use App\Models\SjlContact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public SjlContact $contact, public bool $toAdmin = false) {}

    public function build()
    {
        $subject = $this->toAdmin ? 'New contact form submission'
                                  : 'We received your message';

        return $this->subject($subject)
            ->view('emails.contact.generic') // <- plain Blade view
            ->with([
                'c'       => $this->contact,
                'toAdmin' => $this->toAdmin,
                'appName' => config('app.name'),
            ]);
    }
}
