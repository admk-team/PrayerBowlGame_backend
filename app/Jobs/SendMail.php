<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\PrayerUserMail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $recieverEmail, $senderName;

    /**
     * Create a new job instance.
     */
    public function __construct($recieverEmail, $senderName)
    {
        $this->$recieverEmail = $recieverEmail;
        $this->$senderName = $senderName;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->recieverEmail)->send(new PrayerUserMail($this->senderName));
    }
}
