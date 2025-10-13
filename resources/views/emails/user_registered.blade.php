@if($toAdmin)
<h2 style="margin:0 0 10px;font-weight:600;">New user registration</h2>
<p style="margin:0 0 12px;">
    A new user has just created an account on <strong>{{ $appName ?? config('app.name') }}</strong>.
</p>

<table role="presentation" cellpadding="0" cellspacing="0" style="width:100%;max-width:520px;margin:10px 0 16px;border-collapse:collapse;">
    <tr>
        <td style="padding:6px 0;color:#555;">Name</td>
        <td style="padding:6px 0;"><strong>{{ $user->name }}</strong></td>
    </tr>
    <tr>
        <td style="padding:6px 0;color:#555;">Email</td>
        <td style="padding:6px 0;"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
    </tr>
    <tr>
        <td style="padding:6px 0;color:#555;">Registered at</td>
        <td style="padding:6px 0;">{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
    </tr>
    @if(!empty($userIP) || !empty($userAgent))
    <tr>
        <td style="padding:6px 0;color:#555;">Sign-up details</td>
        <td style="padding:6px 0;">
            @if(!empty($userIP)) IP: {{ $userIP }} @endif
            @if(!empty($userIP) && !empty($userAgent)) &nbsp;•&nbsp; @endif
            @if(!empty($userAgent)) UA: {{ $userAgent }} @endif
        </td>
    </tr>
    @endif
</table>

@if(!empty($adminViewUrl))
<p style="margin:0 0 16px;">
    <a href="{{ $adminViewUrl }}"
        style="display:inline-block;background:#0d6efd;color:#fff;text-decoration:none;padding:10px 14px;border-radius:6px;">
        View user in dashboard
    </a>
</p>
@endif

<p style="margin:0;color:#666;">
    You’re receiving this because you’re an admin on {{ $appName ?? config('app.name') }}.
    If this wasn’t expected, please review your invite and access settings.
</p>
@else
<h2 style="margin:0 0 10px;font-weight:600;">Welcome to {{ $appName ?? config('app.name') }}, {{ $user->name }}!</h2>

<p>Thanks for joining us — we’re thrilled you’re here.</p>
<p>Click below to log in and start exploring.</p>
<p>
  <a href="{{ $loginUrl }}" style="display:inline-block;background:#111827;color:#fff;
     text-decoration:none;padding:10px 14px;border-radius:6px;">Go to login</a>
</p>


<hr style="border:none;border-top:1px solid #eee;margin:16px 0;">

<p style="margin:0 0 8px;color:#666;">
    Need help? Reply to this email or contact us at
    <a href="mailto:{{ $supportEmail ?? 'support@' . parse_url(config('app.url'), PHP_URL_HOST) }}">
        {{ $supportEmail ?? 'Support' }}
    </a>.
</p>
<p style="margin:0;color:#999;font-size:12px;">
    If you didn’t create this account, you can ignore this email.
</p>
@endif