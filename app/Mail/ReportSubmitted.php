<?php

namespace App\Mail;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

// class ReportSubmitted extends Mailable
// {
//     use Queueable, SerializesModels;

//     public $report;

//     public function __construct(Report $report)
//     {
//         $this->report = $report;
//     }

//     public function build()
//     {

//         // return $this->subject('日報が提出されました')
//         //     ->markdown('emails.reports.submitted');

//         // return $this->from(config('mail.from.address'), config('mail.from.name'))
//         //     ->replyTo("fukuchen62@gmail.com", "name")
//         //     ->subject('【日報】' . $this->report->created_user_name)
//         //     ->markdown('emails.reports.submitted')  // ← これが正しい！
//         //     ->with(['report' => $this->report]);

//         // プレーンテキストメール（平文メール）で送信
//         return $this->from(config('mail.from.address'), config('mail.from.name'))
//             // ->replyTo("fukuchen62@gmail.com", "name")
//             ->subject($this->report->title . "：" .
//                 $this->report->created_user_name)
//             ->text('emails.reports.report-submitted')  // ★ プレーンテキスト
//             ->with(['report' => $this->report]);
//     }
// }

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

        return $this->subject("【QLIP Compass】" . $title . "：" . $userName)
            ->text('emails.reports.report-submitted')  // プレーンテキストビュー
            ->with(['report' => $this->report]);
    }
}
