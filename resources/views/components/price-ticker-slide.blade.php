@props(['metal'=>'XAU'])

<!-- <div id="priceTicker" class="w-full text-sm bg-amber-50 border border-amber-200 py-2 px-3 rounded mb-4">
  <span>Live <strong>{{ $metal }}</strong> (GBP/g): </span>
  <strong id="xMetG">—</strong>
  <span class="opacity-70"> · Updated: <span id="xAsOf">—</span></span>
</div>
 -->
<ul class="top-header-content">
  <li>
    <div class="pric-box">
      <a href="{{ url('/') }}">
        <span><img src="{{ asset('./assets/image/gol-header.svg') }}" class="header-logo"></span>
        <span class="metal-name">Gold</span>
      </a>
    </div>
    <div class="pric-box">
      <span class="price" id="xau-oz">£—</span>
      <span class="weight-text">o/z</span>
    </div>
    <span class="border-right-header"></span>
    <p class="price-going">
      <span class="price headergoldgramprice" id="xau-g">£—</span>
      <span class="weight-text">gm</span>
    </p>
  </li>

  <li>
    <div class="pric-box">
      <a href="#">
        <span><img src="{{ asset('./assets/image/silver-header.svg') }}"></span>
        <span class="metal-name">Silver</span>
      </a>
    </div>
    <div class="pric-box">
      <span class="price" id="xag-oz">£—</span>
      <span class="weight-text">o/z</span>
    </div>
    <span class="border-right-header"></span>
    <p class="price-going">
      <span class="price headergoldgramprice" id="xag-g">£—</span>
      <span class="weight-text">gm</span>
    </p>
  </li>

  <li>
    <div class="pric-box">
      <a href="#">
        <span><img src="{{ asset('./assets/image/platinum.svg') }}"></span>
        <span class="metal-name">Platinum</span>
      </a>
    </div>
    <div class="pric-box">
      <span class="price" id="xpt-oz">£—</span>
      <span class="weight-text">o/z</span>
    </div>
    <span class="border-right-header"></span>
    <p class="price-going">
      <span class="price headergoldgramprice" id="xpt-g">£—</span>
      <span class="weight-text">gm</span>
    </p>
  </li>

  <li>
    <div class="pric-box">
      <a href="#">
        <span><img src="{{ asset('./assets/image/palldium.svg') }}"></span>
        <span class="metal-name">Palladium</span>
      </a>
    </div>
    <div class="pric-box">
      <span class="price" id="xpd-oz">£—</span>
      <span class="weight-text">o/z</span>
    </div>
    <span class="border-right-header"></span>
    <p class="price-going">
      <span class="price headergoldgramprice" id="xpd-g">£—</span>
      <span class="weight-text">gm</span>
    </p>
  </li>
</ul>

@push('scripts')
<script>
(function(){
  // 1 troy ounce = 31.1034768 grams
  const GRAMS_PER_TROY_OUNCE = 31.1034768;

  const fmtGBP = new Intl.NumberFormat('en-GB', {
    style: 'currency', currency: 'GBP', minimumFractionDigits: 2, maximumFractionDigits: 2
  });

  // Map ISO metals -> DOM IDs
  const DOM = {
    XAU: { g: '#xau-g', oz: '#xau-oz' },
    XAG: { g: '#xag-g', oz: '#xag-oz' },
    XPT: { g: '#xpt-g', oz: '#xpt-oz' },
    XPD: { g: '#xpd-g', oz: '#xpd-oz' },
  };

  async function fetchQuote(metal){
    const res = await fetch('/api/quotes/summary?metal='+encodeURIComponent(metal), { cache: 'no-store' });
    if(!res.ok) throw new Error('HTTP '+res.status);
    return res.json();
  }

  function renderMetal(metal, data){
    if (!data || data.spot_gbp_per_g == null) return;
    const perG = Number(data.spot_gbp_per_g);
    const perOz = perG * GRAMS_PER_TROY_OUNCE;

    const gEl  = document.querySelector(DOM[metal]?.g);
    const ozEl = document.querySelector(DOM[metal]?.oz);

    if (gEl)  gEl.textContent  = fmtGBP.format(perG);
    if (ozEl) ozEl.textContent = fmtGBP.format(perOz);
  }

  async function refreshAll(){
    // Update small ticker (uses Blade prop, default XAU)
    try {
      const tickerMetal = @json($metal);
      const tData = await fetchQuote(tickerMetal);
      if (tData?.spot_gbp_per_g != null) {
        document.getElementById('xMetG').textContent = Number(tData.spot_gbp_per_g).toFixed(2);
      }
      if (tData?.as_of) {
        const d = new Date(tData.as_of);
        if (!isNaN(d)) document.getElementById('xAsOf').textContent = d.toLocaleTimeString();
      }
    } catch(e){ /* ignore ticker error */ }

    // Update UL prices for all four metals concurrently
    const metals = Object.keys(DOM);
    try {
      const results = await Promise.allSettled(metals.map(m => fetchQuote(m)));
      results.forEach((res, i) => {
        const m = metals[i];
        if (res.status === 'fulfilled') renderMetal(m, res.value);
      });
    } catch(e){ /* ignore */ }
  }

  refreshAll();
  setInterval(refreshAll, 30000);
})();
</script>
@endpush
