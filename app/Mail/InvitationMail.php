<?php

namespace App\Mail;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Invitation $invitation,
        public string $link
    ) {}
    

    public function build()
    {
        return $this
            ->subject('Invitation to join a colocation')
            ->view('mail.invitation');
    }
}
