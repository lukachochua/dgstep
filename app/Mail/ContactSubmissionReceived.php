<?php

namespace App\Mail;

use App\Models\ContactSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactSubmissionReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactSubmission $submission) {}

    public function build()
    {
        return $this->subject('New Contact Submission — '.$this->submission->name.' '.$this->submission->surname)
            ->view('emails.contact.received');
    }
}

