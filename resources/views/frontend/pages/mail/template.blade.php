<!DOCTYPE html>
<html lang="az">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $title }}</title>
</head>
<body style="margin:0;padding:0;background-color:#F0FDF4;font-family:'Segoe UI',Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#F0FDF4;padding:40px 0;">
  <tr>
    <td align="center">
      <table width="580" cellpadding="0" cellspacing="0" style="max-width:580px;width:100%;">

        {{-- HEADER - Bold kampaniya banner --}}
        <tr>
          <td style="background:linear-gradient(135deg,#059669 0%,#10B981 50%,#34D399 100%);border-radius:20px 20px 0 0;padding:44px 40px 36px;text-align:center;position:relative;">
            <div style="background:rgba(255,255,255,0.12);display:inline-block;padding:6px 18px;border-radius:30px;margin-bottom:16px;">
              <span style="color:#ffffff;font-size:12px;font-weight:700;letter-spacing:2px;text-transform:uppercase;">🔥 Kampaniya</span>
            </div>
            <h1 style="margin:0 0 10px;color:#ffffff;font-size:32px;font-weight:800;letter-spacing:-1px;line-height:1.2;">{{ $title }}</h1>
            <p style="margin:0;color:#D1FAE5;font-size:15px;">Fırsatı qaçırmayın!</p>
          </td>
        </tr>

        {{-- DIAGONAL CUT --}}
        <tr>
          <td style="padding:0;line-height:0;background:#ffffff;">
            <svg viewBox="0 0 580 30" xmlns="http://www.w3.org/2000/svg" style="display:block;width:100%;">
              <polygon points="0,0 580,0 580,30 0,0" fill="#10B981"/>
            </svg>
          </td>
        </tr>

        {{-- BODY --}}
        <tr>
          <td style="background:#ffffff;padding:8px 40px 32px;border-left:1px solid #D1FAE5;border-right:1px solid #D1FAE5;">

            <p style="margin:0 0 24px;color:#374151;font-size:15px;line-height:1.8;">{!! $body !!}</p>

            @if(!empty($phoneLine))
            <div style="background:#F0FDF4;border:1px solid #A7F3D0;border-radius:12px;padding:14px 18px;margin-bottom:24px;font-size:14px;color:#065F46;">
                {!! $phoneLine !!}
            </div>
            @endif

            {{-- BIG CTA BUTTON --}}
            <table cellpadding="0" cellspacing="0" width="100%">
              <tr>
                <td style="background:#059669;border-radius:14px;text-align:center;box-shadow:0 8px 20px rgba(5,150,105,0.3);">
                  <a href="{{ $btnUrl }}" style="display:block;padding:18px 36px;color:#ffffff;font-weight:800;font-size:17px;text-decoration:none;letter-spacing:0.5px;">
                    🛒 {{ $btnText }}
                  </a>
                </td>
              </tr>
            </table>

            <p style="text-align:center;margin:16px 0 0;font-size:12px;color:#9CA3AF;">Linki kopyalayın: <span style="color:#059669;">{{ $btnUrl }}</span></p>

          </td>
        </tr>

        {{-- STATS BAR --}}
        <tr>
          <td style="background:#ECFDF5;padding:18px 40px;border-left:1px solid #D1FAE5;border-right:1px solid #D1FAE5;">
            <table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td style="text-align:center;border-right:1px solid #A7F3D0;padding:0 10px;">
                  <div style="font-size:20px;font-weight:800;color:#059669;">24/7</div>
                  <div style="font-size:11px;color:#6B7280;">Dəstək</div>
                </td>
                <td style="text-align:center;border-right:1px solid #A7F3D0;padding:0 10px;">
                  <div style="font-size:20px;font-weight:800;color:#059669;">100%</div>
                  <div style="font-size:11px;color:#6B7280;">Təhlükəsiz</div>
                </td>
                <td style="text-align:center;padding:0 10px;">
                  <div style="font-size:20px;font-weight:800;color:#059669;">✓</div>
                  <div style="font-size:11px;color:#6B7280;">Zəmanət</div>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        {{-- FOOTER --}}
        <tr>
          <td style="background:#059669;border-radius:0 0 20px 20px;padding:22px 40px;text-align:center;">
            <p style="margin:0;color:#A7F3D0;font-size:13px;">© 2025 · Bütün hüquqlar qorunur</p>
          </td>
        </tr>

      </table>
    </td>
  </tr>
</table>

</body>
</html>