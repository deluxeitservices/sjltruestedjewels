@extends('layouts.app')
@section('title','Order Confirmation')
@section('content')
<div class="bg-white border rounded p-6">
  <h1 class="text-2xl font-semibold mb-2">Thank you!</h1>
  <p>Your order <strong>{{ $order->order_no }}</strong> has been {{ $order->status }}.</p>
  <p class="mt-2">Total paid: <strong>£{{ number_format($order->total_gbp,2) }}</strong></p>
  @if($order->paid_at)
    <p>Paid at: {{ $order->paid_at->format('d M Y H:i') }}</p>
  @endif
  <a href="{{ route('ext.catalog', ['category' => 'bullion']) }}" class="inline-block mt-4 px-4 py-2 bg-black text-white rounded">Continue shopping</a>
</div>
@endsection
