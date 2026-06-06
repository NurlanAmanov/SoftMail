@extends('frontend.layout.master')

@section('content')
<div class="container-fluid py-5">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h3 class="fw-bold text-slate-800" style="color: #1e293b; letter-spacing: -0.5px;">Kontaktları İdxal Et</h3>
            <p class="text-muted small">Auditoriyanızı genişləndirmək üçün Excel faylı yükləyin və ya siyahını birbaşa yapışdırın.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 text-white" style="background: #13b999;">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif
    
    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
            <i class="fas fa-exclamation-triangle me-2"></i> {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.contacts.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row g-4 justify-content-center">
            <div class="col-lg-5">
                <div class="upload-box h-100 p-5">
                    <div class="text-center">
                        <div class="icon-shape bg-light-green mb-4">
                            <i class="fas fa-file-csv text-green"></i>
                        </div>
                        <h5 class="fw-bold text-slate-800 mb-2">Fayl ilə Yüklə</h5>
                        <p class="text-muted small mb-4">Excel, CSV və ya TXT formatları dəstəklənir.</p>
                        
                        <div class="file-input-wrapper">
                            <input type="file" name="file" id="file" class="file-input">
                            <label for="file" class="file-label">
                                <i class="fas fa-cloud-upload-alt me-2"></i> Fayl Seçin
                            </label>
                        </div>
                        <div id="file-name" class="mt-3 text-xs text-slate-500">Heç bir fayl seçilməyib</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-1 d-flex align-items-center justify-content-center">
                <div class="divider-circle shadow-sm">VƏ YA</div>
            </div>

            <div class="col-lg-5">
                <div class="upload-box p-4">
                    <div class="text-center mb-3">
                        <h5 class="fw-bold text-slate-800 mb-0">Manual Əlavə Et</h5>
                        <p class="text-muted text-xs">Hər sətirdə bir email ünvanı yazın.</p>
                    </div>
                    <textarea name="emails" class="custom-textarea" rows="8" 
                        placeholder="nurlan@example.com&#10;test@softlink.az&#10;admin@adminity.dev"></textarea>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-lg-11 mx-auto">
                <button type="submit" class="import-btn shadow-lg">
                    <i class="fas fa-database me-2"></i> Məlumatları Bazaya İdxal Et
                </button>
            </div>
        </div>
    </form>
</div>

@push('styles')
<style>
    /* Ümumi Box */
    .upload-box {
        background: #ffffff;
        border: 2px dashed #e2e8f0;
        border-radius: 24px;
        transition: all 0.3s ease;
    }

    .upload-box:hover {
        border-color: #13b999;
        background: #fcfdfe;
    }

    /* İkon forması */
    .icon-shape {
        width: 70px;
        height: 70px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        font-size: 28px;
    }
    .bg-light-green { background-color: #ecfdf5; }
    .text-green { color: #13b999; }

    /* Gizli Fayl Inputu */
    .file-input-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }
    .file-input {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        cursor: pointer;
    }
    .file-label {
        background: #f1f5f9;
        color: #475569;
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .file-label:hover {
        background: #e2e8f0;
    }
.icon-shape i {
    color: black
}
    /* Orta Bölücü */
    .divider-circle {
        width: 50px;
        height: 50px;
        background: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: 800;
        color: #94a3b8;
        border: 1px solid #f1f5f9;
        z-index: 2;
    }

    /* Textarea */
    .custom-textarea {
        width: 100%;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        border-radius: 16px;
        padding: 15px;
        font-family: 'Inter', monospace;
        font-size: 14px;
        color: #1e293b;
        outline: none;
        transition: border-color 0.2s;
    }
    .custom-textarea:focus {
        border-color: #13b999;
        background: #ffffff;
    }

    /* Import Düyməsi */
    .import-btn {
        width: 100%;
        background: #1e293b;
        color: #ffffff;
        border: none;
        padding: 18px;
        border-radius: 16px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s;
    }
    .import-btn:hover {
        background: #0f172a;
        transform: translateY(-2px);
    }
</style>
@endpush

@push('scripts')
<script>
    // Fayl seçiləndə adını göstərsin
    document.getElementById('file').onchange = function () {
        document.getElementById('file-name').innerHTML = "<i class='fas fa-check text-green me-1'></i> " + this.files[0].name;
    };
</script>
@endpush
@endsection