@extends('frontend.layout.master')

@push('styles')
<style>
    .settings-card {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,.03);
    }
    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .section-title i { color: #13b999; }
    
    .save-btn {
        background: #1e293b;
        color: #fff;
        border: none;
        padding: 12px 28px;
        border-radius: 12px;
        font-weight: 700;
        transition: all .3s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .save-btn:hover { background: #000; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .save-btn:disabled { opacity: 0.7; cursor: not-allowed; }
    
    .api-status {
        font-size: 0.7rem;
        padding: 4px 12px;
        border-radius: 50px;
        background: #f0fdf4;
        color: #166534;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .input-wrapper { position: relative; }
    .toggle-password {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #94a3b8;
    }
    .text-danger-custom { color: #ef4444; font-size: 0.75rem; margin-top: 5px; font-weight: 500; }
</style>
@endpush

@section('content')
<div class="container-fluid py-5">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h3 class="fw-bold" style="color:#1e293b; letter-spacing:-0.8px;">Sistem Sazlamaları</h3>
            <p class="text-muted small">E-poçt infrastrukturunu və Brevo inteqrasiyasını buradan tənzimləyin.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert custom-alert alert-dismissible fade show position-fixed top-0 end-0 m-4 shadow-lg" role="alert" style="z-index: 9999;">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-check me-2" style="color: #13b999;"></i>
                <span class="fw-bold">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <form method="POST" action="{{ route('admin.settings.mail.update') }}" id="settingsForm">
                @csrf
                <div class="settings-card p-4 p-md-5">
                    
                    <!-- API Bölməsi -->
                    <div class="section-title">
                        <i class="fa-solid fa-shield-halved"></i> 
                        <span>Brevo API İnteqrasiyası</span>
                        @if(!empty($settings['brevo_api_key']))
                            <span class="api-status">Sinxronizə Edilib</span>
                        @endif
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-12">
                            <label class="field-label">Brevo v3 API Key</label>
                            <div class="input-wrapper">
                                <input type="password" name="brevo_api_key" id="apiKey" class="custom-input @error('brevo_api_key') is-invalid @enderror" 
                                       placeholder="xkeysib-..." 
                                       value="{{ old('brevo_api_key', $settings['brevo_api_key'] ?? '') }}">
                                <i class="fa-solid fa-eye toggle-password" onclick="togglePass()"></i>
                            </div>
                            @error('brevo_api_key') <div class="text-danger-custom">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Göndərici Bölməsi -->
                    <div class="section-title">
                        <i class="fa-solid fa-envelope-open-text"></i> Göndərici Parametrləri
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="field-label">Göndərən Adı</label>
                            <input type="text" name="brevo_sender_name" class="custom-input @error('brevo_sender_name') is-invalid @enderror" 
                                   placeholder="Məs: SoftMail Support" 
                                   value="{{ old('brevo_sender_name', $settings['brevo_sender_name'] ?? '') }}">
                            @error('brevo_sender_name') <div class="text-danger-custom">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="field-label">Göndərən Email</label>
                            <input type="email" name="brevo_sender_email" class="custom-input @error('brevo_sender_email') is-invalid @enderror" 
                                   placeholder="contact@nurlandev.click" 
                                   value="{{ old('brevo_sender_email', $settings['brevo_sender_email'] ?? '') }}">
                            @error('brevo_sender_email') <div class="text-danger-custom">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 text-end mt-5">
                            <hr class="mb-4" style="opacity: 0.05;">
                            <button type="submit" class="save-btn" id="submitBtn">
                                <i class="fa-solid fa-check-double"></i>
                                <span id="btnText">Dəyişiklikləri Tətbiq Et</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Parolu göstər/gizlə funksiyası
    function togglePass() {
        const passInput = document.getElementById('apiKey');
        const icon = document.querySelector('.toggle-password');
        if (passInput.type === 'password') {
            passInput.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passInput.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    // Submit zamanı loading effekti
    document.getElementById('settingsForm').onsubmit = function() {
        const btn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        btn.disabled = true;
        btnText.innerText = 'Yadda saxlanılır...';
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> ' + btnText.innerText;
    };
</script>
@endpush