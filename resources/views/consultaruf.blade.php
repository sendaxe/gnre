@extends('layouts.master')

@section('title', 'Atualizar Receitas')

@section('sidebar')
@parent
@stop

@section('content')
<div class="content-principal view-empresa">
    <div class="content-title">
        <h3>Atualização de Receitas</h3>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 panel panel-default margin-bottom">
            <div class="panel-body">
                @foreach($mensagens as $row)
                <div class="row">
                    <span><h5>{{$row['mensagem']}}</h5></span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @if(isset($empresa))
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
            <div class="row">
                <a class="btn btn-default" href="{{ url('/') }}/{{$empresa->codigo}}/config">Voltar</a>
            </div>
        </div>
    </div>
    @endif
</div>
@stop