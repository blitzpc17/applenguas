<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{asset('cms/dist/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}">

    @stack('css')
</head>
<body>


<section class="pagina">

<nav>
    <ul id="main-nav">
        <li>
            <div class="menu-logo">
                <img src="{{asset('cms/dist/img/conversacion.png')}}" alt="" srcset=""><span>APRENDAMOS NÁHUATL</span>
            </div>
        </li>
        <li>
            <div class="menu-body">
                <ul>
                    <li class="menu-item">
                        <div>
                            <a href="{{route('index')}}"><span><i class="fas fa-home"></i>Inicio</span></a>
                        </div>
                    </li>
                    <li class="menu-item">
                        <div>
                            <a href="{{route('categorias.index')}}"><span><i class="fas fa-th"></i>Categorías</span></a>
                        </div>
                    </li>
                    <li class="menu-item">
                        <div>
                            <a href="{{route('front.fras')}}"><span><i class="fas fa-comments"></i>Frases</span></a>
                        </div>
                    </li>
                    <li class="menu-item">
                        <div>
                            <a href="{{route('front.bg')}}"><span><i class="fas fa-book"></i>Blog</span></a>
                        </div>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</nav>


    <section id="contenido">



        <section>

            <div class="title-section">
                <h3>@yield('nombreSeccion')</h3>
            </div>

            @section('contenido')






            @show

        </section>




        <footer>

        <div class="float-right d-none d-sm-block">
            <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; {{date('Y')}} <a href="#">APRENDAMOS NÁHUATL</a>.</strong>
        </div>

        </footer>

    </section>

</section>




    
</body>
</html>



<script src="{{asset('frontend/js/jquery.js')}}"></script>
@stack('js')
