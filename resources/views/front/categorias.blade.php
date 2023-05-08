@extends('front.layout')

@section('title', 'CATEGORÍAS')



@push('css')
    <link rel="stylesheet" href="{{asset('frontend/css/categorias.css')}}">
@endpush


@section('nombreSeccion', 'CATEGORÍAS')






@section('contenido')


<div class="categorias-container">

    @foreach($categorias as $cat)
    <div class="cat-item">
        <a href="{{route('categorias.item')}}?cat={{$cat->id}}">
            <img src="{{asset('frontend/img/categorias/')}}/{{$cat->logo}}" alt="">
            <h5>{{$cat->nombre}}</h5>
            <p>{{$cat->descripcion}}</p>
        </a>        
    </div>
    @endforeach

</div>




@endsection



@push('js')

<script>
    $(document).ready(function () {
        console.log('running....')
    });
</script>
    
@endpush