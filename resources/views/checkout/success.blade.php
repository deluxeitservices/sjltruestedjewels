{{-- resources/views/checkout/success.blade.php --}}
@extends('layouts.app')
@section('title','Order confirmed')
@section('content')
<main class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
  <h1 class="text-2xl font-semibold mb-2">Thank you!</h1>
  <p class="mb-4">Your order <strong>{{ $order->order_no }}</strong> has been paid.</p>

  <div class="mb-6">
    <div class="flex justify-between"><span>Subtotal</span><strong>£{{ number_format($totals['subtotal'],2) }}</strong></div>
    <div class="flex justify-between"><span>VAT</span><strong>£{{ number_format($totals['vat'],2) }}</strong></div>
    <div class="flex justify-between text-lg"><span>Total</span><strong>£{{ number_format($totals['total'],2) }}</strong></div>
  </div>

  <h2 class="text-xl font-semibold mb-3">Items</h2>
  <div class="space-y-3">
    @foreach($order->items as $it)
      <div class="border rounded p-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
          @if($it->image_url)
            <img src="{{ $it->image_url }}" alt="" class="w-14 h-14 object-cover rounded">
          @endif
          <div>
            <div class="font-medium">{{ $it->title }}</div>
            <div class="text-xs text-neutral-600">
              Product ID: {{ $it->product_id ?? '—' }} |
              External ID: {{ $it->external_id ?? '—' }}
            </div>
            <div class="text-xs text-neutral-600">Qty: {{ $it->qty }}</div>
          </div>
        </div>
        <div class="text-right">
          <div>£{{ number_format($it->unit_gbp, 2) }} each</div>
          <div class="font-semibold">£{{ number_format($it->line_gbp, 2) }}</div>
        </div>
      </div>
    @endforeach
  </div>

  <a href="{{ route('ext.catalog') }}" class="common-primary-btn mt-6 inline-block">Continue shopping</a>
</main>
@endsection
