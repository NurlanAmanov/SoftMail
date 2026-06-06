@extends('frontend.layout.master')

@section('content')
<div class="container-fluid py-5" style="background-color: #f8fafc; min-height: 100vh;">
    <div class="row mb-5 px-4">
        <div class="col-md-8">
            <h3 class="fw-bold mb-1 text-slate-900" style="letter-spacing: -0.5px;">Dashboard</h3>
            <p class="text-secondary small">Sistemin ümumi performansı və real-vaxt analitikası.</p>
        </div>
        <div class="col-md-4 text-md-end">
             <a href="{{route('admin.mailer.form')}}" class="btn btn-dark px-4 py-2" style="border-radius: 12px; font-weight: 500;">+ Yeni Mail Göndər</a>
        </div>
    </div>

    <div class="row g-4 px-3">
        <div class="col-xl-4 col-md-6">
            <div class="card stat-card h-100 border-indigo-100">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="stat-icon-box bg-slate-900 text-white">
                                <i class="fa-solid fa-server"></i>
                            </div>
                            <span class="trend-label text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded text-xs">
                                {{ $brevoData['plan_type'] ?? 'SMTP' }} Plan
                            </span>
                        </div>
                        <p class="text-secondary text-xs uppercase tracking-wider font-semibold mb-1">Mail Limitiniz</p>
                        
                        @if($brevoData)
                            @php
                                $usedPct = $brevoData['max_limit'] > 0
                                    ? min(round($sentEmails / $brevoData['max_limit'] * 100, 1), 100)
                                    : 0;
                            @endphp
                            <h3 class="mb-0 fw-bold text-slate-900">
                                {{ number_format($sentEmails) }}
                                <span class="text-sm font-normal text-muted">/ {{ number_format($brevoData['max_limit']) }}</span>
                            </h3>
                            <p class="text-muted small mt-1 mb-3">Qalan limit: <strong class="text-slate-900">{{ number_format($brevoData['max_limit'] - $sentEmails) }}</strong></p>
                        @else
                            <h3 class="mb-0 fw-bold text-muted text-sm">Bağlantı qurulamadı</h3>
                            <p class="text-muted small mt-1 mb-3">API açarını yoxlayın.</p>
                        @endif
                    </div>

                    @if($brevoData)
                        <div class="mt-2">
                            <div class="progress" style="height: 6px; border-radius: 10px; background-color: #f1f5f9;">
                                <div class="progress-bar bg-slate-900" role="progressbar"
                                     style="width: {{ $usedPct }}%; border-radius: 10px;"
                                     aria-valuenow="{{ $usedPct }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2 text-muted" style="font-size: 11px;">
                                <span>İstifadə: {{ $usedPct }}%</span>
                                <span>Canlı Data</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-3 col-sm-6">
            <div class="card stat-card h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="stat-icon-box bg-green-50 text-green-600">
                            <i class="fa-solid fa-paper-plane"></i>
                        </div>
                        <span class="trend-label text-green-600">Aktiv</span>
                    </div>
                    <p class="text-secondary text-xs uppercase tracking-wider font-semibold mb-1">Uğurlu</p>
                    <h3 class="mb-0 fw-bold text-slate-900">{{ number_format($sentEmails) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-3 col-sm-6">
            <div class="card stat-card h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="stat-icon-box bg-amber-50 text-amber-600">
                            <i class="fa-solid fa-clock-rotate-left {{ $pendingEmails > 0 ? 'fa-spin' : '' }}"></i>
                        </div>
                        <span class="trend-label {{ $pendingEmails > 0 ? 'text-amber-600' : 'text-slate-400' }}">
                            {{ $pendingEmails > 0 ? 'Gözləyir' : 'Sakit' }}
                        </span>
                    </div>
                    <p class="text-secondary text-xs uppercase tracking-wider font-semibold mb-1">Növbədə</p>
                    <h3 class="mb-0 fw-bold text-slate-900">{{ number_format($pendingEmails) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-6 col-sm-6">
            <div class="card stat-card h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="stat-icon-box bg-red-50 text-red-600">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <span class="trend-label text-red-600">Kritik</span>
                    </div>
                    <p class="text-secondary text-xs uppercase tracking-wider font-semibold mb-1">Uğursuz</p>
                    <h3 class="mb-0 fw-bold text-slate-900">{{ number_format($failedEmails) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-6 col-sm-6">
            <div class="card stat-card h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="stat-icon-box bg-blue-50 text-blue-600">
                            <i class="fa-solid fa-user-group"></i>
                        </div>
                        <span class="trend-label text-blue-600">Data</span>
                    </div>
                    <p class="text-secondary text-xs uppercase tracking-wider font-semibold mb-1">Baza</p>
                    <h3 class="mb-0 fw-bold text-slate-900">{{ number_format($contacts) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4 px-3">
        <div class="col-12">
            <div class="card stat-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-slate-900 m-0" style="font-size: 16px;">Göndəriş Analitikası</h5>
                    <div class="small text-muted">Son 7 gün</div>
                </div>
                <div style="height: 350px;">
                    <canvas id="deliveryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .stat-card {
        background: #ffffff;
        border: 1px solid #edf2f7;
        border-radius: 20px;
        transition: all 0.3s ease;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02);
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.04);
        border-color: #e2e8f0;
    }
    .border-indigo-100 {
        border-color: #e0e7ff !important;
    }
    .stat-icon-box {
        width: 44px; height: 44px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px;
    }
    .text-xs { font-size: 0.75rem; }
    .bg-green-50 { background-color: #ecfdf5; } .text-green-600 { color: #059669; }
    .bg-amber-50 { background-color: #fffbeb; } .text-amber-600 { color: #d97706; }
    .bg-red-50 { background-color: #fef2f2; } .text-red-600 { color: #dc2626; }
    .bg-blue-50 { background-color: #eff6ff; } .text-blue-600 { color: #2563eb; }
    .text-slate-900 { color: #0f172a; }
    .text-secondary { color: #64748b; }
    .trend-label { font-size: 10px; font-weight: 700; text-transform: uppercase; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('deliveryChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 350);
        gradient.addColorStop(0, 'rgba(37, 99, 235, 0.15)');
        gradient.addColorStop(1, 'rgba(37, 99, 235, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($days) !!},
                datasets: [{
                    label: 'Göndərilənlər',
                    data: {!! json_encode($sentCounts) !!},
                    borderColor: '#2563eb',
                    borderWidth: 3,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#2563eb',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font: { size: 11 } } },
                    x: { grid: { display: false }, ticks: { font: { size: 11 } } }
                }
            }
        });
    });
</script>
@endpush