<div class="card">
    <div class="card-body justify-content-center">
        <div class="d-flex justify-content-center h-40">
            <img src="{{ asset('images/' . $property->image) }}" style="width: 100%; height: auto;">
        </div>
        <br>
        <div>
            <h5 class="card.title d-flex justify-content-center">
                <a href="{{ route('property.show', ['slug' => $property->getSlug(), 'property'=> $property ]) }}">{{ $property->title }}</a>
            </h5>
            <p class="card-text d-flex justify-content-center">{{ $property->surface }}m - {{ $property->city }} ({{ $property->postal_code }}) </p>
            <div class="text-primary d-flex justify-content-center fw-bold" style="font-size: 1.4rem;">
                {{ number_format($property->price, thousands_separator:'') }} €
            </div>
        </div>

    </div>
</div>
