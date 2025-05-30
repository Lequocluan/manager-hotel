<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class AdminResetPasswordMail extends Mailable 
{
    use Queueable, SerializesModels;

    public $url;
    /**
     * Create a new message instance.
     */

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function build()
    {
        return $this->subject('Yêu cầu đặt lại mật khẩu')
                    ->view('admin.mail.reset_password');
    }
}
