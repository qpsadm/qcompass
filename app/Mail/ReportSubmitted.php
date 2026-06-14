<?php

namespace App\Mail;

use App\Models\Report;
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
        // タイトルや名前が万が一空だったときのために、初期値を担保する
        $title = $this->report->title ?? '日報提出';
        $userName = $this->report->created_user_name ?? '受講生';

        return $this->subject($title . " 【" . $userName . "】")
            ->text('emails.reports.report-submitted')
            ->with(['report' => $this->report]);
    }
}
