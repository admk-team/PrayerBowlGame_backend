<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use App\Models\EmailSetting;

class PrayerUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $senderName, $recieverName, $message, $androidLink, $iosLink, $banner, $content, $bannerUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($senderName, $recieverName, $banner, $content, $bannerUrl,$footertext)
    {
        $emailSettings = EmailSetting::first();

        if ($emailSettings != '') {
            $this->message = $footertext ?? $emailSettings->message;
            $this->androidLink = $emailSettings->androidLink;
            $this->iosLink = $emailSettings->iosLink;
        }
        $this->senderName = $senderName;
        $this->recieverName = $recieverName;
        $this->banner = $banner;
        $this->content = $content;
        $this->bannerUrl = $bannerUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('Someone is Praying for your right now'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.prayer-user-mail',
            with: [
                'senderName' => $this->senderName,
                'recieverName' => $this->recieverName,
                'banner' => $this->banner,
                'content' => $this->content,
                'bannerUrl' => $this->bannerUrl,
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
