<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\BeursOrder;
use Illuminate\Contracts\Queue\ShouldQueue;

class BeursOrderReady extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(BeursOrder $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('marketing@konvert.be')
                ->view('emails.orders.kantoorready')
                ->subject('Uw bestelling is klaar')
                ->with(['order' => $this->order]);
    }
}
