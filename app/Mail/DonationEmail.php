<?php

namespace App\Mail;

use App\Models\EmailSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DonationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public  $message, $androidLink, $iosLink, $data,$amount;

    /**
     * Create a new message instance.
     */
    public function __construct($data,$amount,$footertext)
    {
        $emailSettings = EmailSetting::first();

        if ($emailSettings != '') {
            $this->message = $footertext ?? $emailSettings->message;
            $this->androidLink = $emailSettings->androidLink;
            $this->iosLink = $emailSettings->iosLink;
        }
        $this->data = $data;
        $this->amount = $amount;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('Donation Confirmation: Prayer Bowl App'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.donation_email',
            with: [
                'data' => $this->data,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
