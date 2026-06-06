@extends('frontend.layout.master')
@section('content')

<div class="container-fluid mt-5 py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="card shadow-lg" style="background-color: #16191c; border: 1px solid #2d3238; border-radius: 15px;">
                <div class="card-header border-bottom border-secondary bg-transparent p-4 text-center">
                    <h3 class="text-white fw-bold mb-0">Kartı Redaktə Et</h3>
                </div>
                
                <div class="card-body p-5">
                    <form action="{{ route('admin.cards.update', $card->id) }}" method="POST" id="cardForm">
                        @csrf
                        @method('PUT') <div class="mb-4">
                            <label class="text-secondary small mb-2 fw-bold">BANK ADI</label>
                            <input type="text" name="bank_name" value="{{ $card->bank_name }}" class="form-control text-white border-secondary shadow-none" style="background-color: #1a1d21; padding: 15px; border-radius: 10px;" required>
                        </div>

                        <div class="mb-4">
                            <label class="text-secondary small mb-2 fw-bold">KART SAHİBİ</label>
                            <input type="text" name="full_name" value="{{ $card->full_name }}" class="form-control text-white border-secondary shadow-none" style="background-color: #1a1d21; padding: 15px; border-radius: 10px;" required>
                        </div>

                        <div class="mb-4">
                            <label class="text-secondary small mb-2 fw-bold">16 RƏQƏMLİ NÖMRƏ</label>
                            <input type="text" name="card_number" value="{{ $card->card_number }}" id="cardNumber" maxlength="16" class="form-control text-white border-secondary shadow-none" style="background-color: #1a1d21; padding: 15px; border-radius: 10px; letter-spacing: 2px;" required>
                        </div>

                        <div class="mb-5">
                            <label class="text-secondary small mb-2 fw-bold">TƏLİMAT</label>
                            <textarea name="description" class="form-control text-white border-secondary shadow-none" rows="3" style="background-color: #1a1d21; padding: 15px; border-radius: 10px;">{{ $card->description }}</textarea>
                        </div>

                        <button type="submit" class="btn w-100 fw-bold py-3 text-dark" style="background-color: #2bc194; border-radius: 10px; font-size: 1.1rem;">
                            MƏLUMATI YENİLƏ
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('cardForm').addEventListener('submit', function(e) {
        const cardNumber = document.getElementById('cardNumber').value;
        if (cardNumber.length !== 16) {
            e.preventDefault();
            if (typeof toastr !== 'undefined') {
                toastr.error('Xəta: Kart nömrəsi tam 16 rəqəm olmalıdır!');
            } else {
                alert('Xəta: Kart nömrəsi tam 16 rəqəm olmalıdır!');
            }
        }
    });
</script>


@endsection