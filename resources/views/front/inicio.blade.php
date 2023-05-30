@extends('front.layout')


@push('css')


<style>
    .welcome{
        width:90%;
        width: 95%;
        display: flex;
        padding: 1rem 2rem;
        border-radius: 8px;
        background: white;
        margin-left: 2.5rem;
        box-shadow: 5px 5px 5px rgba(0,0,0,0.5);
        flex-wrap: wrap;
        height:35vh;
        align-items: center;
    }

    .inicio-img img{
        width:250px;
        height:180px;
        box-shadow: 2px 2px 15px rgba(0,137,123,0.8)
    }

    .inicio-txt{
        width:60%;
        padding:1.5rem;
        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;
    }

    .inicio-txt h3{
        font-weight:700;
        color:#00897b;
        font-size:1.75rem;
    }

    .inicio-txt p{
        font-weight:700;
        color:#616161;
    }

    .inicio-txt span{
        font-weight:700;
        color:black;
    }





</style>


@endpush

@section('contenido')

<div class="welcome">
    <div class="inicio-img">
        <img src="{{asset('frontend/img/escuela.jpeg')}}" alt="" srcset="">
    </div>
    <div class="inicio-txt">
        <p>ESC. PRIM. FEC. BIL.</p>
        <h3>NIÑOS HEROES DE CHAPULTEPEC</h3>
        <span>21DA10024J</span>
        <p>ALCOMUNGA AJALPAN, PUEBLA</p>
        <h3>BIENVENIDOS</h3>
    </div>
    <div style="width:100%">
        <hr>
    </div>
</div>

@endsection