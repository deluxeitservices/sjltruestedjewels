@extends('layouts.app')
@section('title',$product->title)
@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
  <img src="{{ $product->image_url ?: asset('assets/images/placeholder-bar.svg') }}" class="w-full h-auto object-contain bg-white rounded-xl p-6">
  <div>
    <h1 class="text-2xl font-semibold">{{ $product->title }}</h1>
    <p class="text-neutral-600 mt-1">{{ $product->metal }} · {{ number_format($product->weight_g,3) }} g · {{ $product->brand ?: '—' }}</p>
    <p class="mt-4 text-3xl font-bold">£<span id="livePrice">{{ number_format($price ?? 0,2) }}</span></p>
    <form action="{{ route('cart.add') }}" method="post" class="mt-4 flex gap-2">
      @csrf
      <input type="hidden" name="product_id" value="{{ $product->id }}">
      <input type="number" name="qty" value="1" min="1" class="border px-2 w-16">
      <button class="bg-black text-white px-5 py-3 rounded">Add to cart</button>
    </form>
    <div class="mt-6 prose max-w-none">{!! nl2br(e($product->description)) !!}</div>
  </div>
</div>

@push('scripts')
<script>
async function refreshPrice(){
  try{
    const r=await fetch('/api/products/{{ $product->id }}'+'/price',{cache:'no-store'});
    const j=await r.json();
    document.getElementById('livePrice').textContent = (j.price_gbp||0).toFixed(2);
  }catch(e){}
}
refreshPrice(); setInterval(refreshPrice, 30000);
</script>
@endpush
@endsection
