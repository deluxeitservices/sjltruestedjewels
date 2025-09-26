<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $toAdmin;

    public function __construct(User $user, $toAdmin = false)
    {
        $this->user = $user;
        $this->toAdmin = $toAdmin;
    }

    public function build()
    {
        $subject = $this->toAdmin
            ? 'New User Registered'
            : 'Welcome to Our Platform';
        $baseLoginUrl = route('login');                // absolute, uses APP_URL
        $loginUrl = $baseLoginUrl;
        return $this->subject($subject)
            ->view('emails.user_registered')
            ->with([
                'user'      => $this->user,
                'toAdmin'   => $this->toAdmin,
                'loginUrl'  => $loginUrl,
                'appName'   => config('app.name'),
                'supportEmail' => config('mail.from.address'),
            ]);;
    }
}
