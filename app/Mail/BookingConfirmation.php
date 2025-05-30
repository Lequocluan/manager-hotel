<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    /**
     * Create a new message instance.
     */


    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        return $this->view('user.mail.booking_confirmation')
                    ->with([
                        'booking' => $this->booking
                    ]);
    }
}
