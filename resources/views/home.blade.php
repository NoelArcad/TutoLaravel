@extends('base')

@section('content')

<div class="bg-light p-5 mb-5 text-center">

   <div class="container">

       <h1>Agence Loren</h1>
       <p>flrk orkf prkpfke efkpekf ke</p>

   </div>

</div>

<div class="container">
    <h2>Nos derniers biens</h2>
    <div class="row align-items-stretch">
        @foreach($properties as $property)
        <div class="col-md-4 my-2">
            <div class="card h-100">
                @include('property.card')
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
