<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;

class StripeWebhookController extends Controller
{
    public function handle(Request $request){
        $sig = $request->header('Stripe-Signature');
        $secret = env('STRIPE_WEBHOOK_SECRET');
        try {
            $event = \Stripe\Webhook::constructEvent($request->getContent(), $sig, $secret);
        } catch (\Throwable $e) {
            return response('Invalid', 400);
        }
        if ($event->type==='checkout.session.completed'){
            $s=$event->data->object; $orderId=$s->metadata->order_id ?? null;
            if($orderId){ $o=Order::find($orderId); if($o && $o->status!=='paid'){ $o->status='paid'; $o->paid_at=now(); $o->save(); } }
        }
        return response('OK',200);
    }
}
