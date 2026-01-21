<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaseReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    public $renter;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details, $renter)
    {
        $this->details = $details;
        $this->renter = $renter;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Lease Report Submitted')
                    ->view('emails.lease_report');
    }
}
