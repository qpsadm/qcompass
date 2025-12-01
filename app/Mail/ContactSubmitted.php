<?php

namespace App\Mail;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $report;

    public function __construct(Contact $contact)
    {
        $this->report = $contact;
    }

    public function build()
    {
        return $this->subject('問い合わせが提出されました')
            ->markdown('emails.reports.submitted');
    }
}