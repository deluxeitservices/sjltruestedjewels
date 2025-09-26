{{-- One template for both admin & customer --}}
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Order #{{ $order->order_no }}</title>
  <style>
    body { font-family: Arial, sans-serif; color:#222; font-size:14px; }
    h2 { margin: 0 0 10px; }
    .muted { color:#666; }
    table { width:100%; border-collapse: collapse; margin-top: 12px; }
    th, td { border: 1px solid #e5e5e5; padding: 8px; text-align: left; }
    th { background: #f7f7f7; }
    .right { text-align:right; }
  </style>
</head>
<body>

@if($toAdmin)
  <h2>New Order Received</h2>
  <p class="muted">
    An order has been placed on <strong>{{ $appName }}</strong>.
  </p>
@else
  <h2>Thanks for your purchase!</h2>
  <p class="muted">
    We’ve received your order <strong>#{{ $order->order_no }}</strong>. A summary is below.
  </p>
@endif

<p>
  <strong>Order #:</strong> {{ $order->order_no }}<br>
  <strong>Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}<br>
  <strong>Status:</strong> {{ ucfirst($order->status) }}<br>
  <strong>Total:</strong> £{{ number_format((float)$order->total_gbp, 2) }}
</p>

<table>
  <thead>
    <tr>
      <th style="width:40px;">#</th>
      <th>Item</th>
      <th class="right" style="width:80px;">Qty</th>
      <th class="right" style="width:120px;">Unit (GBP)</th>
      <th class="right" style="width:120px;">Line Total</th>
    </tr>
  </thead>
  <tbody>
    @php $calcTotal = 0; @endphp
    @foreach($order->items as $i => $item)
      @php
        $qty  = (int)($item->qty ?? $item->quantity ?? 0);
        $unit = (float)($item->unit_gbp ?? $item->price_gbp ?? 0);
        $line = (float)($item->line_gbp ?? ($qty * $unit));
        $calcTotal += $line;
      @endphp
      <tr>
        <td class="right">{{ $i+1 }}</td>
        <td>{{ $item->title ?? $item->name ?? 'Item' }}</td>
        <td class="right">{{ $qty }}</td>
        <td class="right">{{ number_format($unit, 2) }}</td>
        <td class="right">{{ number_format($line, 2) }}</td>
      </tr>
    @endforeach
  </tbody>
</table>

<p class="right">
  @if(!is_null($order->subtotal_gbp)) Subtotal: £{{ number_format((float)$order->subtotal_gbp, 2) }}<br>@endif
  @if(!is_null($order->vat_gbp)) VAT: £{{ number_format((float)$order->vat_gbp, 2) }}<br>@endif
  <strong>Total: £{{ number_format((float)($order->total_gbp ?? $calcTotal), 2) }}</strong>
</p>

@if($toAdmin)
  <p class="muted">
    Customer: {{ $order->customer_name ?? $order->user?->name ?? '—' }} ({{ $order->customer_email ?? $order->user?->email ?? '—' }})
  </p>
@else
  <p class="muted">
    If you have any questions, just reply to this email. Thanks for shopping with {{ $appName }}!
  </p>
@endif

</body>
</html>
