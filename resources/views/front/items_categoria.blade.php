@extends('front.layout')

@section('title', 'CATEGORÍAS')



@push('css')
    <link rel="stylesheet" href="{{asset('frontend/css/categorias.css')}}">
    <style>
        #audio{
        display: none
        }

    </style>
    
@endpush


@section('nombreSeccion', $categoria->nombre)






@section('contenido')


<div class="categorias-container">

    @foreach ($items as $item)
    <div class="item">
        <a href="#">            
            <h5>{{$item->palabraOriginal}}</h5>
            <img src="{{asset('frontend/img/itemcategorias')}}/{{$item->img}}" alt="">
            <div class="item-container">               
                <p>Forma clásica:</p>
                <p>{{$item->TraduccionClasica}}</p>
                <p>Forma moderna:</p>
                <p>{{$item->TraduccionModerna}}</p>
            </div>            
            <button onclick="reproducir('{{$item->pronunciacion}}')"><i class="fa fa-volume-up"></i></button>
        </a>        
    </div>
    @endforeach


    <audio id="audio" controls>
            <source type="audio/wav" src="">
    </audio>

</div>




@endsection



@push('js')

<script>
    $(document).ready(function () {
        console.log('running....')
    });

    function reproducir(aud){
        var audio = document.getElementById("audio");
        audio.src="{{asset('frontend/img/itemcategorias')}}/"+aud;
        audio.play();
    }
</script>
    
@endpush