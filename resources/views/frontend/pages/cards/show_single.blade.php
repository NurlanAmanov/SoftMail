@extends('frontend.layout.master')
@section('content')
<div class="container-fluid mt-5 py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-12" style="max-width: 400px;">

            <div class="mb-2 text-center">
                <span class="text-secondary" style="font-size: 11px; font-weight: bold; letter-spacing: 1px; text-transform: uppercase;">
                    KART: {{ $displayNumber }} / {{ $cards->count() }}
                </span>
            </div>

            <div class="card shadow-lg" id="cardToCopy"
                style="background: linear-gradient(135deg, #1a1d21 0%, #2d3238 100%); 
                        border: 1px solid rgba(43, 193, 148, 0.4); 
                        border-radius: 15px; 
                        width: 100%; 
                        aspect-ratio: 1.6 / 1; 
                        margin: 0 auto;
                        padding: 20px 25px; /* Padding azaldıldı */
                        display: flex;
                        flex-direction: column;
                        justify-content: space-between;
                        box-shadow: 0 10px 30px rgba(0,0,0,0.5);">

                <div class="d-flex justify-content-between align-items-start">
                    <div class="text-start">
                        <h6 class="text-white fw-bold m-0" style="letter-spacing: 1px; font-size: 14px;">{{ $currentCard->bank_name }}</h6>
                        <div class="mt-2" style="width: 35px; height: 25px; background: linear-gradient(135deg, #ffd700, #b8860b); border-radius: 4px; opacity: 0.7;"></div>
                    </div>
                    <span class="material-icons text-white-50" style="font-size: 24px;">contactless</span>
                </div>

                <div class="text-center">
                    <h4 class="text-white font-monospace mb-0" id="cardNumberText"
                        style="letter-spacing: 4px; font-weight: 500; font-size: 1.2rem;">
                        {{ wordwrap($currentCard->card_number, 4, ' ', true) }}
                    </h4>
                </div>

                <div class="d-flex justify-content-between align-items-end">
                    <div class="text-start">
                        <p class="text-secondary mb-0" style="font-size: 9px; letter-spacing: 1px;">KART SAHİBİ</p>
                        <p class="text-white text-uppercase m-0 fw-bold" id="cardHolderName" style="font-size: 12px;">{{ $currentCard->full_name }}</p>
                    </div>

                    <div class="d-flex align-items-center">
                        <button onclick="copyCardDetails()" class="btn btn-link text-white p-0 me-2 shadow-none" title="Kopyala">
                            <span class="material-icons" style="font-size: 20px; color: #2bc194;">content_copy</span>
                        </button>
                        <div class="text-white-50 fw-bold small italic" style="font-style: italic;">VISA</div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('admin.cards.show_single', ['next' => 1]) }}" class="btn fw-bold py-2 shadow-sm"
                    style="background-color: #2bc194; color: #1a1d21; border-radius: 8px; width: 100%; font-size: 14px;">
                    NÖVBƏTİ KARTI GÖSTƏR
                </a>
            </div>

        </div>
    </div>
</div>
<script>
    function copyCardDetails() {
        const cardNumber = "{{ $currentCard->card_number }}";
        const cardHolder = "{{ $currentCard->full_name }}";

        const fullText = `Kart Nömrəsi: ${cardNumber}\nAd Soyad: ${cardHolder}`;

        const el = document.createElement('textarea');
        el.value = fullText;
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);

        if (typeof toastr !== 'undefined') {
            toastr.success('Məlumatlar kopyalandı!');
        } else {
            alert('Məlumatlar kopyalandı!');
        }
    }
</script>
@endsection