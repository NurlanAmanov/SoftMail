<!doctype html>
<html lang="az">
<head>
  <meta charset="utf-8">
  <title>SoftMail X | Smart Email Marketing System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
  <style>
    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background-color: #f8fafc;
    }
    .info-side {
      background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    }
    .input-field {
      border: 1px solid #e2e8f0;
      transition: all 0.2s ease;
    }
    .input-field:focus {
      outline: none;
      border-color: #13b999;
      box-shadow: 0 0 0 3px rgba(19, 185, 153, 0.1);
    }
    .btn-primary {
      background: #13b999;
      transition: all 0.3s ease;
    }
    .btn-primary:hover {
      background: #10a085;
      transform: translateY(-1px);
    }
    .feature-card {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center">

  <div class="flex flex-col md:flex-row w-full min-h-screen">
    
    <!-- Sol Panel: Məlumat hissəsi -->
    <div class="info-side w-full md:w-1/2 flex flex-col justify-center p-12 text-white">
      <div class="max-w-md mx-auto">
        <div class="mb-8">
          <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-xs font-semibold tracking-wider uppercase">
            SoftMailX
          </span>
        </div>
        
        <h2 class="text-4xl font-bold mb-6 leading-tight">
          Ağıllı Toplu Mail <br> İdarəetmə Sistemi
        </h2>
        
        <p class="text-slate-400 text-lg mb-10">
          Kampaniyalarınızı planlaşdırın, çatdırılma analitikasını izləyin və müştərilərinizlə daha effektiv əlaqə qurun.
        </p>

        <div class="space-y-4">
          <div class="feature-card p-4 rounded-xl flex items-start gap-4">
            <div class="text-green-400">✓</div>
            <div>
              <h4 class="font-medium">Yüksək Çatdırılma Sürəti</h4>
              <p class="text-sm text-slate-500">Amazon SES və Mailgun inteqrasiyası ilə maillər spama düşmür.</p>
            </div>
          </div>
          
          <div class="feature-card p-4 rounded-xl flex items-start gap-4">
            <div class="text-green-400">✓</div>
            <div>
              <h4 class="font-medium">Canlı Analitika</h4>
              <p class="text-sm text-slate-500">Açılma və klikləmə dərəcələrini real-vaxt rejimində izləyin.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Sağ Panel: Login Formu -->
    <div class="w-full md:w-1/2 bg-white flex items-center justify-center p-8">
      <div class="w-full max-w-sm">
        
        <div class="mb-10">
          <h1 class="text-2xl font-bold text-slate-900 mb-2">Giriş edin</h1>
          <p class="text-slate-500">Sistemə daxil olmaq üçün məlumatlarınızı daxil edin.</p>
        </div>

        @if(session('error') || $errors->any())
          <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded">
            E-poçt və ya şifrə yanlışdır.
          </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-6">
          @csrf
          
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">E-poçt ünvanı</label>
            <input 
              type="email" 
              name="email" 
              required 
              class="input-field w-full px-4 py-3 rounded-lg text-slate-900 bg-white" 
              placeholder="nurlan@softlink.az"
            >
          </div>

          <div>
            <div class="flex justify-between mb-2">
              <label class="block text-sm font-medium text-slate-700">Parol</label>
            </div>
            <input 
              type="password" 
              name="password" 
              required 
              class="input-field w-full px-4 py-3 rounded-lg text-slate-900 bg-white" 
              placeholder="••••••••"
            >
          </div>

          <div class="flex items-center">
            <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-green-600 border-gray-300 rounded">
            <label for="remember" class="ml-2 block text-sm text-slate-600">Məni xatırla</label>
          </div>

          <button type="submit" class="btn-primary w-full text-white font-semibold py-3 rounded-lg shadow-md">
            Sistemə daxil ol
          </button>
        </form>

        <div class="mt-8 text-center text-sm text-slate-400">
          &copy; 2026 SoftMail X. Bütün hüquqlar qorunur.
        </div>
      </div>
    </div>

  </div>

</body>
</html>