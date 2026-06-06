@extends('frontend.layout.master')
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow" style="background-color: #16191c; border: 1px solid #2d3238; border-radius: 12px;">
                <div class="card-header border-bottom border-secondary bg-transparent p-3 text-center">
                    <h5 class="text-white fw-bold mb-0">Kartı Sistemə Yaz</h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.cards.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="text-secondary small mb-1 fw-bold">BANK ADI</label>
                            <input type="text" name="bank_name" class="form-control text-white border-secondary shadow-none"
                                style="background-color: #1a1d21; padding: 10px; border-radius: 8px; font-size: 0.9rem;" required>
                        </div>

                        <div class="mb-3">
                            <label class="text-secondary small mb-1 fw-bold">KART SAHİBİ</label>
                            <input type="text" name="full_name" class="form-control text-white border-secondary shadow-none"
                                style="background-color: #1a1d21; padding: 10px; border-radius: 8px; font-size: 0.9rem;" required>
                        </div>

                        <div class="mb-3">
                            <label class="text-secondary small mb-1 fw-bold">16 RƏQƏMLİ NÖMRƏ</label>
                            <input type="text"
                                name="card_number"
                                maxlength="16"
                                minlength="16"
                                pattern="\d{16}"
                                class="form-control text-white border-secondary shadow-none"
                                style="background-color: #1a1d21; padding: 10px; border-radius: 8px; letter-spacing: 1px; font-size: 0.9rem;"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="text-secondary small mb-1 fw-bold">BANK LOGOSU (ŞƏKİL)</label>
                            <input type="file" name="image" class="form-control text-white border-secondary shadow-none"
                                style="background-color: #1a1d21; padding: 10px; border-radius: 8px; font-size: 0.9rem;" accept="image/*">
                        </div>

                        <div class="mb-4">
                            <label class="text-secondary small mb-1 fw-bold">TƏLİMAT</label>
                            <textarea name="description" class="form-control text-white border-secondary shadow-none"
                                rows="2" style="background-color: #1a1d21; padding: 10px; border-radius: 8px; font-size: 0.9rem;"></textarea>
                        </div>

                        <button type="submit" class="btn w-100 fw-bold py-2 text-dark"
                            style="background-color: #2bc194; border-radius: 8px; font-size: 1rem;">
                            SİSTEMƏ ƏLAVƏ ET
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}');
            @endforeach
        });
    </script>
@endif
@endsection