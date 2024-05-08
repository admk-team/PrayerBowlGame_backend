<?php

namespace App\Mail;

use App\Models\EmailSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminDonationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public  $message, $androidLink, $iosLink, $data, $doner_data ,$amount;

    /**
     * Create a new message instance.
     */
    public function __construct($data,$doner_data ,$amount)
    {
        $emailSettings = EmailSetting::first();

        if ($emailSettings != '') {
            $this->message = $emailSettings->message;
            $this->androidLink = $emailSettings->androidLink;
            $this->iosLink = $emailSettings->iosLink;
        }
        $this->data = $data;
        $this->doner_data = $doner_data;
        $this->amount = $amount;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // subject: 'Donation Confirmation: ' . $this->doner_data->name . ' Contribution to Prayer Bowl',
            subject: __('Donation Confirmation Contribution to Prayer Bowl', ['name' => $this->doner_data->supporter_name])
        );
    }


    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.admin_donation_email',
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
