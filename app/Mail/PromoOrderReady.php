<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\PromoOrder;
use Illuminate\Contracts\Queue\ShouldQueue;

class PromoOrderReady extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(PromoOrder $order)
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
                ->view('emails.orders.promoready')
                ->subject('Uw bestelling is klaar')
                ->with(['order' => $this->order]);
    }
}
