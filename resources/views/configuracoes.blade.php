@extends('layouts.master')

@section('title', 'Home')

@section('sidebar')
@parent
@stop

@section('content')
<div class="content-principal">
    <div class='content-title'>
        <h3>Configurações</h3>
    </div>
    <div class='row'>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <h4>Certificado Digital</h4>
            <form id='form-certificado' action="configuracoes/upload-certificado" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="input-group">
                        <label class="input-group-btn">
                            <span class="btn btn-primary">
                                Arquivo <input type="file" style="display: none;" name='certificado' accept=".pfx">
                            </span>
                        </label>
                        <input type="text" class="form-control" readonly="">
                    </div>
                    <span class="help-block">Informe o certificado digital modelo A1</span>
                </div>
                <div class="form-group">
                    <div class="pull-right">
                        <button type='submit' class="btn btn-primary">Confirmar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop