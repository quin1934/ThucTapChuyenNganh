@php
    $activePromotions = $activePromotions ?? collect();
    $promo = $activePromotions->first();
@endphp

@if ($promo)
    <div class="container mt-3">
        <div
            class="alert alert-warning d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-0">
            <div>
                <strong>{{ $promo->title }}</strong>
                @if (!empty($promo->description))
                    <div class="small text-dark">{{ $promo->description }}</div>
                @endif
            </div>
            @if (!empty($promo->code))
                <div class="mt-2 mt-md-0">
                    <span class="badge badge-dark p-2">Mã: {{ $promo->code }}</span>
                </div>
            @endif
        </div>
    </div>
@endif
