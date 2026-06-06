<style>
  .navbar-main {
    background: rgba(255, 255, 255, 0.9) !important; 
    backdrop-filter: blur(12px); 
    border-bottom: 1px solid #e2e8f0; /* Daha nəzərə çarpan kənar xətt */
    transition: all 0.3s ease;
  }

  /* Breadcrumb yazıları - Qara tonları */
  .nav-breadcrumb {
    font-size: 0.85rem;
    color: #64748b !important; /* Slate 500 */
  }

  .nav-breadcrumb-current {
    font-size: 0.85rem;
    font-weight: 600;
    color: #1e293b !important; /* Slate 800 - Tam tünd */
  }

  .nav-page-title {
    color: #1e293b !important;
    font-weight: 700 !important;
  }

  /* İkonlar - Qara tonları */
  .navbar-nav .nav-link i {
    color: #1e293b !important; /* İkonlar artıq qaradır */
    font-size: 0.9rem;
    transition: transform 0.2s ease;
  }

  .navbar-nav .nav-link:hover i {
    color: #13b999 !important; /* Hover edəndə sənin yaşıl rəngin */
    transform: scale(1.1);
  }

  /* İstifadəçi adı */
  .user-name-text {
    color: #334155 !important; /* Slate 700 */
    font-weight: 600;
  }

  /* Mobil Menyu Düyməsi (Xətlər) */
  .sidenav-toggler-line {
    background: #1e293b !important; /* Xətlər qara oldu */
    display: block;
    height: 2px;
    margin-bottom: 4px;
    border-radius: 1px;
  }

  .avatar-box {
    width: 32px; 
    height: 32px; 
    border-radius: 8px; 
    background: #f1f5f9; 
    border: 1px solid #e2e8f0;
    display: flex; 
    align-items: center; 
    justify-content: center;
  }
</style>

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl sticky-top" id="navbarBlur" data-scroll="true">
  <div class="container-fluid py-2 px-3">
    
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm nav-breadcrumb">Adminity X</li>
        <li class="breadcrumb-item text-sm nav-breadcrumb-current active" aria-current="page">
          {{ ucfirst(Request::segment(2) ?? 'Dashboard') }}
        </li>
      </ol>
      <h6 class="nav-page-title mb-0">
        {{ ucfirst(Request::segment(2) ?? 'Xoş Gəldiniz') }}
      </h6>
    </nav>

    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0" id="navbar">
      
      <ul class="navbar-nav justify-content-end ms-md-auto pe-md-3 d-flex align-items-center">
        
       
<li class="nav-item d-flex align-items-center ps-3 dropdown">
    <a href="#" class="nav-link p-0 d-flex align-items-center dropdown-toggle" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
        <div class="avatar-box me-2">
            <i class="fa fa-user text-xs" style="color: #64748b;"></i>
        </div>
        <span class="d-sm-inline d-none text-sm user-name-text">{{ Auth::user()->name ?? 'Nurlan' }}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="userMenu">
        <li class="mb-2">
            <a class="dropdown-item border-radius-md" href="{{ route('admin.profile.edit') }}">
                <div class="d-flex py-1">
                    <div class="my-auto">
                        <i class="fa fa-user-edit me-3 text-secondary"></i>
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">Profili Redaktə Et</h6>
                    </div>
                </div>
            </a>
        </li>
        <li>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item border-radius-md text-danger">
                    <i class="fa fa-sign-out-alt me-3"></i> Çıxış
                </button>
            </form>
        </li>
    </ul>
</li>

        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
          <a href="javascript:;" class="nav-link p-0" id="iconNavbarSidenav">
            <div class="sidenav-toggler-inner" style="width: 20px;">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </a>
        </li>

      </ul>
    </div>
  </div>
</nav>