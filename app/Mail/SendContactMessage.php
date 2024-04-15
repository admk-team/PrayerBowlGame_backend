<?php

namespace App\Mail;

use App\Models\EmailSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\ContactMessage;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $contactMessage;

    public $message, $androidLink, $iosLink;

    /**
     * Create a new message instance.
     */
    public function __construct(ContactMessage $contactMessage)
    {
        $this->contactMessage = $contactMessage;

        $emailSettings = EmailSetting::first();

        if ($emailSettings != '') {
            $this->message = $emailSettings->message;
            $this->androidLink = $emailSettings->androidLink;
            $this->iosLink = $emailSettings->iosLink;
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Contact message from" . $this->contactMessage->first_name . " " . $this->contactMessage->first_name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.contact-message-mail',
            with: [
                'contactMessage' => $this->contactMessage,
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
