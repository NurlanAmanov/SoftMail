@extends('frontend.layout.master')

@section('content')
<div class="container-fluid py-5">
    <div class="row mb-4 px-3">
        <div class="col-12 text-center">
            <h3 class="fw-bold text-slate-800" style="color: #1e293b; letter-spacing: -0.5px;">Göndərilmiş Maillər</h3>
            <p class="text-muted small">Bütün kampaniyaların statusu və çatdırılma hesabatı.</p>
        </div>
    </div>

    <div class="card table-card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-4">#</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mövzu (Subject)</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Başlıq</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Göndərən</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Tarix</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Status</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($emails as $i => $email)
                            <tr>
                                <td class="px-4">
                                    <span class="text-xs font-weight-bold text-slate-600">
                                        {{ ($emails->currentPage()-1)*$emails->perPage() + $i + 1 }}
                                    </span>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0" style="color: #13b999;">{{ $email->subject }}</p>
                                </td>
                                <td>
                                    <p class="text-sm text-slate-600 mb-0">{{ $email->title }}</p>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0 text-sm">{{ $email->sender_name }}</h6>
                                        <p class="text-xs text-secondary mb-0">{{ $email->sender_email }}</p>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">
                                        <i class="fa-regular fa-calendar-days me-1"></i>
                                        {{ $email->created_at->format('d.m.Y H:i') }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    @if($email->recipients()->where('status','error')->exists())
                                        <span class="badge badge-error">
                                            <i class="fas fa-times-circle me-1"></i> Xəta
                                        </span>
                                    @elseif($email->recipients()->where('status','queued')->exists())
                                        <span class="badge badge-warning">
                                            <i class="fas fa-clock me-1"></i> Növbədə
                                        </span>
                                    @else
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle me-1"></i> Göndərildi
                                        </span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <button class="btn btn-link text-secondary mb-0" title="Ətraflı Bax">
                                        <i class="fa fa-ellipsis-v text-xs"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-5 text-center">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fa-solid fa-inbox text-slate-200 mb-3" style="font-size: 48px;"></i>
                                        <p class="text-slate-500">Hələ heç bir mail göndərilməyib.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($emails->hasPages())
            <div class="card-footer bg-white border-0 px-4 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="text-xs text-secondary mb-0">Ümumi {{ $emails->total() }} qeyd tapıldı.</p>
                    <div class="pagination-container">
                        {{ $emails->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    /* Kart Dizaynı */
    .table-card {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
    }

    /* Cədvəl Header Stili */
    .table thead th {
        background-color: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
        padding-top: 15px;
        padding-bottom: 15px;
    }

    /* Status Badge-ləri */
    .badge {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        text-transform: none;
        font-size: 11px;
    }

    .badge-success {
        background-color: #ecfdf5;
        color: #059669;
    }

    .badge-warning {
        background-color: #fffbeb;
        color: #d97706;
    }

    .badge-error {
        background-color: #fef2f2;
        color: #dc2626;
    }

    /* Hover effekti */
    .table tbody tr:hover {
        background-color: #fcfdfe;
    }

    /* Pagination təmizlənməsi */
    .pagination {
        margin-bottom: 0;
    }
    .page-link {
        border: none;
        color: #64748b;
        font-size: 13px;
        border-radius: 8px !important;
        margin: 0 2px;
    }
    .page-item.active .page-link {
        background-color: #13b999;
        color: #fff;
    }
</style>
@endpush
@endsection