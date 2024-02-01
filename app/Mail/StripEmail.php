<?php

// app/Mail/StripEmail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StripEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $donation;

    /**
     * Create a new message instance.
     *
     * @param $donation
     */
    public function __construct($donation)
    {
        $this->donation = $donation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.thank_you')
                    ->subject('Thank You for Your Donation');
    }
}
