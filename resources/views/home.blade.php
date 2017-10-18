@extends('layouts.master')

@section('title', 'Home')

@section('sidebar')
@parent
@stop

@section('content')
<div class="content-principal view-home">
    <div class="content-title">
        <h3>Definir Empresa</h3>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 panel panel-default margin-bottom">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <form id='form-certificado' action="configuracoes/upload-certificado" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="sel-empresa">Escolha uma empresa habilitada para Gerar GNRE</label>
                                <select class="form-control cursor-pointer" id="sel-empresa" required="required">
                                    <option value=""> Selecionar Empresa</option>
                                    @foreach($arrEmpresas as $row)
                                    <option value="{{$row->codigo}}">{{str_pad($row->codigo, 3,'0', STR_PAD_LEFT)}} - {{$row->nome}} - {{str_replace(['.','/','-'],[],$row->cnpj)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop