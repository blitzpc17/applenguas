@extends('front.layout')

@section('title', 'BLOG')



@push('css')
    <link rel="stylesheet" href="{{asset('frontend/css/cards.css')}}">


    <style>
        .blog-contenido{
            display:flex;
            flex-direction:column;
            overflow-y:auto;
            height:650px;
            align-items:center;
        }

        .blog-contenido img{
            margin-top:1.5rem;
        }
    </style>
@endpush


@section('nombreSeccion', 'BLOG')






@section('contenido')


<div class="container-cards">

        @foreach ($blog as $item)

        <div class="item">
            <div class="item-header">
                <h3>{{$item->titulo}}</h3>
            </div>
            <div class="item-body">
               
                <div class="contenido">
                    <div class="blog-contenido">
                      
                        {{$item->texto}}

                        <img height="280" width="380" src="{{asset('frontend/img/blog')}}/{{$item->img}}" alt="" srcset="">
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