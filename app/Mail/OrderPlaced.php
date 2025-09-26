<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf; // only if you attach a PDF

class OrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Order $order,
        public bool $toAdmin = false,
        public bool $attachPdf = false,
        public ?string $declarationUrl = null
    ) {}

    public function build()
    {
        $subject = $this->toAdmin
            ? 'New Order: #' . $this->order->order_no
            : 'Your Order Confirmation #' . $this->order->order_no;

        $mail = $this->subject($subject)
            ->view('pages.orders.placed')
            ->with([
                'order'    => $this->order->loadMissing('items', 'user'),
                'toAdmin'  => $this->toAdmin,
                'appName'  => config('app.name'),
                'declarationUrl' => $this->declarationUrl,

            ]);

        // (Optional) attach PDF of the order
        if ($this->attachPdf) {
            $pdf = Pdf::loadView('pages.orders.pdf', ['order' => $this->order->loadMissing('items', 'user')])
                      ->setPaper('a4')
                      ->output();
            $mail->attachData($pdf, 'order-'.$this->order->order_no.'.pdf', [
                'mime' => 'application/pdf'
            ]);
        }

        return $mail;
    }
}
