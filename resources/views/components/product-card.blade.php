@props(['product'])
@php $p = $product; @endphp
<article class="border rounded-xl bg-white shadow-sm overflow-hidden group">
  <a href="{{ route('product.show',$p->slug) }}" class="block">
    <img src="{{ $p->image_url ?: asset('assets/images/placeholder-bar.svg') }}"
         alt="{{ $p->title }}" class="w-full h-48 object-contain p-4">
  </a>
  <div class="p-4">
    <h3 class="font-medium text-lg"><a href="{{ route('product.show',$p->slug) }}">{{ $p->title }}</a></h3>
    <div class="text-sm text-neutral-600">
      {{ $p->metal }} · {{ number_format($p->weight_g,3) }} g · {{ $p->brand ?: '—' }}
      @if($p->vat_exempt) <span class="ml-2 inline-flex items-center text-green-600">VAT-free</span> @endif
    </div>
    <div class="mt-3 flex items-center justify-between">
      <div class="text-xl font-semibold">
        £<span class="js-price" data-id="{{ $p->id }}">{{ number_format($p->live_price ?? 0, 2) }}</span>
      </div>
      <form action="{{ route('cart.add') }}" method="post" class="flex items-center gap-2">
        @csrf
        <input type="hidden" name="product_id" value="{{ $p->id }}">
        <input type="number" name="qty" value="1" min="1" class="border px-2 w-16">
        <button class="px-3 py-2 text-sm bg-black text-white rounded">Add</button>
      </form>
    </div>
  </div>
</article>
