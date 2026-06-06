<!DOCTYPE html>
<html lang="az">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $title }}</title>
</head>
<body style="margin:0;padding:0;background-color:#EFF6FF;font-family:'Segoe UI',Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#EFF6FF;padding:40px 0;">
  <tr>
    <td align="center">
      <table width="580" cellpadding="0" cellspacing="0" style="max-width:580px;width:100%;">

        {{-- TOP WAVE HEADER --}}
        <tr>
          <td style="background:#1D4ED8;border-radius:20px 20px 0 0;padding:0;overflow:hidden;">
            <table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td style="padding:40px 40px 0;text-align:center;">
                  <div style="width:72px;height:72px;background:rgba(255,255,255,0.15);border-radius:50%;margin:0 auto 16px;display:inline-block;line-height:72px;font-size:32px;">
                    👋
                  </div>
                  <h1 style="margin:0;color:#ffffff;font-size:28px;font-weight:700;letter-spacing:-0.5px;">Xoş Gəldiniz!</h1>
                  <p style="margin:8px 0 0;color:#BFDBFE;font-size:15px;">Sizinlə olmaqdan məmnunuq</p>
                </td>
              </tr>
              <tr>
                <td style="padding:0;line-height:0;">
                  <svg viewBox="0 0 580 50" xmlns="http://www.w3.org/2000/svg" style="display:block;width:100%;">
                    <path d="M0,20 Q145,50 290,25 Q435,0 580,30 L580,50 L0,50 Z" fill="#EFF6FF"/>
                  </svg>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        {{-- BODY --}}
        <tr>
          <td style="background:#ffffff;padding:10px 40px 36px;border-left:1px solid #DBEAFE;border-right:1px solid #DBEAFE;">

            <h2 style="margin:0 0 16px;color:#1e3a8a;font-size:20px;font-weight:600;">{{ $title }}</h2>
            <p style="margin:0 0 24px;color:#475569;font-size:15px;line-height:1.8;">{!! $body !!}</p>

            @if(!empty($phoneLine))
            <div style="background:#EFF6FF;border-left:4px solid #3B82F6;border-radius:0 10px 10px 0;padding:14px 18px;margin-bottom:24px;font-size:14px;color:#1D4ED8;">
                {!! $phoneLine !!}
            </div>
            @endif

            <table cellpadding="0" cellspacing="0" style="margin:0 auto;">
              <tr>
                <td style="background:#1D4ED8;border-radius:50px;padding:0;">
                  <a href="{{ $btnUrl }}" style="display:inline-block;padding:14px 36px;color:#ffffff;font-weight:700;font-size:15px;text-decoration:none;letter-spacing:0.3px;">
                    {{ $btnText }} →
                  </a>
                </td>
              </tr>
            </table>

          </td>
        </tr>

        {{-- DIVIDER WITH DOTS --}}
        <tr>
          <td style="background:#ffffff;padding:0 40px;border-left:1px solid #DBEAFE;border-right:1px solid #DBEAFE;">
            <div style="border-top:1px dashed #BFDBFE;padding:20px 0;text-align:center;">
              <span style="display:inline-block;width:8px;height:8px;background:#BFDBFE;border-radius:50%;margin:0 3px;"></span>
              <span style="display:inline-block;width:8px;height:8px;background:#93C5FD;border-radius:50%;margin:0 3px;"></span>
              <span style="display:inline-block;width:8px;height:8px;background:#BFDBFE;border-radius:50%;margin:0 3px;"></span>
            </div>
          </td>
        </tr>

        {{-- FOOTER --}}
        <tr>
          <td style="background:#1D4ED8;border-radius:0 0 20px 20px;padding:24px 40px;text-align:center;">
            <p style="margin:0;color:#93C5FD;font-size:13px;">© 2025 · Bütün hüquqlar qorunur</p>
            <p style="margin:6px 0 0;color:#60A5FA;font-size:12px;">Bu emaili siz qeydiyyat zamanı aldınız.</p>
          </td>
        </tr>

      </table>
    </td>
  </tr>
</table>

</body>
</html>