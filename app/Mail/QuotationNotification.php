<?php

namespace App\Mail;

use App\Models\Quotation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuotationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $quotation;

    public function __construct(Quotation $quotation)
    {
        
        $this->quotation = $quotation;
    }

    public function build()
    {
        return $this->subject('แจ้งเตือนใบเสนอราคาใหม่ #' . $this->quotation->quotation_number)
                    ->view('emails.quotation_notification'); 
    }
}