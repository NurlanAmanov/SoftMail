<!DOCTYPE html>
<html lang="az">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
{{-- 
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('/img/logo.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('/img/logo.png') }}"> --}}
  
  <title>
    {{ ucfirst(Request::segment(2) ?? 'Mail Panel') }} — Adminity X
  </title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <link href="{{ asset('css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/main.css') }}" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:wght@300;400;700" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  {{-- Quill CDN --}}
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">

  <link id="pagestyle" href="{{ asset('css/material-dashboard.css?v=3.2.0') }}" rel="stylesheet" />

  <style>
    /* Apple-style Təmiz Fon */
    body {
      background-color: #f8fafc !important; /* Çox yüngül boz/mavi fon */
      color: #334155;
      font-family: 'Inter', sans-serif;
    }

    /* Minimalist Scrollbar */
    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }
    ::-webkit-scrollbar-track {
      background: transparent;
    }
    ::-webkit-scrollbar-thumb {
      background: #e2e8f0;
      border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #cbd5e1;
    }

    /* Main Content Sahəsi */
    .main-content {
      background-color: transparent;
      padding-top: 20px;
    }

    /* Header və Menu üçün xüsusi toxunuş (əgər daxildə ağ fon lazımdırsa) */
    .navbar-vertical {
      background: #ffffff !important;
      border-right: 1px solid #f1f5f9 !important;
    }

    /* Kartların ümumi estetikası */
    .card {
      border: 1px solid #f1f5f9 !important;
      box-shadow: 0 1px 3px rgba(0,0,0,0.02) !important;
      border-radius: 16px !important;
    }
  </style>
  
  @stack('styles')
</head>

<body class="g-sidenav-show bg-gray-100">
  
  @include('frontend.inc.header')

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    @include('frontend.inc.menu')
    
    <div class="container-fluid py-4">
      @yield('content')
    </div>

    @include('frontend.inc.footer')
  </main>

  <script src="{{ asset('js/core/popper.min.js') }}"></script>
  <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('js/plugins/chartjs.min.js') }}"></script>

  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = { damping: '0.5' };
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>

  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="{{ asset('js/material-dashboard.min.js?v=3.2.0') }}"></script>
  
  <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

  @stack('scripts')
</body>

</html>