<!DOCTYPE html>
<html lang="az">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $title }}</title>
</head>
<body style="margin:0;padding:0;background-color:#FFF1F2;font-family:'Segoe UI',Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#FFF1F2;padding:40px 0;">
  <tr>
    <td align="center">
      <table width="580" cellpadding="0" cellspacing="0" style="max-width:580px;width:100%;">

        {{-- TOP ALERT STRIPE --}}
        <tr>
          <td style="background:#DC2626;border-radius:20px 20px 0 0;padding:10px 40px;text-align:center;">
            <span style="color:#FCA5A5;font-size:12px;font-weight:700;letter-spacing:3px;text-transform:uppercase;">⚠ TƏCİLİ BİLDİRİŞ ⚠</span>
          </td>
        </tr>

        {{-- MAIN HEADER --}}
        <tr>
          <td style="background:#EF4444;padding:36px 40px 40px;text-align:center;">
            <div style="width:76px;height:76px;background:#DC2626;border:3px solid rgba(255,255,255,0.25);border-radius:50%;margin:0 auto 20px;display:inline-block;line-height:70px;font-size:34px;">
              🚨
            </div>
            <h1 style="margin:0;color:#ffffff;font-size:26px;font-weight:800;line-height:1.3;">{{ $title }}</h1>
          </td>
        </tr>

        {{-- ZIGZAG SEPARATOR --}}
        <tr>
          <td style="padding:0;line-height:0;">
            <svg viewBox="0 0 580 20" xmlns="http://www.w3.org/2000/svg" style="display:block;width:100%;background:#ffffff;">
              <polyline points="0,0 29,20 58,0 87,20 116,0 145,20 174,0 203,20 232,0 261,20 290,0 319,20 348,0 377,20 406,0 435,20 464,0 493,20 522,0 551,20 580,0" fill="none" stroke="#EF4444" stroke-width="2"/>
              <polygon points="0,0 580,0 580,0 0,0" fill="#EF4444"/>
            </svg>
            <div style="height:20px;background:#EF4444;margin-top:-1px;"></div>
            <svg viewBox="0 0 580 20" xmlns="http://www.w3.org/2000/svg" style="display:block;width:100%;">
              <polyline points="0,0 29,20 58,0 87,20 116,0 145,20 174,0 203,20 232,0 261,20 290,0 319,20 348,0 377,20 406,0 435,20 464,0 493,20 522,0 551,20 580,0" fill="none" stroke="#EF4444" stroke-width="2"/>
            </svg>
          </td>
        </tr>

        {{-- BODY --}}
        <tr>
          <td style="background:#ffffff;padding:32px 40px;border-left:1px solid #FEE2E2;border-right:1px solid #FEE2E2;">

            {{-- WARNING BOX --}}
            <div style="background:#FEF2F2;border:2px solid #FECACA;border-radius:12px;padding:16px 20px;margin-bottom:24px;">
              <div style="font-size:13px;font-weight:700;color:#DC2626;margin-bottom:6px;text-transform:uppercase;letter-spacing:1px;">Diqqət!</div>
              <p style="margin:0;color:#374151;font-size:15px;line-height:1.75;">{!! $body !!}</p>
            </div>

            @if(!empty($phoneLine))
            <div style="background:#FFF1F2;border-left:4px solid #EF4444;border-radius:0 10px 10px 0;padding:14px 18px;margin-bottom:24px;font-size:14px;color:#DC2626;">
                {!! $phoneLine !!}
            </div>
            @endif

            <table cellpadding="0" cellspacing="0" width="100%">
              <tr>
                <td style="background:#DC2626;border-radius:12px;text-align:center;">
                  <a href="{{ $btnUrl }}" style="display:block;padding:16px 36px;color:#ffffff;font-weight:800;font-size:16px;text-decoration:none;">
                    {{ $btnText }} ›
                  </a>
                </td>
              </tr>
            </table>

          </td>
        </tr>

        {{-- FOOTER --}}
        <tr>
          <td style="background:#1F2937;border-radius:0 0 20px 20px;padding:22px 40px;text-align:center;">
            <p style="margin:0;color:#9CA3AF;font-size:13px;">© 2025 · Bütün hüquqlar qorunur</p>
            <p style="margin:6px 0 0;color:#6B7280;font-size:12px;">Bu vacib bildiriş avtomatik göndərilmişdir.</p>
          </td>
        </tr>

      </table>
    </td>
  </tr>
</table>

</body>
</html>