<?php

namespace App\Mail;

use App\Models\Report;  // ← これが正しい
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $report;

    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    public function build()
    {
        return $this->subject('日報が提出されました')
            ->markdown('emails.reports.submitted');
    }
}
