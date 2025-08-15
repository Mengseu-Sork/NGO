<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Form2ReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $formLink;

    public function __construct($user, $formLink)
    {
        $this->user = $user;
        $this->formLink = $formLink;
    }

    public function build()
    {
        return $this->subject('Reminder: Please Complete Your Membership Form (Phase 2)')
                    ->markdown('emails.form2_reminder')
                    ->with([
                        'formLink' => $this->formLink
                    ]);
    }
}