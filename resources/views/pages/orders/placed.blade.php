{{-- resources/views/emails/orders/placed.blade.php --}}
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Order #{{ $order->order_no }}</title>
  <meta name="x-apple-disable-message-reformatting">
  <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--[if mso]>
  <style> body, table, td, a { font-family: Arial, sans-serif !important; } </style>
  <![endif]-->
</head>
<body style="margin:0;padding:0;background:#f6f7f9;">
  <center style="width:100%;background:#f6f7f9;">

    <!-- Outer wrapper -->
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f6f7f9;">
      <tr>
        <td align="center" style="padding:28px 12px 16px;">
          <!-- Logo (outside the card, centered) -->
          <img src="https://sjldesign.istockandtax.co.uk/option_2/assets/image/sjl-png.png"
               alt="{{ $appName ?? config('app.name', 'Brand') }}"
               width="160" height="40"
               style="display:block;border:0;outline:none;text-decoration:none;max-width:160px;height:auto;margin:0 auto;">
        </td>
      </tr>

      <tr>
        <td align="center" style="padding:0 12px 28px;">
          <!-- Card container -->
          <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%"
                 style="max-width:640px;background:#ffffff;border-radius:10px;overflow:hidden;">
            <!-- Top bar -->
            <tr>
              <td style="padding:16px 24px;background:#ecefed;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td align="left" style="font:600 14px/1.4 Arial,Helvetica,'Segoe UI',sans-serif;color:#0f172a;">
                      @if($toAdmin)
                        New Order Received
                      @else
                        Order Confirmation
                      @endif
                    </td>
                    <td align="right" style="font:400 12px/1.4 Arial,Helvetica,'Segoe UI',sans-serif;color:#475569;white-space:nowrap;">
                      #{{ $order->order_no }}
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <!-- Intro -->
            <tr>
              <td style="padding:26px 24px 8px;">
                @if($toAdmin)
                  <div style="font:700 20px/1.3 Arial,Helvetica,'Segoe UI',sans-serif;color:#0f172a;margin:0 0 6px;">
                    New Order Received
                  </div>
                  <div style="font:400 14px/1.6 Arial,Helvetica,'Segoe UI',sans-serif;color:#475569;margin:0;">
                    An order has been placed on <strong>{{ $appName ?? config('app.name') }}</strong>. Details below.
                  </div>
                @else
                  <div style="font:700 20px/1.3 Arial,Helvetica,'Segoe UI',sans-serif;color:#0f172a;margin:0 0 6px;">
                    Thanks for your purchase!
                  </div>
                  <div style="font:400 14px/1.6 Arial,Helvetica,'Segoe UI',sans-serif;color:#475569;margin:0;">
                    We've received your order <strong>#{{ $order->order_no }}</strong>. Please complete one final step to help us process your payment.
                  </div>
                @endif
              </td>
            </tr>

            @unless($toAdmin)
            <!-- CTA -->
            <tr>
              <td style="padding:10px 24px 12px;">
                <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td style="border-radius:7px;background:#111111;">
                      <a href="{{ $declarationUrl }}"
                         target="_blank" rel="noopener"
                         style="display:inline-block;padding:12px 18px;font:600 14px/1 Arial,Helvetica,'Segoe UI',sans-serif;color:#ffffff;text-decoration:none;border-radius:7px;">
                        Fill the Buying Declaration Form
                      </a>
                    </td>
                  </tr>
                </table>
                <div style="font:400 12px/1.6 Arial,Helvetica,'Segoe UI',sans-serif;color:#667085;margin-top:8px;">
                  Required to complete your purchase.
                </div>
              </td>
            </tr>
            @endunless

            <!-- Divider -->
            <tr>
              <td style="padding:0 24px;">
                <hr style="border:0;border-top:1px solid #eef1f5;height:1px;margin:12px 0;">
              </td>
            </tr>

            <!-- Order meta -->
            <tr>
              <td style="padding:8px 24px 0;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                       style="border:1px solid #eef1f5;border-radius:8px;">
                  <tr>
                    <td style="padding:12px 14px;font:400 13px/1.7 Arial,Helvetica,'Segoe UI',sans-serif;color:#334155;">
                      <strong>Order #:</strong> {{ $order->order_no }}<br>
                      <strong>Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}<br>
                      <strong>Status:</strong> {{ ucfirst($order->status) }}<br>
                      <strong>Total:</strong> £{{ number_format((float)$order->total_gbp, 2) }}
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <!-- Items -->
            <tr>
              <td style="padding:18px 24px 8px;">
                <div style="font:600 14px/1.4 Arial,Helvetica,'Segoe UI',sans-serif;color:#0f172a;margin:0 0 8px;">
                  Order Items
                </div>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;">
                  <thead>
                    <tr>
                      <th align="left"  style="font:600 12px Arial,Helvetica,'Segoe UI',sans-serif;color:#334155;background:#f7f8fa;padding:10px;border:1px solid #eef1f5;width:38px;">#</th>
                      <th align="left"  style="font:600 12px Arial,Helvetica,'Segoe UI',sans-serif;color:#334155;background:#f7f8fa;padding:10px;border:1px solid #eef1f5;">Item</th>
                      <th align="right" style="font:600 12px Arial,Helvetica,'Segoe UI',sans-serif;color:#334155;background:#f7f8fa;padding:10px;border:1px solid #eef1f5;width:70px;">Qty</th>
                      <th align="right" style="font:600 12px Arial,Helvetica,'Segoe UI',sans-serif;color:#334155;background:#f7f8fa;padding:10px;border:1px solid #eef1f5;width:110px;">Unit (GBP)</th>
                      <th align="right" style="font:600 12px Arial,Helvetica,'Segoe UI',sans-serif;color:#334155;background:#f7f8fa;padding:10px;border:1px solid #eef1f5;width:120px;">Line Total</th>
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
                        <td align="right" style="padding:10px;border:1px solid #eef1f5;font:400 12px Arial,Helvetica,'Segoe UI',sans-serif;color:#334155;">{{ $i+1 }}</td>
                        <td align="left"  style="padding:10px;border:1px solid #eef1f5;font:400 12px Arial,Helvetica,'Segoe UI',sans-serif;color:#334155;">
                          {{ $item->title ?? $item->name ?? 'Item' }}
                        </td>
                        <td align="right" style="padding:10px;border:1px solid #eef1f5;font:400 12px Arial,Helvetica,'Segoe UI',sans-serif;color:#334155;">{{ $qty }}</td>
                        <td align="right" style="padding:10px;border:1px solid #eef1f5;font:400 12px Arial,Helvetica,'Segoe UI',sans-serif;color:#334155;">{{ number_format($unit, 2) }}</td>
                        <td align="right" style="padding:10px;border:1px solid #eef1f5;font:600 12px Arial,Helvetica,'Segoe UI',sans-serif;color:#0f172a;">{{ number_format($line, 2) }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </td>
            </tr>

            <!-- Totals -->
            <tr>
              <td style="padding:8px 24px 24px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td align="right" style="padding:8px 0;font:400 13px Arial,Helvetica,'Segoe UI',sans-serif;color:#475569;">
                      @if(!is_null($order->subtotal_gbp))
                        Subtotal: £{{ number_format((float)$order->subtotal_gbp, 2) }}<br>
                      @endif
                      @if(!is_null($order->vat_gbp))
                        VAT: £{{ number_format((float)$order->vat_gbp, 2) }}<br>
                      @endif
                      <strong style="color:#0f172a;">Total: £{{ number_format((float)($order->total_gbp ?? $calcTotal), 2) }}</strong>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <!-- Footer -->
            <tr>
              <td style="padding:16px 24px;background:#f9fafb;">
                @if($toAdmin)
                  <div style="font:400 12px/1.6 Arial,Helvetica,'Segoe UI',sans-serif;color:#64748b;">
                    Customer: {{ $order->customer_name ?? $order->user?->name ?? '—' }}
                    ({{ $order->customer_email ?? $order->user?->email ?? '—' }})
                  </div>
                @else
                  <div style="font:400 12px/1.6 Arial,Helvetica,'Segoe UI',sans-serif;color:#64748b;">
                    If you have any questions, reply to this email. Thanks for shopping with {{ $appName ?? config('app.name') }}!
                  </div>
                @endif
              </td>
            </tr>
          </table>

          <!-- tiny spacer -->
          <div style="height:12px;line-height:12px;">&zwj;</div>

          <!-- Brand footer line -->
          <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="max-width:640px;">
            <tr>
              <td align="center" style="font:400 11px/1.6 Arial,Helvetica,'Segoe UI',sans-serif;color:#94a3b8;">
                © {{ date('Y') }} {{ $appName ?? config('app.name') }}. All rights reserved.
              </td>
            </tr>
          </table>

        </td>
      </tr>
    </table>
  </center>
</body>
</html>
