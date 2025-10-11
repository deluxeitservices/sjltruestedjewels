@props(['metal'=>'XAU'])
<!-- 
<div id="priceTicker" class="w-full text-sm bg-amber-50 border border-amber-200 py-2 px-3 rounded mb-4">
  <span>Live <strong>{{ $metal }}</strong> (GBP/g): </span>
  <strong id="xMetG">…</strong>
  <span class="opacity-70"> · Updated: <span id="xAsOf">—</span></span>
</div>
 -->
<ul class="top-header-content static-top-header">
  <li>
    <div class="pric-box">
      <a href="{{ url('/') }}">
        <span><img src="{{ asset('./assets/image/gol-header.svg') }}" class="header-logo"></span>
        <span class="metal-name">Gold</span>
      </a>
    </div>
    <div class="pric-box">
      <span class="price xau-oz">£—</span>
      <span class="weight-text">o/z</span>
    </div>
    <span class="border-right-header"></span>
    <p class="price-going">
      <span class="price xau-g">£—</span>
      <span class="weight-text">gm</span>
    </p>
  </li>

  <li>
    <div class="pric-box">
      <a href="#">
        <span><img src="{{ asset('./assets/image/silver-header.svg')}}"></span>
        <span class="metal-name">Silver</span>
      </a>
    </div>
    <div class="pric-box">
      <span class="price xag-oz" >£—</span>
      <span class="weight-text">o/z</span>
    </div>
    <span class="border-right-header"></span>
    <p class="price-going">
      <span class="price xag-g">£—</span>
      <span class="weight-text">gm</span>
    </p>
  </li>
</ul>

@push('scripts')
<script>
(function(){
  const OZT_PER_G = 31.1034768;
  const fmtGBP = new Intl.NumberFormat('en-GB', {
    style: 'currency', currency: 'GBP', minimumFractionDigits: 2, maximumFractionDigits: 2
  });

  // Map metals to DOM targets
  const DOM = {
    XAU: { g: '.xau-g', oz: '.xau-oz' },
    XAG: { g: '.xag-g', oz: '.xag-oz' }
  };

  async function fetchQuote(metal){
    const res = await fetch('/api/quotes/summary?metal='+encodeURIComponent(metal), { cache: 'no-store' });
    if(!res.ok) throw new Error('HTTP '+res.status);
    return res.json();
  }

  function renderMetal(metal, data){
    if (!data || data.spot_gbp_per_g == null) return;

    const perG = Number(data.spot_gbp_per_g);
    const perOz = perG * OZT_PER_G;

    const gEl  = document.querySelector(DOM[metal]?.g);
    const ozEl = document.querySelector(DOM[metal]?.oz);

    if (gEl)  gEl.textContent  = fmtGBP.format(perG);
    if (ozEl) ozEl.textContent = fmtGBP.format(perOz);
  }

  async function refreshAll(){
    try {
      // Update the small ticker (defaults to the Blade prop, e.g. XAU)
      const tickerMetal = @json($metal);
      const tData = await fetchQuote(tickerMetal);
      if (tData?.spot_gbp_per_g != null) {
        document.getElementById('xMetG').textContent = Number(tData.spot_gbp_per_g).toFixed(2);
      }
      if (tData?.as_of) {
        const d = new Date(tData.as_of);
        if (!isNaN(d)) document.getElementById('xAsOf').textContent = d.toLocaleTimeString();
      }
    } catch(e){ /* silent ticker error */ }

    // Update UL prices (Gold & Silver)
    const metals = ['XAU','XAG'];
    for (const m of metals) {
      try {
        const data = await fetchQuote(m);
        renderMetal(m, data);
      } catch(e){ /* skip failed metal */ }
    }
  }

  refreshAll();
  setInterval(refreshAll, 30000); // every 30s
})();
</script>
@endpush
