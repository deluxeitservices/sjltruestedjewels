@extends('layouts.app')
@section('title','Sell Now — SJL')


<style>
  .sell-now-table td, .sell-now-table th { vertical-align: middle; }
  .delete-icon a { color: #c00; }
  .img-thumb { max-height: 50px; display:block; }

  /* Wizard */
  .wizard-step { display: none; }
  .wizard-step.active { display: block; }
  .wizard-nav { gap: 10px; }
  .wizard-nav .badge { font-size: .95rem; }
  .wizard-nav .badge.active { background:#222; }
  .wizard-nav .badge.completed { background:#28a745; }

  /* Spinner */
  .spinner {
    width: 16px; height: 16px;
    border: 2px solid rgba(0,0,0,.15);
    border-top-color: rgba(0,0,0,.6);
    border-radius: 50%;
    display: inline-block;
    animation: spin .8s linear infinite;
    vertical-align: text-bottom;
    margin-left: 6px;
  }
  @keyframes spin { to { transform: rotate(360deg) } }

  /* Loading state */
  .item-row.loading .price-box .spinner { display: inline-block !important; }
  .item-row .price-box .spinner { display: none; }
  .item-row.loading .lineTotal { opacity: .5; }

  /* Update flash */
  .flash-highlight { animation: flashbg 1.2s ease-out 1; }
  @keyframes flashbg { 0% { background:#fff3cd; } 100% { background:transparent; } }

  /* Hide delete icon for single row */
  #itemsContainer tr:only-child .delete-icon { visibility: hidden; }
</style>

@section('content')
<main class="sell-now-page-main">
  <section class="sell-now-section common-section">
    <div class="container">

      <!-- {{-- Wizard header (optional) --}}
      <div class="d-flex align-items-center wizard-nav mb-3">
        <span id="wizStep1Badge" class="badge bg-secondary active">Step 1 — Items</span>
        <span id="wizStep2Badge" class="badge bg-light text-dark">Step 2 — Your Details</span>
      </div> -->

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      {{-- Single form for both steps --}}
      <form id="sellWizardForm" action="{{ route('sell.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        {{-- =========================
             STEP 1: ITEMS
        ========================== --}}
        <div id="step1" class="wizard-step active">
          <h4 class="common-title">Sell Your Precious Metals</h4>
          <p class="sell-now-content text-center">Please enter the items you would like to sell to us.</p>

          <div class="table-responsive">
            <table class="table align-middle sell-now-table">
              <thead>
                <tr>
                  <th>Item</th>
                  <th>Carat (Purity)</th>
                  <th>Quantity</th>
                  <th>Weight (g)</th>
                  <th>Photo</th>
                  <th>Price</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="itemsContainer"></tbody>
            </table>
          </div>

          <div class="sell-now-check-btn d-flex align-items-center justify-content-between">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="1" id="dontKnow" />
              <label class="form-check-label" for="dontKnow">
                I don't know the weight/carat of my items?
              </label>
            </div>
            <div class="add-item-btn">
              <button type="button" id="addItemBtn" class="btn common-primary-btn">
                <i class="fa-solid fa-plus"></i> Add new item
              </button>
            </div>
          </div>

          <section class="sell-item-total-section">
            <div class="container px-0">
              <div class="row">
                <div class="col-md-12">
                  <div class="sell-now-main-box d-flex align-items-center justify-content-between">
                    <div class="total-price-item d-flex align-items-center gap-3">
                      <div class="item-img"><img src="/assets/image/coin-1.png" alt=""></div>
                      <div class="sell-product-desc d-flex flex-column">
                        <div class="totalgrams text-nowrap"><span id="totalGrams">0.00</span> gram(s)</div>
                      </div>
                    </div>
                    <div class="item-value text-end">
                      <h6>£<span id="grandTotal">0.00</span></h6>
                      <button class="common-primary-btn" id="goStep2Btn" type="button">
                        <i class="fa-regular fa-hand-point-right"></i> Next
                      </button>
                    </div>
                  </div>
                  <div id="step1Error" class="text-danger mt-2" style="display:none;"></div>
                </div>
              </div>
            </div>
          </section>
        </div>

        {{-- =========================
             STEP 2: YOUR DETAILS
        ========================== --}}
        <div id="step2" class="wizard-step">
          <div class="row">
          <div class="row">
            <div class="col-md-12">
              <h2 class="common-title">Your Details</h2>
              <p class="common-form-content">Please login or register to proceed</p>
              
            </div>

          </div>
        </div>
          <div class="row align-items-stretch">
            {{-- LEFT: Register/Guest or Auth summary --}}
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
              <div class="common-form-page h-100 h-custom checkout-page p-0">
                <div class="container">
                	<button class="btn btn-outline-secondary btn-sm" type="button" id="backToStep1">
	              &larr; Back to items
	            </button>
                 
                  <div class="card mt-3 checkout-card">
                    <div class="card-body checkout-card-body">

                      @auth
                        {{-- Logged-in summary --}}
                        <div class="row common-form-row">
                          <div class="col-lg-12">
                            <div class="form-check common-label-checkbox">
                              <input class="form-check-input" type="radio" checked disabled>
                              <label class="form-check-label">
                                Logged in as {{ auth()->user()->name ?? auth()->user()->email }}
                              </label>
                            </div>
                            <hr>
                            <div class="row g-3">
                              <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                                <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                              </div>
                              <div class="col-md-6">
                                <label class="form-label">Mobile Number</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->phone ?? '' }}" disabled>
                                <input type="hidden" name="phone" value="{{ auth()->user()->phone ?? '' }}">
                              </div>
                              <div class="col-md-12">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->email }}" disabled>
                                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                              </div>
                              <div class="col-md-12">
                                <label class="form-label">Notes (optional)</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="Anything we should know?"></textarea>
                              </div>
                            </div>
                            <input type="hidden" name="checkout_mode" value="auth">
                          </div>
                        </div>
                      @else
                        {{-- Guest / Register toggle --}}
                        <div class="row common-form-row">
                          <div class="col-lg-12">
                            <div class="d-flex gap-3 common-label-checkbox">
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="checkout_mode" id="modeGuest" value="guest" checked>
                                <label class="form-check-label" for="modeGuest">Continue as guest</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="checkout_mode" id="modeRegister" value="register">
                                <label class="form-check-label" for="modeRegister">Register & continue</label>
                              </div>
                              	 <button class="btn btn-outline-secondary btn-sm" type="button" id="openLoginModal">
				                    Click Login
				                  </button>
                            </div>
                            <hr>

                            <div class="row g-3">
                              <div class="col-md-6">
                                <label class="form-label">First name</label>
                                <input type="text" class="form-control" name="first_name" required>
                              </div>
                              <div class="col-md-6">
                                <label class="form-label">Last name</label>
                                <input type="text" class="form-control" name="last_name" required>
                              </div>
                              <div class="col-md-6">
                                <label class="form-label">Mobile Number</label>
                                <input type="text" class="form-control" name="phone" required>
                              </div>
                              <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                              </div>

                              {{-- Passwords in register mode only --}}
                              <div class="col-md-6 reg-only d-none">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" autocomplete="new-password">
                              </div>
                              <div class="col-md-6 reg-only d-none">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                              </div>

                              <div class="col-12">
                                <label class="form-label">Notes (optional)</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="Anything we should know?"></textarea>
                              </div>
                            </div>

                            {{-- We will fill this on submit (first + last) --}}
                            <input type="hidden" name="name" id="fullNameHidden">

                            {{-- Existing customer login trigger (modal, separate form) --}}
                            
                          </div>
                        </div>
                      @endauth

                    </div>
                  </div>
                  <div class="d-flex justify-content-end mt-3">
		            <button type="submit" class="common-primary-btn" id="finalSubmitBtn">
		              <i class="fa-regular fa-hand-point-right"></i>
		              @auth Continue @else <span id="submitCta">Continue as guest</span> @endauth
		            </button>
		          </div>
                </div>
              </div>
            </div>
            {{-- RIGHT: (optional) Marketing or summary panel; you can keep it empty or add info --}}
            <div class="col-md-2">
              {{-- You can place summary, FAQs, or leave blank --}}
            </div>
          </div>

          {{-- Bottom action --}}
          
        </div> {{-- /step2 --}}
      </form>
    </div>
  </section>
</main>

{{-- ===========================
     LOGIN MODAL (separate form)
============================= --}}
@guest
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('login') }}" id="inlineLoginForm" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @if ($errors->any())
          <div class="alert alert-danger py-2">
            {{ $errors->first() }}
          </div>
        @endif
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input name="email" type="email" class="form-control" required autocomplete="email">
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input name="password" type="password" class="form-control" required autocomplete="current-password">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" id="loginSubmitBtn">Login</button>
      </div>
    </form>
  </div>
</div>
@endguest
@endsection

@push('scripts')
<script>
(function(){
  if (window.__sellNowInitDone) return; window.__sellNowInitDone = true;

  /* ----------------------------
     STEP NAVIGATION
  ----------------------------- */
  const step1 = document.getElementById('step1');
  const step2 = document.getElementById('step2');
  const nextBtn = document.getElementById('goStep2Btn');
  const backBtn = document.getElementById('backToStep1');
  const b1 = document.getElementById('wizStep1Badge');
  const b2 = document.getElementById('wizStep2Badge');

  function gotoStep(n){
    const s1 = (n === 1), s2 = (n === 2);
    step1.classList.toggle('active', s1);
    step2.classList.toggle('active', s2);
    if (b1 && b2) {
      b1.classList.toggle('active', s1);
      b2.classList.toggle('active', s2);
      b1.classList.toggle('completed', s2);
    }
    if (s2) window.scrollTo({ top: step2.offsetTop - 20, behavior:'smooth' });
    saveDraft(n); // persist which step we're on
  }
  if (backBtn) backBtn.addEventListener('click', ()=> gotoStep(1));

  /* ----------------------------
     ITEMS TABLE + PRICING
  ----------------------------- */
  const ITEMS = [
    { key:'gold_jewellery', label:'Gold Jewellery',  metal:'gold',     purities:['Select Carat','24ct (99.99%)','23ct (95.80%)','22ct (91.6%)','21ct (87.5%)','20ct (83.3%)','18ct (75%)','14ct (58.5%)','9ct (37.5%)'] },
    { key:'gold_bar',       label:'Gold Bar',        metal:'gold',     purities:['Select Carat','24ct (99.99%)'] },
    { key:'gold_coin',      label:'Gold Coin',       metal:'gold',     purities:['Select Carat','24ct (99.99%)','22ct (91.6%)'] },
    { key:'silver_jewellery', label:'Silver Jewellery', metal:'silver',   purities:['Select Carat','925 (92.5%)'] },
    { key:'silver_bar',       label:'Silver Bar',       metal:'silver',   purities:['Select Carat','999 (99.9%)'] },
    { key:'silver_coin',      label:'Silver Coin',      metal:'silver',   purities:['Select Carat','999 (99.9%)','925 (92.5%)'] },
    { key:'platinum_jewellery', label:'Platinum Jewellery', metal:'platinum', purities:['Select Carat','950 (95%)'] },
    { key:'platinum_bar',       label:'Platinum Bar',       metal:'platinum', purities:['Select Carat','999.5 (99.95%)'] },
    { key:'palladium_bar',       label:'Palladium Bar',       metal:'palladium', purities:['Select Carat','999.5 (99.95%)'] },
    { key:'palladium_jewellery', label:'Palladium Jewellery', metal:'palladium', purities:['Select Carat','950 (95%)'] },
  ];

  const _  = { esc: s => String(s ?? '').replace(/[&<>"']/g, m=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m])) };
  const f2 = n => (isFinite(n)?Number(n).toFixed(2):'0.00');
  const f3 = n => (isFinite(n)?Number(n).toFixed(3):'0.000');

  const container = document.getElementById('itemsContainer');
  const rowCtrls  = new Map();

  function getNextIndex(){
    let next = parseInt(container.dataset.nextIndex || '', 10);
    if (Number.isNaN(next)) {
      next = Array.from(container.querySelectorAll('tr[data-index]'))
        .reduce((m, tr) => Math.max(m, parseInt(tr.dataset.index || '-1', 10)), -1) + 1;
    }
    container.dataset.nextIndex = String(next + 1);
    return next;
  }

  function itemOptionsHtml() {
    return `<option value="" selected hidden>Please select…</option>` +
      ITEMS.map(i => `<option value="${i.key}" data-metal="${i.metal}">${_.esc(i.label)}</option>`).join('');
  }
  function buildPurityOptions(keys){
    return keys.map((p,idx)=>{
      const disabled = (idx===0 && p.toLowerCase().includes('select')) ? 'disabled selected' : '';
      return `<option value="${_.esc(p)}" ${disabled}>${_.esc(p)}</option>`;
    }).join('');
  }

  function tplRow(i){
    return `
    <tr class="item-row" data-index="${i}">
      <td style="min-width:240px">
        <select class="form-select item-select">
          ${itemOptionsHtml()}
        </select>
        <input type="hidden" name="items[${i}][item_key]"   class="item-key-hidden">
        <input type="hidden" name="items[${i}][item_label]" class="item-label-hidden">
        <input type="hidden" name="items[${i}][metal]"      class="metal-hidden">
      </td>

      <td style="min-width:180px">
        <select name="items[${i}][purity_label]" class="form-select purity">
          <option value="" selected disabled>Select Carat</option>
        </select>
      </td>

      <td style="width:140px">
        <div class="input-group">
          <button class="btn btn-outline-secondary minusBtn" type="button">-</button>
          <input type="text" name="items[${i}][qty]" class="form-control text-center quantity qty" value="1" readonly>
          <button class="btn btn-outline-secondary plusBtn" type="button">+</button>
        </div>
      </td>

      <td style="width:140px">
        <input type="number" step="0.001" min="0" name="items[${i}][weight_g]" class="form-control weight" value="0">
      </td>

      <td style="min-width:180px">
        <input type="file" name="items[${i}][photo]" class="form-control form-control-sm photo" accept="image/*">
        <img class="img-thumb mt-1 d-none" alt="preview">
      </td>

      <td class="price-td" style="min-width:130px">
        <div class="price-box">£<span class="lineTotal">0.00</span> <span class="spinner" aria-hidden="true"></span></div>
        <input type="hidden" class="unitPrice" value="0">
      </td>

      <td class="delete-icon">
        <a href="#" class="deleteBtn"><i class="fa-solid fa-trash-can"></i></a>
      </td>
    </tr>`;
  }

  function updateDeleteButtons() {
    const rows = container.querySelectorAll('tr');
    const show = rows.length > 1;
    rows.forEach(tr => {
      const cell = tr.querySelector('.delete-icon');
      if (!cell) return;
      cell.style.visibility = show ? 'visible' : 'hidden';
    });
  }

  function addRow(pref){
    const i = getNextIndex();
    container.insertAdjacentHTML('beforeend', tplRow(i));
    const tr = container.querySelector(`tr[data-index="${i}"]`);
    bindRow(tr);
    if (pref) {
      // prefill values (for restore)
      tr.querySelector('.item-select').value = pref.item_key || '';
      tr.querySelector('.item-label-hidden').value = pref.item_label || '';
      tr.querySelector('.metal-hidden').value = pref.metal || '';
      const puritySel = tr.querySelector('.purity');
      const item = ITEMS.find(it => it.key === pref.item_key);
      puritySel.innerHTML = buildPurityOptions(item ? item.purities : ['Select Carat']);
      if (pref.purity_label) puritySel.value = pref.purity_label;
      if (pref.qty) tr.querySelector('.qty').value = pref.qty;
      if (pref.weight_g != null) tr.querySelector('.weight').value = f3(pref.weight_g);
      recalcRow(tr);
    }
    updateDeleteButtons();
  }

  function bindRow(tr){
    tr.querySelector('.item-select').addEventListener('change', e=>{
      const key  = e.target.value;
      const item = ITEMS.find(it => it.key === key);
      tr.querySelector('.item-key-hidden').value   = key || '';
      tr.querySelector('.item-label-hidden').value = item ? item.label : '';
      tr.querySelector('.metal-hidden').value      = item ? item.metal : '';

      const puritySel = tr.querySelector('.purity');
      puritySel.innerHTML = buildPurityOptions(item ? item.purities : ['Select Carat']);

      tr.querySelector('.unitPrice').value = '0';
      tr.querySelector('.lineTotal').textContent = '0.00';
      recomputeTotals();
      saveDraft(); // persist choice
    });

    tr.querySelector('.purity').addEventListener('change', ()=> { recalcRow(tr); saveDraft(); });
    tr.querySelector('.plusBtn').addEventListener('click', ()=>{
      const q=tr.querySelector('.qty'); q.value=Math.min(9999,(+q.value)+1); recalcRow(tr); saveDraft();
    });
    tr.querySelector('.minusBtn').addEventListener('click', ()=>{
      const q=tr.querySelector('.qty'); q.value=Math.max(1,(+q.value)-1); recalcRow(tr); saveDraft();
    });
    tr.querySelector('.weight').addEventListener('input', ()=> { recalcRow(tr); saveDraft(); });

    tr.querySelector('.photo').addEventListener('change', (e)=>{
      const img = tr.querySelector('.img-thumb');
      const f = e.target.files?.[0];
      if (!f){ img.classList.add('d-none'); img.src=''; return; }
      img.src = URL.createObjectURL(f);
      img.classList.remove('d-none');
    });

    tr.querySelector('.deleteBtn').addEventListener('click', (e)=>{
      e.preventDefault();
      const idx = tr.dataset.index;
      const ctrl = rowCtrls.get(idx);
      if (ctrl) ctrl.abort();
      tr.remove();
      recomputeTotals();
      updateDeleteButtons();
      saveDraft();
    });
  }

  let debounceTimer = null;
  function recalcRow(tr){
    if (debounceTimer) clearTimeout(debounceTimer);
    debounceTimer = setTimeout(()=> doCalcRow(tr), 120);
  }

  function setLoading(tr, on){
    if (!tr) return;
    tr.classList.toggle('loading', !!on);
  }

  async function doCalcRow(tr){
    const idx = tr.dataset.index;

    const key    = tr.querySelector('.item-select').value || '';
    const item   = ITEMS.find(it => it.key === key);
    const metal  = item?.metal || tr.querySelector('.metal-hidden').value || '';
    const purity = tr.querySelector('.purity').value || '';
    const qty    = Math.max(1, parseInt(tr.querySelector('.qty').value || '1', 10));
    const weight = Math.max(0, parseFloat(tr.querySelector('.weight').value || '0'));

    if (!metal || !purity || purity.toLowerCase().includes('select')){
      tr.querySelector('.unitPrice').value = '0';
      tr.querySelector('.lineTotal').textContent = '0.00';
      return recomputeTotals();
    }

    tr.querySelector('.qty').value    = qty;
    tr.querySelector('.weight').value = weight ? f3(weight) : 0;

    const prev = rowCtrls.get(idx);
    if (prev) prev.abort();
    const controller = new AbortController();
    rowCtrls.set(idx, controller);

    setLoading(tr, true);

    try{
      const resp = await fetch(@json(route('sell.calc')), {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': @json(csrf_token()),
          'Accept':'application/json',
          'Content-Type':'application/json'
        },
        signal: controller.signal,
        body: JSON.stringify({ item_key: key, metal, purity_label: purity, qty, weight_g: weight })
      });
      if (!resp.ok) throw new Error('calc failed');
      const data = await resp.json();
      tr.querySelector('.unitPrice').value       = f2(Number(data.unit_price ?? 0));
      tr.querySelector('.lineTotal').textContent = f2(Number(data.line_total ?? 0));

      const priceSpan = tr.querySelector('.lineTotal');
      if (priceSpan){
        priceSpan.classList.remove('flash-highlight');
        void priceSpan.offsetWidth;
        priceSpan.classList.add('flash-highlight');
        setTimeout(()=> priceSpan.classList.remove('flash-highlight'), 1300);
      }
    }catch(_){
      // ignore
    }finally{
      setLoading(tr, false);
      recomputeTotals();
    }
  }

  function recomputeTotals(){
    let grams = 0, total = 0;
    container.querySelectorAll('tr').forEach(tr=>{
      const q  = Math.max(1, parseInt(tr.querySelector('.qty')?.value || '1', 10));
      const wt = Math.max(0, parseFloat(tr.querySelector('.weight')?.value || '0'));
      const lt = parseFloat(tr.querySelector('.lineTotal')?.textContent || '0') || 0;
      grams += q * wt;
      total += lt;
    });
    document.querySelector('#totalGrams').textContent = f2(grams);
    document.querySelector('#grandTotal').textContent = f2(total);
  }

  const addBtn = document.getElementById('addItemBtn');
  if (addBtn && !addBtn.dataset.bound) {
    addBtn.addEventListener('click', ()=>{ addRow(); saveDraft(); });
    addBtn.dataset.bound = '1';
  }
  if (!container.querySelector('tr[data-index]')) addRow();
  updateDeleteButtons();

  /* ----------------------------
     NEXT BUTTON VALIDATION
  ----------------------------- */
  const step1Error = document.getElementById('step1Error');
  function canProceedToStep2(){
    const rows = container.querySelectorAll('tr');
    if (!rows.length) return { ok:false, msg:'Please add at least one item.' };
    let anyTotal = 0;
    for (const tr of rows) {
      const purity = tr.querySelector('.purity')?.value || '';
      const weight = parseFloat(tr.querySelector('.weight')?.value || '0') || 0;
      const lt     = parseFloat(tr.querySelector('.lineTotal')?.textContent || '0') || 0;
      if (!purity || purity.toLowerCase().includes('select')) {
        return { ok:false, msg:'Please select a carat for each item.' };
      }
      if (weight <= 0) {
        return { ok:false, msg:'Please enter a positive weight for each item.' };
      }
      anyTotal += lt;
    }
    if (anyTotal <= 0) return { ok:false, msg:'We could not price your items. Please review carat/weight.' };
    return { ok:true };
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', ()=>{
      const chk = canProceedToStep2();
      if (!chk.ok) {
        step1Error.textContent = chk.msg;
        step1Error.style.display = 'block';
        return;
      }
      step1Error.style.display = 'none';
      gotoStep(2);
    });
  }

  /* ----------------------------
     STEP 2 UI: Guest/Register toggle
  ----------------------------- */
  const modeGuest    = document.getElementById('modeGuest');
  const modeRegister = document.getElementById('modeRegister');
  const regOnly      = document.querySelectorAll('.reg-only');
  const submitCta    = document.getElementById('submitCta');

  function applyMode(){
    if (!modeRegister || !modeGuest) return;
    const isRegister = modeRegister.checked;
    regOnly.forEach(el => el.classList.toggle('d-none', !isRegister));
    if (submitCta) submitCta.textContent = isRegister ? 'Register & continue' : 'Continue as guest';
    saveDraft(2);
  }
  if (modeGuest && modeRegister) {
    modeGuest.addEventListener('change', applyMode);
    modeRegister.addEventListener('change', applyMode);
    applyMode();
  }

  /* ----------------------------
     FINAL SUBMIT (compose name)
  ----------------------------- */
  const form = document.getElementById('sellWizardForm');
  form.addEventListener('submit', ()=>{
    const fn = form.querySelector('[name="first_name"]');
    const ln = form.querySelector('[name="last_name"]');
    const nameHidden = document.getElementById('fullNameHidden');
    if (fn && ln && nameHidden && !nameHidden.value) {
      const first = (fn.value || '').trim();
      const last  = (ln.value || '').trim();
      nameHidden.value = (first + ' ' + last).trim();
    }
    // clear draft after submit
    try { localStorage.removeItem('sellWizardDraft'); } catch(e){}
  });

  /* ----------------------------
     DRAFT SAVE/RESTORE
  ----------------------------- */
  function serializeRows(){
    const rows = [];
    container.querySelectorAll('tr').forEach(tr=>{
      rows.push({
        item_key:      tr.querySelector('.item-select')?.value || '',
        item_label:    tr.querySelector('.item-label-hidden')?.value || '',
        metal:         tr.querySelector('.metal-hidden')?.value || '',
        purity_label:  tr.querySelector('.purity')?.value || '',
        qty:           parseInt(tr.querySelector('.qty')?.value || '1', 10) || 1,
        weight_g:      parseFloat(tr.querySelector('.weight')?.value || '0') || 0,
      });
    });
    return rows;
  }

  function saveDraft(stepOverride){
    try{
      const draft = {
        step: stepOverride ?? (step2.classList.contains('active') ? 2 : 1),
        rows: serializeRows(),
        guest: {
          first_name: document.querySelector('[name="first_name"]')?.value || '',
          last_name : document.querySelector('[name="last_name"]')?.value || '',
          phone     : document.querySelector('[name="phone"]')?.value || '',
          email     : document.querySelector('[name="email"]')?.value || '',
          notes     : document.querySelector('[name="notes"]')?.value || '',
          mode      : document.querySelector('[name="checkout_mode"]:checked')?.value || 'guest'
        }
      };
      localStorage.setItem('sellWizardDraft', JSON.stringify(draft));
    }catch(e){}
  }

  function restoreDraft(){
    try{
      const raw = localStorage.getItem('sellWizardDraft');
      if (!raw) return;
      const d = JSON.parse(raw);
      // Clear existing rows then rebuild
      container.innerHTML = '';
      container.dataset.nextIndex = ''; // recalc from zero
      if (Array.isArray(d.rows) && d.rows.length) {
        d.rows.forEach(r => addRow(r));
      } else {
        addRow(); // ensure at least one
      }
      updateDeleteButtons();
      recomputeTotals();

      // restore guest/register fields
      if (d.guest) {
        const set = (sel, v)=>{ const el = document.querySelector(sel); if (el) el.value = v || ''; };
        set('[name="first_name"]', d.guest.first_name);
        set('[name="last_name"]',  d.guest.last_name);
        set('[name="phone"]',      d.guest.phone);
        set('[name="email"]',      d.guest.email);
        set('[name="notes"]',      d.guest.notes);
        const mode = d.guest.mode || 'guest';
        const mg = document.getElementById('modeGuest');
        const mr = document.getElementById('modeRegister');
        if (mg && mr) {
          if (mode === 'register') { mr.checked = true; mg.checked = false; }
          else { mg.checked = true; mr.checked = false; }
          applyMode();
        }
      }
      // step
      if (d.step === 2) gotoStep(2); else gotoStep(1);
    }catch(e){
      // if parse fails, ignore
    }
  }
  restoreDraft();

  // Auto-save key fields
  ['first_name','last_name','phone','email','notes'].forEach(name=>{
    const el = document.querySelector(`[name="${name}"]`);
    if (el) el.addEventListener('input', ()=> saveDraft(2));
  });

  /* ----------------------------
     LOGIN MODAL CONTROL
  ----------------------------- */
  const openLoginBtn   = document.getElementById('openLoginModal');
  const loginForm      = document.getElementById('inlineLoginForm');
  const loginModalEl   = document.getElementById('loginModal');
  let loginModal;
  if (loginModalEl && window.bootstrap) {
    loginModal = new bootstrap.Modal(loginModalEl);
  }

  if (openLoginBtn && loginModal) {
    openLoginBtn.addEventListener('click', ()=>{
      saveDraft(2); // make sure draft is safe before navigating
      loginModal.show();
    });
  }
  if (loginForm) {
    loginForm.addEventListener('submit', ()=>{
      saveDraft(2);
      // Let Laravel handle login; on success page reloads and restoreDraft() runs.
    });
  }
})();
</script>
@endpush
