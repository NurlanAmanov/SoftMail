@extends('frontend.layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">E-poçt Şablonları</h3>
            <p class="text-muted">Göndərişləriniz üçün dizayn edilmiş xüsusi şablonlar.</p>
        </div>
        <a href="{{ route('admin.templates.create') }}" class="btn btn-primary px-4 shadow-sm">
            <i class="fa-solid fa-plus me-2"></i> Yeni Şablon Yarat
        </a>
    </div>

    @if(session('message'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="row">
        @forelse($templates as $tpl)
            <div class="col-md-4 col-xl-3 mb-4">
                <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
                    <div class="card-body p-0">
                        <div class="d-flex align-items-center justify-content-center bg-light text-secondary" style="height: 150px;">
                            <i class="fa-solid fa-file-code fa-3x opacity-25"></i>
                        </div>
                        
                        <div class="p-3">
                            <h6 class="fw-bold text-dark mb-1 text-truncate">{{ $tpl->name }}</h6>
                            <small class="text-muted d-block mb-3">Yaradıldı: {{ $tpl->created_at->format('d.m.Y') }}</small>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-soft-primary text-primary px-2 py-1">HTML</span>
                                
                                <div class="btn-group">
                                        <a href="{{ route('admin.templates.edit', $tpl->id) }}" 
       class="btn btn-sm btn-outline-secondary border-0 rounded-circle shadow-none me-1">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>
                                    <form action="{{ route('admin.templates.destroy', $tpl->id) }}" method="POST" onsubmit="return confirm('Bu şablonu silmək istədiyinizə əminsiniz?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-circle shadow-none">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="opacity-50 mb-3">
                    <i class="fa-solid fa-layer-group fa-4x text-muted"></i>
                </div>
                <h5 class="text-muted">Hələ heç bir şablon yaradılmayıb.</h5>
                <p class="text-muted small">İlk professional mail şablonunuzu yaratmağa başlayın!</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    /* Premium görünüş üçün əlavə stillər */
    .bg-soft-primary {
        background-color: rgba(19, 185, 153, 0.1);
        color: #13b999 !important;
    }
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
    }
    .btn-primary {
        background-color: #13b999;
        border-color: #13b999;
    }
    .btn-primary:hover {
        background-color: #0f967c;
        border-color: #0f967c;
    }
</style>
@endsection