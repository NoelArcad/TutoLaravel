@extends("admin.admin")

@section('title', $property->exists ? "Editer un bien" : "Créer un bien")

@section('content')

    <h1>@yield('title')</h1>

    <form class="vstack gap-2" action="{{ route($property->exists ? "admin.property.update" : "admin.property.store", $property) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method($property->exists ? 'put' : 'post')


        <div class="row" >
            @include('shared.input', ['class' => 'col', 'label' => 'Titre', 'name' => 'title', 'value' => $property->title])
            
            <div class="col row">
                @include('shared.input', ['class' => 'col', 'name' => 'surface','label' =>'Surface', 'value' => $property->surface])
                @include('shared.input', ['class' => 'col', 'name' => 'price','label' =>'Prix', 'value' => $property->price])

            </div>

        </div>
        @include('shared.input', ['type' => 'textarea', 'name' => 'description', 'value' => $property->descrition])
 

        <div class="row">
            @include('shared.input', ['class' => 'col', 'name' => 'rooms','label' =>'Pièces', 'value' => $property->rooms])
            @include('shared.input', ['class' => 'col', 'name' => 'bedrooms','label' =>'Chambres', 'value' => $property->bedrooms])
            @include('shared.input', ['class' => 'col', 'name' => 'floor','label' =>'Etages', 'value' => $property->floor])

        </div>


        <div class="row">
            @include('shared.input', ['class' => 'col', 'name' => 'address','label' =>'Adresse', 'value' => $property->address])
            @include('shared.input', ['class' => 'col', 'name' => 'city','label' =>'Ville', 'value' => $property->city])
            @include('shared.input', ['class' => 'col', 'name' => 'postal_code','label' =>'Code postal', 'value' => $property->postal_code])

        </div>



        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="image" class="form-label">Sélectionner une image :</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>
            </div>
        </div>




        @include('shared.select', ['name' => 'options','label' =>'Options', 'value' => $property->options()->pluck('id'), 'multiple'=> true])


        @include('shared.checkbox', ['name' => 'sold','label' => 'Vendu', 'value' => $property->sold, 'options' => $options ])


        <div>
            <button class="btn btn-primary">
                @if($property->exists)
                   Modifier    
                @else
                   Créer
                @endif
            </button>
        </div>
    </form>

@endsection
