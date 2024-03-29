<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Jobs\Middleware\LimitMailJob;
use App\Mail\PrayerUserMail;
use App\Mail\TestMail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $recieverEmail, $senderName;

    /**
     * Create a new job instance.
     */
    public function __construct($recieverEmail, $senderName)
    {
        $this->recieverEmail = $recieverEmail;
        $this->senderName = $senderName;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Mail::to($this->recieverEmail)->send(new TestMail($this->senderName));
    }

    /**
     * Get the middleware the job should pass through.
     *
     * @return array<int, object>
     */
    public function middleware(): array
    {
        return [
            new \Illuminate\Queue\Middleware\RateLimitedWithRedis(rand()),
        ];
    }
}
