<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Senda GNRE - @yield('error-code')</title>
        <link rel="stylesheet" href="../../vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../vendor/custom/css/style.css">
    </head>
    <body>
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
                </div><!--/.nav-collapse -->
            </div>
        </nav>
        <div class="container">
            <div class="content-principal view-config">
                <div class="row">
                    <div class="panel panel-default margin-bottom">
                        <div class="panel-body text-center">
                            <div class="row margin-bottom">
                                <h3>@yield('error-code') - @yield('error-mensage')</h3>
                            </div>
                            <div class="row">
                                <h4>@yield('error-details')</h4>
                            </div>
                            <a type="button" href="/" class="btn btn-default margin-top-lg">Leve-me à página inicial</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script src="../../vendor/jquery/jquery.min.js"></script>
<script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../../vendor/custom/js/custom.js"></script>