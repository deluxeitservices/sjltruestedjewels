{{-- resources/views/checkout/show.blade.php --}}
@extends('layouts.app')
@section('title','Checkout')
@section('content')
<main>
<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
  <h1 class="text-2xl font-semibold mb-4">Checkout</h1>

  <div class="mb-4">
    <div class="flex justify-between">
      <span>Subtotal</span>
      <strong>£{{ number_format($totals['subtotal'],2) }}</strong>
    </div>
    <div class="flex justify-between">
      <span>VAT</span>
      <strong>£{{ number_format($totals['vat'],2) }}</strong>
    </div>
    <div class="flex justify-between text-lg">
      <span>Total</span>
      <strong>£{{ number_format($totals['total'],2) }}</strong>
    </div>
  </div>

  {{-- Payment Element --}}
  <form id="payment-form">
    <div id="payment-element" class="mb-4"></div>
    <button id="submit" class="common-primary-btn">Pay now</button>
    <div id="error-message" class="text-red-600 mt-2"></div>
  </form>
</div>
</main>
@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
const stripe = Stripe("{{ $publishableKey }}");
const options = {
  clientSecret: "{{ $clientSecret }}",
  appearance: { theme: 'stripe' }
};
const elements = stripe.elements(options);
const paymentElement = elements.create('payment');
paymentElement.mount('#payment-element');

document.getElementById('payment-form').addEventListener('submit', async (e) => {
  e.preventDefault();
  const {error} = await stripe.confirmPayment({
    elements,
    confirmParams: {
      return_url: "{{ route('checkout.success') }}",
    },
  });
  if (error) {
    document.getElementById('error-message').textContent = error.message || 'Payment failed.';
  }
});
</script>
@endpush
@endsection
