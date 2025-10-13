<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Order #{{ $order->order_no }}</title>
  <style>
    /* Dompdf-friendly CSS (no external fonts) */
    :root {
      --text: #222;
      --muted: #666;
      --line: #e5e5e5;
      --brand: #111;
      /* SJLJewels brand color */
      --accent: #f5f7fa;
    }

    * {
      box-sizing: border-box;
    }

    body {
      font-family: DejaVu Sans, Arial, sans-serif;
      color: var(--text);
      font-size: 12px;
      margin: 0;
      padding: 24px;
    }

    h1,
    h2,
    h3,
    h4,
    p {
      margin: 0;
    }

    .mb-1 {
      margin-bottom: 6px;
    }

    .mb-2 {
      margin-bottom: 10px;
    }

    .mb-3 {
      margin-bottom: 16px;
    }

    .mb-4 {
      margin-bottom: 20px;
    }

    .muted {
      color: var(--muted);
    }

    .right {
      text-align: right;
    }

    .center {
      text-align: center;
    }

    .row {
      display: table;
      width: 100%;
      table-layout: fixed;
    }

    .col {
      display: table-cell;
      vertical-align: top;
    }

    .col-6 {
      width: 50%;
    }

    .hr {
      height: 1px;
      background: var(--line);
      margin: 16px 0;
    }

    /* Header */
    .brand {
      font-size: 22px;
      letter-spacing: 0.5px;
      font-weight: 700;
      color: var(--brand);
    }

    .brand-sub {
      font-size: 10px;
      color: var(--muted);
    }

    /* Meta boxes */
    .box {
      border: 1px solid var(--line);
      border-radius: 6px;
      padding: 12px;
      background: #fff;
    }

    .box-title {
      font-size: 11px;
      font-weight: 700;
      margin-bottom: 6px;
      letter-spacing: 0.3px;
      text-transform: uppercase;
      color: var(--muted);
    }

    .box p {
      line-height: 1.5;
    }

    /* Items table */
    table.items {
      width: 100%;
      border-collapse: collapse;
    }

    table.items th,
    table.items td {
      border: 1px solid var(--line);
      padding: 8px;
      vertical-align: top;
    }

    table.items thead th {
      background: var(--accent);
      font-weight: 700;
      text-transform: uppercase;
      font-size: 11px;
      letter-spacing: 0.3px;
    }

    .num {
      text-align: right;
      white-space: nowrap;
    }

    /* Totals */
    .totals {
      width: 260px;
      margin-left: auto;
      border: 1px solid var(--line);
      border-radius: 6px;
      overflow: hidden;
    }

    .totals-row {
      display: table;
      width: 100%;
      border-bottom: 1px solid var(--line);
    }

    .totals-row:last-child {
      border-bottom: 0;
    }

    .totals-label,
    .totals-val {
      display: table-cell;
      padding: 8px;
    }

    .totals-label {
      background: #fff;
    }

    .totals-val {
      text-align: right;
      background: #fff;
    }

    .totals-strong .totals-label,
    .totals-strong .totals-val {
      font-weight: 700;
    }

    /* Footer note */
    .note {
      margin-top: 18px;
      font-size: 11px;
      color: var(--muted);
      line-height: 1.6;
    }
  </style>
</head>

<body>

  <!-- Header -->
  <div class="row mb-3">
    <div class="col col-6">
      <div class="brand">SJL Trusted Jewels</div>
      <div class="brand-sub">Order Invoice </div>
    </div>
    <div class="col col-6 right">
      <h2>Order #{{ $order->order_no }}</h2>
      <p class="muted">
        Date: {{ $order->created_at->format('Y-m-d H:i') }}<br>
        Status: {{ ucfirst($order->status) }}
      </p>
    </div>
  </div>

  <div class="hr"></div>

  <!-- Meta: Customer & Billing -->
  <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;margin:0 0 16px;">
    <tr>
      <!-- Customer -->
      <td valign="top" style="width:50%;padding:0 8px 0 0;">
        <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e5e5;border-radius:6px;">
          <tr>
            <td style="background:#f5f7fa;padding:8px 10px;font-weight:bold;font-size:11px;text-transform:uppercase;color:#666;">
              Customer
            </td>
          </tr>
          <tr>
            <td style="padding:10px;line-height:1.5;font-size:12px;">
              <strong>{{ $order->customer_name ?? '—' }}</strong><br>
              {{ $order->customer_email ?? '—' }}
            </td>
          </tr>
        </table>
      </td>

      <!-- Billing -->
      <td valign="top" style="width:50%;padding:0 0 0 8px;">
        <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e5e5;border-radius:6px;">
          <tr>
            <td style="background:#f5f7fa;padding:8px 10px;font-weight:bold;font-size:11px;text-transform:uppercase;color:#666;">
              Billing
            </td>
          </tr>
          <tr>
            <td style="padding:10px;line-height:1.5;font-size:12px;">
              @if(!empty($order->user?->name)) <strong>{{ $order->user->name }}</strong><br> @endif
              @if(!empty($order->user?->address)) {{ $order->user->address }}<br> @endif
              @if(!empty($order->user?->house_no)) {{ $order->user->house_no }}<br> @endif
              @if(!empty($order->user?->street_name)) {{ $order->user->street_name }}<br> @endif
              @if(!empty($order->user?->city) || !empty($order->user?->postal_code))
              {{ $order->user?->city }} {{ $order->user?->postal_code }}<br>
              @endif
              @if(!empty($order->billing_country)) {{ $order->billing_country }} @endif
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

  <!-- Items -->
  <table class="items mb-3">
    <thead>
      <tr>
        <th style="width:40px;">#</th>
        <th>Item</th>
        <th style="width:70px;" class="num">Qty</th>
        <th style="width:110px;" class="num">Unit (GBP)</th>
        <th style="width:120px;" class="num">Line Total</th>
      </tr>
    </thead>
    <tbody>
      @php $calcTotal = 0; @endphp
      @foreach($order->items as $i => $item)
      @php
      $qty = (int)($item->qty ?? $item->quantity ?? 0);
      $unit = (float)($item->unit_gbp ?? $item->price_gbp ?? 0);
      $line = $qty * $unit;
      $calcTotal += $line;
      @endphp
      <tr>
        <td class="num">{{ $i + 1 }}</td>
        <td>
          <strong>{{ $item->title ?? $item->name ?? 'Item' }}</strong>
          @if(!empty($item->sku))<br><span class="muted">SKU: {{ $item->sku }}</span>@endif
          @if(!empty($item->notes))<br><span class="muted">{{ $item->notes }}</span>@endif
        </td>
        <td class="num">{{ $qty }}</td>
        <td class="num">{{ number_format($unit, 2) }}</td>
        <td class="num">{{ number_format($line, 2) }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <!-- Totals -->
  @php
  $subtotal = isset($order->subtotal_gbp) ? (float)$order->subtotal_gbp : $calcTotal;
  $vat = isset($order->vat_gbp) ? (float)$order->vat_gbp : 0.0;
  $grand = isset($order->total_gbp) ? (float)$order->total_gbp : ($subtotal + $vat);
  @endphp

  <div class="totals">
    @if(!is_null($order->subtotal_gbp))
    <div class="totals-row">
      <div class="totals-label">Subtotal</div>
      <div class="totals-val">£{{ number_format($subtotal, 2) }}</div>
    </div>
    @endif
    @if(!is_null($order->vat_gbp))
    <div class="totals-row">
      <div class="totals-label">VAT</div>
      <div class="totals-val">£{{ number_format($vat, 2) }}</div>
    </div>
    @endif
    <div class="totals-row totals-strong">
      <div class="totals-label">Total</div>
      <div class="totals-val">£{{ number_format($grand, 2) }}</div>
    </div>
  </div>

  <!-- Footer note -->
  <div class="note">
    Thank you for your purchase from <strong>SJLJewels</strong>. If you have any questions about this order,
    please reply to this email or contact support.
  </div>

</body>

</html>