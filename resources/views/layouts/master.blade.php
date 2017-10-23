<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Senda GNRE - @yield('title')</title>
        <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="vendor/custom/css/style.css">
    </head>
    <body>
        @section('sidebar')

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">SENDA GNRE</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    @if(isset($empresa))
                    <ul class="nav navbar-nav">
                        <li class="{{app('request')->is('config')?'active':''}}"><a href="/{{$empresa->codigo}}/config">Configurações</a></li>
                        <li role="presentation" class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Lotes</a>
                            <ul class="dropdown-menu">
                                <li class="{{app('request')->is('sefaz/enviar-lote')?'active':''}}"><a href="/{{$empresa->codigo}}/sefaz/enviar-lote">Enviar Lotes</a></li>
                                <li class="{{app('request')->is('sefaz/consultar-lote')?'active':''}}"><a href="/{{$empresa->codigo}}/sefaz/consultar-lote">Consultar Lotes</a></li>
                                <li class="{{app('request')->is('sefaz/gerar-guias')?'active':''}}"><a href="/{{$empresa->codigo}}/sefaz/gerar-guias">Gerar Guias</a></li>
                                <li class="{{app('request')->is('sefaz/gerar-guias')?'active':''}}"><a href="/{{$empresa->codigo}}/sefaz/enviar-consultar-gerar">Enviar Consultar e Gerar</a></li>
                            </ul>
                        </li>
                    </ul>
                    @endif
                </div><!--/.nav-collapse -->
            </div>
        </nav>
        @show
        <div class="container">
            @yield('content')
        </div>
        @include('modal')
        <footer class="footer navbar-fixed-bottom">
        @include('layouts/footer')
        </footer>
    </body>
</html>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/custom/js/custom.js"></script>