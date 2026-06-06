<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style>
  /* Sidebar Apple/Stripe Polish */
  #sidenav-main {
    background: #ffffff !important;
    border-right: 1px solid #f1f5f9 !important;
    box-shadow: none !important;
  }

  #sidenav-main .nav-link {
    border-radius: 12px;
    padding: 0.7rem 1rem;
    transition: all 0.2s ease;
    color: #64748b !important; /* Slate 500 */
    margin: 2px 12px;
  }

  #sidenav-main .nav-link:hover {
    background: #f8fafc;
    color: #1e293b !important;
  }

  #sidenav-main .nav-link.active {
    background: #f1f5f9 !important;
    color: #13b999 !important; /* Sənin yaşıl rəngin */
    font-weight: 600;
  }

  #sidenav-main .nav-link.active i, 
  #sidenav-main .nav-link.active .material-symbols-rounded {
    color: #13b999 !important;
  }

  .material-symbols-rounded {
    font-size: 20px;
    vertical-align: middle;
  }

  /* Submenu styling */
  .submenu .nav-link {
    font-size: 0.85rem;
    padding-left: 3rem !important;
    color: #94a3b8 !important;
  }

  .submenu .nav-link:hover {
    color: #13b999 !important;
  }

  /* Brand Title */
  .brand-title {
    color: #1e293b;
    font-weight: 700;
    font-size: 1.1rem;
    letter-spacing: -0.5px;
  }

  .brand-subtitle {
    font-size: 0.7rem;
    color: #13b999;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  hr.horizontal.dark {
    background-image: linear-gradient(90deg, transparent, rgba(0, 0, 0, 0.05), transparent);
  }

  .badge-count {
    background: #f1f5f9;
    color: #475569;
    font-size: 0.7rem;
    padding: 2px 8px;
    border-radius: 6px;
    font-weight: 600;
  }
</style>

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 fixed-start" id="sidenav-main">
  <div class="sidenav-header mb-4">
    <a class="navbar-brand d-flex align-items-center px-4 py-4 m-0" href="#">
     
      <div class="ms-3">
        <div class="brand-title">Adminity X</div>
        <div class="brand-subtitle">Mail Engine</div>
      </div>
    </a>
  </div>

  <hr class="horizontal dark mt-0 mb-3">

  <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">

      <li class="nav-item">
        <a class="nav-link active" href="{{route('admin.home')}}">
          <span class="material-symbols-rounded">dashboard</span>
          <span class="nav-link-text ms-2">Dashboard</span>
        </a>
      </li>

      <!-- <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#menuCampaigns" role="button" aria-expanded="false">
          <span class="material-symbols-rounded">campaign</span>
          <span class="nav-link-text ms-2">Kampaniyalar</span>
        </a>
        <div class="collapse submenu" id="menuCampaigns">
          <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="#">Aktiv Kampaniyalar</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Planlaşdırılanlar</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Arxiv</a></li>
          </ul>
        </div>
      </li> -->

      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#menuMail" role="button" aria-expanded="false">
          <span class="material-symbols-rounded">mail</span>
          <span class="nav-link-text ms-2">Mail Mərkəzi</span>
        </a>
        <div class="collapse submenu" id="menuMail">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.mailer.form') }}">
                <i class="fa-solid fa-paper-plane me-2"></i> Mail Göndər
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.mailer.report') }}">
                <i class="fa-regular fa-envelope me-2"></i> Hesabatlar
              </a>
            </li>
            
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#menuContacts" role="button" aria-expanded="false">
          <span class="material-symbols-rounded">group</span>
          <span class="nav-link-text ms-2">Auditoriya</span>
        </a>
        <div class="collapse submenu" id="menuContacts">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.contacts.upload.form') }}">Kontakt Yüklə</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.contacts.index') }}">Bütün Siyahı</a>
            </li>
          
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="#">

          <span class="nav-link-text ms-2">Avtomatlaşdırma</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.templates.index') }}">
          <span class="material-symbols-rounded">layers</span>
          <span class="nav-link-text ms-2">Dizayn Şablonları</span>
        </a>
      </li>

      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-5">Sistem</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{route('admin.settings.mail')}}">
          <span class="material-symbols-rounded">settings</span>
          <span class="nav-link-text ms-2">Sistem Ayarları</span>
        </a>
      </li>

    
      
    </ul>
  </div>
</aside>