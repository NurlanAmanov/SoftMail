<?php
// ---------- SETTINGS ----------
$apiKey = "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";             // Brevo API key
$senderName  = "Soft Tech";
$senderEmail = "nurlanemenov14@gmail.com";    // Brevo-da təsdiqlənmiş olmalıdır
// --------------------------------

session_start();
$responseMsg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $subject      = trim($_POST["subject"] ?? "");
  $title        = trim($_POST["title"] ?? "");
  $body         = trim($_POST["body"] ?? "");
  $btnText      = trim($_POST["btn_text"] ?? "Kampaniyaya bax");
  $btnUrl       = trim($_POST["btn_url"] ?? "https://example.com");
  $phone        = trim($_POST["phone"] ?? "");
  $recipientsIn = trim($_POST["recipients"] ?? "");

  // Alıcıları hazırla
  $to = [];
  foreach (explode(",", $recipientsIn) as $e) {
    $e = trim($e);
    if (filter_var($e, FILTER_VALIDATE_EMAIL)) {
      $to[] = ["email" => $e];
    }
  }
  if (!$to) $responseMsg = "<p style='color:#c00'>Düzgün alıcı email(ler)i daxil et.</p>";

  if (empty($responseMsg)) {
    $phoneLine = $phone ? "📞 Əlavə suallar üçün: <strong>".htmlspecialchars($phone, ENT_QUOTES, 'UTF-8')."</strong>" : "";

    $safeBody   = nl2br(htmlspecialchars($body, ENT_QUOTES, 'UTF-8'));
    $safeTitle  = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $safeBtnTxt = htmlspecialchars($btnText, ENT_QUOTES, 'UTF-8');
    $safeBtnUrl = htmlspecialchars($btnUrl, ENT_QUOTES, 'UTF-8');

    // Mail şablonu (IMG yoxdur, sadəcə "Goafaz")
    $html = <<<HTML
<!DOCTYPE html>
<html lang="az"><head><meta charset="UTF-8"></head>
<body style="margin:0;background:#efefef;font-family:Arial,Helvetica,sans-serif;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#efefef;padding:20px 0;">
    <tr>
      <td align="center">
        <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="background:#ffffff;border-radius:8px;overflow:hidden;">
          <tr>
            <td style="background:#111;padding:20px;text-align:center;">
              <div style="color:#ff9800; font-size:24px; font-weight:800;">Goafaz</div>
            </td>
          </tr>
          <tr>
            <td style="padding:28px 24px;">
              <h2 style="margin:0 0 18px 0;color:#ff9800;font-size:22px;font-weight:800;">$safeTitle</h2>
              <p style="margin:0 0 20px 0;color:#444;line-height:1.7;">$safeBody</p>
              <p style="text-align:center;margin:24px 0;">
                <a href="$safeBtnUrl" style="background:#ff9800;color:#fff;text-decoration:none;
                   padding:12px 24px;border-radius:6px;font-weight:700;display:inline-block;">
                  $safeBtnTxt
                </a>
              </p>
              <p style="margin:18px 0;color:#555;line-height:1.6;">$phoneLine</p>
              <p style="margin:14px 0;color:#666;line-height:1.6;">
                Unutmayın, bu fürsət <em>məhdud zaman</em> üçün nəzərdə tutulub! ⚡
              </p>
              <p style="margin-top:26px;color:#222;">Hörmətlə,<br><strong>Goafaz komandası</strong></p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body></html>
HTML;

    // Brevo API çağırışı
    $payload = [
      "sender"      => ["name" => $senderName, "email" => $senderEmail],
      "to"          => $to,
      "subject"     => $subject,
      "htmlContent" => $html
    ];

    $ch = curl_init("https://api.brevo.com/v3/smtp/email");
    curl_setopt_array($ch, [
      CURLOPT_HTTPHEADER     => ["accept: application/json","api-key: $apiKey","content-type: application/json"],
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_POST           => true,
      CURLOPT_POSTFIELDS     => json_encode($payload, JSON_UNESCAPED_UNICODE)
    ]);
    $res = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    $responseMsg = $err
      ? "<p style='color:#c00'>Xəta: $err</p>"
      : "<pre style='white-space:pre-wrap;background:#f7f7f7;padding:10px;border:1px solid #ddd;border-radius:6px;'>$res</pre>";
  }
}
?>
<!DOCTYPE html>
<html lang="az">
<head>
  <meta charset="UTF-8">
  <title>Mail Göndəriş Paneli</title>
  <style>
    body{font-family:Arial,Helvetica,sans-serif;background:#f4f6f8;margin:40px}
    .card{max-width:880px;margin:0 auto;background:#fff;padding:20px 22px;border-radius:12px;box-shadow:0 6px 24px rgba(0,0,0,.06)}
    .row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
    label{font-weight:600;margin-top:10px;display:block}
    input[type=text],input[type=url],textarea{width:100%;padding:10px;border:1px solid #d9dee3;border-radius:8px}
    textarea{min-height:110px}
    button{background:#ff9800;color:#fff;border:0;padding:12px 18px;border-radius:8px;cursor:pointer;font-weight:700}
    button:hover{opacity:.9}
  </style>
</head>
<body>
  <div class="card">
    <h2>📤 Kampaniya Maili (Şəkilsiz)</h2>
    <?= $responseMsg ?>
    <form method="post">
      <label>Subject</label>
      <input type="text" name="subject" placeholder="Xüsusi təklif – yalnız məhdud müddət!" required>

      <div class="row">
        <div>
          <label>Başlıq</label>
          <input type="text" name="title" value="Xüsusi təklif – yalnız məhdud müddət!" required>
        </div>
        <div>
          <label>Telefon (opsional)</label>
          <input type="text" name="phone" placeholder="051 999 91 99">
        </div>
      </div>

      <label>Əsas məzmun</label>
      <textarea name="body" placeholder="Artıq 170 müxtəlif məhsulu cəmi 3 AZN-ə əldə edə bilərsiniz..." required></textarea>

      <div class="row">
        <div>
          <label>Düymə mətni</label>
          <input type="text" name="btn_text" value="Kampaniyaya bax">
        </div>
        <div>
          <label>Düymə linki</label>
          <input type="url" name="btn_url" value="https://goafaz.com">
        </div>
      </div>

      <label>Qəbulçular (vergül ilə)</label>
      <textarea name="recipients" placeholder="mail1@example.com, mail2@example.com" required></textarea>

      <br><br>
      <button type="submit">Göndər</button>
    </form>
  </div>
</body>
</html>
