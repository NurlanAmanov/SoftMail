@extends('frontend.layout.master')
@section('content')

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-white">Mövcud Kartlar</h3>
        <a href="{{ route('admin.cards.create') }}" class="btn btn-danger btn-sm px-4 rounded-pill shadow-sm">
            <i class="fa-solid fa-plus me-1"></i> Yeni Kart
        </a>
    </div>

    <div class="table-responsive shadow-lg rounded-3">
        <table class="table table-borderless align-middle mb-0" style="color: #cbd5e0;">
            <thead style="background-color: #f8f9fa; color: #1a1d21;">
                <tr>
                    <th class="ps-4">Şəkil</th>
                    <th>Bank / Təsvir</th>
                    <th>Kart Nömrəsi</th>
                    <th>Sahibi</th>
                    <th class="text-center">Əməliyyat</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody style="background-color: rgba(255,255,255,0.05);">
                @foreach($cards as $card)
                <tr class="border-bottom border-secondary border-opacity-25">
                    {{-- Bank Logosu --}}
                    <td class="ps-4">
                        <div class="card-img-wrapper" style="width: 50px; height: 50px; overflow: hidden; border-radius: 10px; border: 1px solid rgba(255,255,255,0.1); background: #2d3748;">
                            <img src="{{ asset('public/uploads/cards/' . ($card->image ?? 'default.png')) }}" 
                                 alt="logo" 
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    </td>

                    <td>
                        <div class="text-white fw-bold">{{ $card->bank_name }}</div>
                        <div class="text-secondary small text-truncate" style="max-width: 200px;">{{ $card->description }}</div>
                    </td>
                    
                    <td class="text-white font-monospace">
                        <span class="bg-dark px-2 py-1 rounded border border-secondary border-opacity-25">
                            {{ wordwrap($card->card_number, 4, ' ', true) }}
                        </span>
                    </td>
                    
                    <td class="text-secondary">{{ $card->full_name }}</td>
                    
                    {{-- Əməliyyat Düymələri --}}
                    <td class="text-center">
                        <div class="btn-group gap-1">
                            <a href="{{ route('admin.cards.edit', $card->id) }}" class="btn btn-outline-info btn-sm border-0 action-btn">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>

                            <button type="button" class="btn btn-outline-danger btn-sm border-0 action-btn" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal{{ $card->id }}">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </td>

                    <td class="text-center">
                        @if($card->is_active)
                            <span class="badge bg-success-soft text-success px-3 py-2" style="border-radius: 6px; font-size: 10px; background-color: rgba(25, 135, 84, 0.2);">AKTİV</span>
                        @else
                            <form action="{{ route('admin.cards.activate', $card->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-xs btn-outline-warning shadow-sm" style="font-size: 10px;">Aktiv Et</button>
                            </form>
                        @endif
                    </td>
                </tr>

                <div class="modal fade" id="deleteModal{{ $card->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content bg-dark text-white border-secondary shadow-lg">
                            <div class="modal-header border-secondary">
                                <h5 class="modal-title text-danger fw-bold">
                                    <i class="fa-solid fa-triangle-exclamation me-2"></i> Təsdiqləyin
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Bağla"></button>
                            </div>
                            <div class="modal-body text-start py-4">
                                <p class="mb-1"><strong>{{ $card->bank_name }}</strong> kartını silmək istədiyinizə əminsiniz?</p>
                                <small class="text-muted small">Qeyd: Kart nömrəsi <b>{{ $card->card_number }}</b> olan məlumatlar bazadan həmişəlik silinəcək.</small>
                            </div>
                            <div class="modal-footer border-secondary">
                                <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Ləğv et</button>
                                <form action="{{ route('admin.cards.destroy', $card->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm px-4 shadow">Bəli, Sil</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

<style>
    /* Hover effekti və keçidlər */
    .table tbody tr {
        transition: background-color 0.3s ease;
    }
    .table tbody tr:hover {
        background-color: rgba(255,255,255,0.07) !important;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: 0.2s;
    }
    .action-btn:hover {
        transform: translateY(-2px);
    }

    .btn-xs {
        padding: 0.3rem 0.6rem;
        font-size: 0.75rem;
        border-radius: 6px;
    }

    /* Modal xüsusi dizayn */
    .modal-content {
        border-radius: 15px;
    }
    .modal-backdrop.show {
        opacity: 0.7;
    }
</style>