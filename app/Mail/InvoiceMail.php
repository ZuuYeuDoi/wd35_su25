<?php

namespace App\Mail;

use App\Models\Bill;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $bill;
    public $booking;

    public function __construct(Bill $bill, Booking $booking)
    {
        $this->bill = $bill;
        $this->booking = $booking;
    }

    public function build()
    {
        return $this->subject('Hóa đơn đặt phòng #' . $this->booking->booking_code)
                    ->markdown('emails.invoice');
    }
}
