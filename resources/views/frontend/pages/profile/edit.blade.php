@extends('frontend.layout.master')

@push('styles')
<style>
    .profile-card {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        overflow: hidden;
    }
    .info-section {
        background: #f8fafc;
        border-right: 1px solid #f1f5f9;
        padding: 40px;
    }
    .form-section { padding: 40px; }
    
    .field-group { margin-bottom: 20px; }
    
    .input-icon-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    .input-icon-wrapper i {
        position: absolute;
        left: 16px;
        color: #94a3b8;
        font-size: 14px;
    }
    .custom-input {
        padding-left: 45px !important;
        height: 52px;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        transition: all 0.3s ease;
        width: 100%;
    }
    .custom-input:focus {
        border-color: #13b999;
        box-shadow: 0 0 0 4px rgba(19, 185, 153, 0.1);
        outline: none;
    }
    
    .btn-update {
        background: #1e293b;
        color: white;
        border: none;
        height: 52px;
        border-radius: 14px;
        font-weight: 700;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    .btn-update:hover {
        background: #000;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .profile-avatar-preview {
        width: 80px;
        height: 80px;
        background: #13b999;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 32px;
        margin-bottom: 20px;
        box-shadow: 0 10px 20px rgba(19, 185, 153, 0.2);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="profile-card">
                <div class="row g-0">
                    <!-- Sol Panel: Məlumat -->
                    <div class="col-lg-4 info-section d-none d-lg-block">
                        <div class="profile-avatar-preview">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <h4 class="fw-bold text-dark">Hesabınızı tənzimləyin</h4>
                        <p class="text-muted small">Şəxsi məlumatlarınızı və təhlükəsizlik parametrlərinizi buradan idarə edə bilərsiniz. Adminity X ekosistemində məlumatlarınız qorunur.</p>
                        
                        <div class="mt-5">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fa-solid fa-shield-check text-success me-3"></i>
                                <span class="text-sm fw-medium text-secondary">SSL Mühafizəli Yeniləmə</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-clock-rotate-left text-primary me-3"></i>
                                <span class="text-sm fw-medium text-secondary">Son giriş: {{ now()->format('d.m.Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Sağ Panel: Form -->
                    <div class="col-lg-8 form-section">
                        @if(session('success'))
                            <div class="alert alert-success border-0 border-radius-lg text-white font-weight-bold" style="background: #13b999;">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.profile.update') }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6 field-group">
                                    <label class="form-label fw-bold small text-uppercase" style="color: #64748b;">Ad Soyad</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fa-solid fa-user"></i>
                                        <input type="text" name="name" class="custom-input" value="{{ old('name', $user->name) }}" required>
                                    </div>
                                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6 field-group">
                                    <label class="form-label fw-bold small text-uppercase" style="color: #64748b;">E-poçt Ünvanı</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fa-solid fa-envelope"></i>
                                        <input type="email" name="email" class="custom-input" value="{{ old('email', $user->email) }}" required>
                                    </div>
                                    @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-12 mt-4 mb-2">
                                    <h6 class="fw-bold text-dark"><i class="fa-solid fa-lock me-2 text-warning"></i> Təhlükəsizlik</h6>
                                    <p class="text-muted text-xs">Şifrəni dəyişmək istəmirsinizsə, bu sahələri boş qoyun.</p>
                                </div>

                                <div class="col-md-6 field-group">
                                    <label class="form-label fw-bold small text-uppercase" style="color: #64748b;">Yeni Şifrə</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fa-solid fa-key"></i>
                                        <input type="password" name="password" class="custom-input" placeholder="••••••••">
                                    </div>
                                </div>

                                <div class="col-md-6 field-group">
                                    <label class="form-label fw-bold small text-uppercase" style="color: #64748b;">Təkrar Şifrə</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fa-solid fa-circle-check"></i>
                                        <input type="password" name="password_confirmation" class="custom-input" placeholder="••••••••">
                                    </div>
                                </div>

                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn-update w-100">
                                        <i class="fa-solid fa-paper-plane"></i>
                                        Dəyişiklikləri Yadda Saxla
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection