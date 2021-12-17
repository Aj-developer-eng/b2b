<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class acceptmailtolead extends Mailable
{
    use Queueable, SerializesModels;
public  $accepted;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($accepted)
    {
       $this->accepted = $accepted;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         return $this->subject('Mail From Mahatat Al Alam')
            ->view('template.frontend.userdashboard.employeepanel.email.acceptmail');
    }
}
