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
                    <a class="navbar-brand" href="#">Senda GNRE</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <!--<li class="{{(app('request')->is('/') || app('request')->is('home'))?'active':''}}"><a href="home">Home</a></li>-->
                        <li class="{{app('request')->is('configuracoes')?'active':''}}"><a href="configuracoes">Portal - Configurações</a></li>
                        <li class="{{app('request')->is('sefaz/enviar-lote')?'active':''}}"><a href="sefaz/enviar-lote">Portal - Enviar Lotes</a></li>
                        <li class="{{app('request')->is('sefaz/consultar-lote')?'active':''}}"><a href="sefaz/consultar-lote">Portal - Consultar Lotes</a></li>
                        <li class="{{app('request')->is('sefaz/gerar-guias')?'active':''}}"><a href="sefaz/gerar-guias">Portal - Gerar Guias</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>

        @show

        <div class="container">
            @yield('content')
        </div><!-- /.container -->
    </body>
</html>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/custom/js/custom.js"></script>