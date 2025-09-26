@if ($toAdmin)
  <h2 style="margin:0 0 8px;">New contact form submission</h2>
  <p><strong>Name:</strong> {{ $c->name }}</p>
  <p><strong>Email:</strong> {{ $c->email }}</p>
  <p><strong>Mobile:</strong> {{ $c->mobile ?: '—' }}</p>
  <p><strong>Message:</strong><br>{{ $c->message ?: '—' }}</p>
  <p style="color:#666;margin-top:12px;">
    IP: {{ $c->ip ?? '—' }}<br>
    UA: {{ $c->user_agent ?? '—' }}
  </p>
@else
  <h2 style="margin:0 0 8px;">Thanks, {{ $c->name }}</h2>
  <p>We’ve received your message and will get back to you soon.</p>
  <p><strong>Your message:</strong><br>{{ $c->message ?: '—' }}</p>
  <p style="color:#666;margin-top:12px;">— {{ $appName }}</p>
@endif
