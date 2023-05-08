@extends('front.layout')

@section('title', 'FRASES')



@push('css')
    <link rel="stylesheet" href="{{asset('frontend/css/cards.css')}}">   

    <style>
        .contenido-frases{
            padding: 1.5rem;
            width:100%;
            display:flex;
            flex-direction: column;
        }

       
        .contenido-frases p:nth-child(odd){
            font-weight:700;
            color:#00695c;           
        }

        .contenido-frases p:nth-child(even){
            color:#666;
            margin-bottom:0.85rem;
        }
    </style>
@endpush


@section('nombreSeccion', 'FRASES')

  
        




@section('contenido')


<div class="container-cards">

    @foreach ($frases as $fr)

    <div class="item">
        <div class="item-header">
            
        </div>
        <div class="item-body">     
            <div class="source">
                <video src="{{asset('frontend/img/frases')}}/{{$fr->video}}" height="280px" width="380px" controls poster="{{asset('frontend/img/logo-videos.png')}}">
                Tu navegador no admite el elemento <code>video</code>.
                </video>
            </div>           
            <div class="contenido">
                <div class="contenido-frases">
                    <p>Frase:</p>
                    <p>{{$fr->frase}}</p>
                    <p>Forma Clásica:</p>
                    <p>{{$fr->fraseClasica}}</p>
                    <p>Forma Moderna:</p>
                    <p>{{$fr->fraseModerna}}</p>
                </div>
            </div>
           
        </div>
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