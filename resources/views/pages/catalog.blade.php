@extends('layouts.app')
@section('title','Catalogue')
@section('content')
  <h1 class="text-2xl font-semibold mb-4">Catalogue</h1>
  @php $tabs=['XAU'=>'Gold','XAG'=>'Silver','XPT'=>'Platinum','XPD'=>'Palladium']; @endphp
  <div class="mb-4 flex gap-2">
    @foreach($tabs as $code=>$name)
      <a href="{{ url('/metal/'.$code) }}" class="px-3 py-1 rounded border {{ $metal === $code ? 'bg-black text-white':'bg-white' }}">{{ $name }}</a>
    @endforeach
  </div>
  <form class="mb-6 grid grid-cols-1 md:grid-cols-5 gap-3" method="get">
    <select class="border p-2" name="type">
      <option value="">Type (all)</option>
      <option value="bar" {{ request('type')==='bar'?'selected':'' }}>Bar</option>
      <option value="coin" {{ request('type')==='coin'?'selected':'' }}>Coin</option>
    </select>
    <input class="border p-2" name="brand[]" placeholder="Brand" value="{{ request('brand.0') }}">
    <input class="border p-2" type="number" step="0.001" name="min_g" placeholder="Min g" value="{{ request('min_g') }}">
    <input class="border p-2" type="number" step="0.001" name="max_g" placeholder="Max g" value="{{ request('max_g') }}">
    <button class="border p-2 bg-black text-white" type="submit">Apply</button>
  </form>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($products as $p)
      <x-product-card :product="$p" />
    @endforeach
  </div>
  <div class="mt-6">{{ $products->withQueryString()->links() }}</div>

@push('scripts')
<script>
async function refreshGridPrices(){
  try{
    const nodes = document.querySelectorAll('.js-price');
    for (const el of nodes){
      const id = el.getAttribute('data-id');
      const r = await fetch('/api/products/'+id+'/price',{cache:'no-store'});
      const j = await r.json();
      if (j.price_gbp!=null) el.textContent = Number(j.price_gbp).toFixed(2);
    }
  }catch(e){}
}
refreshGridPrices(); setInterval(refreshGridPrices, 30000);
</script>
@endpush
@endsection
