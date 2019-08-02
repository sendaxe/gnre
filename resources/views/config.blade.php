@extends('layouts.master')

@section('title', 'Configurações')

@section('sidebar')
@parent
@stop

@section('content')
<div class="content-principal view-config">
    <div class='content-title'>
        <h3>Configurações</h3>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 panel panel-default margin-bottom">
            <div class="panel-body">
                <span class="panel-title">Certificado Digital</span>
                <form id='form-certificado' class="margin-top" action="{{ url('/') }}/{{$empresa->codigo}}/config/upload-cert" method="post" enctype="multipart/form-data" autocomplete="off">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="ipt-password">Senha</label>
                                <input type="password" class="form-control" id="ipt-password" name="password" required="required" placeholder="Senha do Certificado">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-8">
                            <div class="form-group">
                                <label for="ipt-cert">Certificado digital modelo A1</label>
                                <div class="input-group">
                                    <label class="input-group-btn">
                                        <span class="btn btn-primary">
                                            Arquivo <input type="file" style="display: none;" name='certificado' accept=".pfx" required="required">
                                        </span>
                                    </label>
                                    <input type="text" id="ipt-cert" class="form-control" readonly="" required="required">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="pull-right">
                            <button type='submit' class="btn btn-primary">Extrair</button>
                        </div>
                    </div>
                </form>
                @if(isset($mensagens))
                <div>
                    @foreach($mensagens as $row)
                    <h5 class="pull-left">{{$row['mensagem']}}</h5>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 panel panel-default">
            <div class="panel-body">
                <span class="panel-title">Portal Nacional GNRE</span>
                @if(isset($empresa))
                <a type="button" href="{{ url('/') }}/{{$empresa->codigo}}/sefaz/atualizar-receitas" class="btn btn-primary pull-right margin-top">Atualizar Receitas</a>
                @endif
            </div>
        </div>
    </div>
    @if(isset($empresa))
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
            <div class="row">
                <a class="btn btn-default " href="{{ url('/') }}/{{$empresa->codigo}}">Voltar</a>
            </div>
        </div>
    </div>
    @endif
</div>
@stop

@include('modal')