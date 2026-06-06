@extends('frontend.layout.master')

@section('content')
<div class="container-fluid py-5">
    <div class="row mb-4 px-3">
        <div class="col-md-6 text-start">
            <h3 class="fw-bold text-slate-800" style="color: #1e293b; letter-spacing: -0.5px;">Auditoriya Siyahısı</h3>
            <p class="text-muted small">Cəmi {{ $contacts->total() }} aktiv kontakt mövcuddur.</p>
        </div>
        <div class="col-md-6 text-end d-flex align-items-center justify-content-end gap-2">
            <form action="{{ route('admin.contacts.deleteAll') }}" method="POST" onsubmit="return confirm('DİQQƏT! Bütün bazanı təmizləmək istədiyinizə əminsiniz?')">
                @csrf
                <button type="submit" class="btn-clear-all">
                    <i class="fas fa-trash-alt me-2"></i> Bazanı Sıfırla
                </button>
            </form>
            <a href="{{ route('admin.contacts.upload.form') }}" class="btn-add-new">
                <i class="fas fa-plus me-2"></i> Yeni Əlavə Et
            </a>
        </div>
    </div>

    <div class="card table-card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="px-4 py-3" style="width: 40px;">
                                <div class="form-check p-0">
                                    <input class="form-check-input custom-check" type="checkbox" id="select-all">
                                </div>
                            </th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email Ünvanı</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ad / Soyad</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Telefon</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">İdxal Tarixi</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end px-4">Əməliyyat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $i => $contact)
                            <tr class="contact-row">
                                <td class="px-4">
                                    <div class="form-check p-0">
                                        <input class="form-check-input custom-check select-contact" type="checkbox" name="contacts[]" value="{{ $contact->id }}">
                                    </div>
                                </td>
                                <td>
                                    <span class="text-xs font-weight-bold text-slate-500">{{ $contacts->firstItem() + $i }}</span>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm email-text" style="color: #13b999;">{{ $contact->email }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-600 text-slate-700 mb-0">{{ $contact->name ?? '-' }}</p>
                                </td>
                                <td>
                                    <span class="text-xs text-secondary">{{ $contact->phone ?? '-' }}</span>
                                </td>
                                <td>
                                    <span class="text-secondary text-xs">
                                        <i class="fa-regular fa-clock me-1"></i> {{ $contact->created_at->format('d.m.Y H:i') }}
                                    </span>
                                </td>
                                <td class="text-end px-4">
                                    <form action="{{ route('admin.contacts.delete', $contact->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-delete" title="Sil">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-5 text-center">
                                    <div class="empty-state">
                                        <i class="fa-solid fa-users-slash text-slate-200 mb-3" style="font-size: 50px;"></i>
                                        <p class="text-slate-500">Heç bir kontakt tapılmadı.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($contacts->hasPages())
            <div class="card-footer bg-white border-0 px-4 py-4">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-xs text-secondary font-weight-600">
                        {{ $contacts->firstItem() }}-{{ $contacts->lastItem() }} / {{ $contacts->total() }} kontakt göstərilir
                    </span>
                    <div class="custom-pagination">
                        {{ $contacts->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    /* Table Card */
    .table-card {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 20px;
    }

    .table thead th {
        background-color: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
        padding: 12px 10px;
    }

    .contact-row {
        transition: all 0.2s ease;
    }

    .contact-row:hover {
        background-color: #fcfdfe;
        transform: scale(1.002);
    }

    /* Checkbox Styling */
    .custom-check {
        width: 18px;
        height: 18px;
        border: 2px solid #e2e8f0;
        cursor: pointer;
    }

    .custom-check:checked {
        background-color: #13b999;
        border-color: #13b999;
    }

    /* Buttons */
    .btn-add-new {
        background: #13b999;
        color: #fff !important;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 13px;
        border: none;
        transition: 0.3s;
    }

    .btn-clear-all {
        background: #fff;
        color: #dc2626;
        border: 1px solid #fee2e2;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 13px;
        transition: 0.3s;
    }

    .btn-clear-all:hover {
        background: #fef2f2;
    }

    .btn-action-delete {
        background: #fff;
        border: 1px solid #f1f5f9;
        color: #94a3b8;
        width: 34px;
        height: 34px;
        border-radius: 8px;
        transition: 0.3s;
    }

    .btn-action-delete:hover {
        color: #dc2626;
        border-color: #fecaca;
        background: #fff5f5;
    }

    /* Pagination */
    .page-link {
        border: none !important;
        padding: 8px 16px;
        margin: 0 3px;
        border-radius: 10px !important;
        color: #64748b;
        font-weight: 600;
    }

    .active > .page-link {
        background-color: #13b999 !important;
        box-shadow: 0 4px 10px rgba(19, 185, 153, 0.2);
    }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('select-all').addEventListener('change', function(e) {
        let checkboxes = document.querySelectorAll('.select-contact');
        checkboxes.forEach(checkbox => {
            checkbox.checked = e.target.checked;
            let row = checkbox.closest('tr');
            if(e.target.checked) row.style.backgroundColor = '#f1fdfb';
            else row.style.backgroundColor = '';
        });
    });

    document.querySelectorAll('.select-contact').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            let row = this.closest('tr');
            if(this.checked) row.style.backgroundColor = '#f1fdfb';
            else row.style.backgroundColor = '';
        });
    });
</script>
@endpush
@endsection