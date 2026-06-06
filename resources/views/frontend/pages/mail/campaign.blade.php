<!DOCTYPE html>
<html lang="az">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $title }}</title>
</head>
<body style="margin:0;padding:0;background-color:#1E1B4B;font-family:'Segoe UI',Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#1E1B4B;padding:40px 0;">
  <tr>
    <td align="center">
      <table width="580" cellpadding="0" cellspacing="0" style="max-width:580px;width:100%;">

        {{-- PREMIUM DARK HEADER --}}
        <tr>
          <td style="background:#312E81;border-radius:20px 20px 0 0;padding:48px 40px 44px;text-align:center;border-top:3px solid #818CF8;">

            {{-- Tag badge --}}
            <div style="display:inline-block;background:rgba(129,140,248,0.15);border:1px solid rgba(129,140,248,0.4);border-radius:30px;padding:5px 16px;margin-bottom:20px;">
              <span style="color:#A5B4FC;font-size:12px;font-weight:600;letter-spacing:2px;text-transform:uppercase;">✦ Premium Təklif</span>
            </div>

            <h1 style="margin:0 0 12px;color:#F5F3FF;font-size:30px;font-weight:800;letter-spacing:-0.5px;line-height:1.25;">{{ $title }}</h1>
            <p style="margin:0;color:#A5B4FC;font-size:15px;">Xüsusi müştərilərimiz üçün</p>

            {{-- Decorative line --}}
            <div style="width:60px;height:3px;background:linear-gradient(90deg,#818CF8,#C4B5FD);border-radius:3px;margin:20px auto 0;"></div>

          </td>
        </tr>

        {{-- BODY --}}
        <tr>
          <td style="background:#1E1B4B;padding:36px 40px 32px;border-left:1px solid #312E81;border-right:1px solid #312E81;">

            <p style="margin:0 0 28px;color:#C4B5FD;font-size:15px;line-height:1.8;">{!! $body !!}</p>

            @if(!empty($phoneLine))
            <div style="background:rgba(129,140,248,0.1);border:1px solid rgba(129,140,248,0.3);border-radius:12px;padding:14px 18px;margin-bottom:28px;font-size:14px;color:#A5B4FC;">
                {!! $phoneLine !!}
            </div>
            @endif

            {{-- PREMIUM CTA --}}
            <table cellpadding="0" cellspacing="0" width="100%">
              <tr>
                <td style="border-radius:14px;text-align:center;padding:2px;background:linear-gradient(135deg,#818CF8,#A78BFA,#C4B5FD);">
                  <table cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                      <td style="background:#312E81;border-radius:12px;text-align:center;">
                        <a href="{{ $btnUrl }}" style="display:block;padding:16px 36px;color:#E0E7FF;font-weight:700;font-size:16px;text-decoration:none;letter-spacing:0.5px;">
                          {{ $btnText }} ✦
                        </a>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>

          </td>
        </tr>

        {{-- FEATURE ROW --}}
        <tr>
          <td style="background:#16133E;padding:20px 40px;border-left:1px solid #312E81;border-right:1px solid #312E81;">
            <table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td style="text-align:center;padding:0 8px;">
                  <div style="font-size:18px;margin-bottom:4px;">💎</div>
                  <div style="font-size:11px;color:#7C3AED;font-weight:600;text-transform:uppercase;letter-spacing:1px;">Premium</div>
                </td>
                <td style="text-align:center;padding:0 8px;border-left:1px solid #312E81;border-right:1px solid #312E81;">
                  <div style="font-size:18px;margin-bottom:4px;">⚡</div>
                  <div style="font-size:11px;color:#7C3AED;font-weight:600;text-transform:uppercase;letter-spacing:1px;">Sürətli</div>
                </td>
                <td style="text-align:center;padding:0 8px;">
                  <div style="font-size:18px;margin-bottom:4px;">🔐</div>
                  <div style="font-size:11px;color:#7C3AED;font-weight:600;text-transform:uppercase;letter-spacing:1px;">Güvənli</div>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        {{-- FOOTER --}}
        <tr>
          <td style="background:#0F0D2E;border-radius:0 0 20px 20px;padding:24px 40px;text-align:center;border-top:1px solid #312E81;">
            <p style="margin:0;color:#4C1D95;font-size:13px;">© 2025 · Bütün hüquqlar qorunur</p>
            <p style="margin:6px 0 0;color:#3730A3;font-size:12px;">Bu emaili siz xüsusi müştəri olaraq aldınız.</p>
          </td>
        </tr>

      </table>
    </td>
  </tr>
</table>

</body>
</html>