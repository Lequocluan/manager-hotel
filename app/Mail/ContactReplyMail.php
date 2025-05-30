<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $messageContent;

    public function __construct($contact, $messageContent)
    {
        $this->contact = $contact;
        $this->messageContent = $messageContent;
    }

    public function build()
    {
        return $this->subject('Phản hồi về: ' . ($this->contact->subject ?? 'liên hệ của bạn'))
                    ->view('admin.mail.reply')
                    ->with([
                        'contact' => $this->contact,
                        'messageContent' => $this->messageContent,
                    ]);
    }
}
