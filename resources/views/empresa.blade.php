@extends('layouts.master')

@section('title', 'Empresa')

@section('sidebar')
@parent
@stop

@section('content')
<div class="content-principal view-empresa">
    <div class="content-title">
        <h3>Empresa</h3>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 panel panel-default margin-bottom">
            <div class="panel-body">
                @if(isset($empresa))
                <div class="row">
                    <form id='form-empresa'>
                        <div class="col-xs-12 col-sm-4 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label>Código</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Código" value="{{$empresa->codigo}}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-9">
                            <div class="form-group">
                                <label>CNPJ</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="CNPJ" value="{{$empresa->cnpj}}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Razão Social</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Razão Social" value="{{$empresa->nome}}">
                            </div>
                            <div class="form-group">
                                <label>Fantasia</label>
                                <input type="text" class="form-control" readonly="readonly" placeholder="Fantasia" value="{{$empresa->apelido}}">
                            </div>
                        </div>
                    </form>
                    <br/>
                </div>
                @endif
            </div>
        </div>
    </div>
    @if(isset($empresa) && ($empresa->qtd_habilitadas > 1))
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
            <div class="row">
                <a class="btn btn-default" href="{{ url('/') }}">Voltar</a>
            </div>
        </div>
    </div>
    @endif
</div>
@stop