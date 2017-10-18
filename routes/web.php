<?php

$app->get('/', ['as' => 'home', 'uses' => 'Home@show']);
$app->get('home', ['as' => 'home', 'uses' => 'Home@show']);
$app->group(['prefix' => '{id_empresa}'], function ($id_empresa) use ($app) {
    $app->get('/', ['as' => 'empresa', 'uses' => 'Empresa@show']);
    $app->get('config', ['as' => 'config', 'uses' => 'Config@show']);
    $app->post('config/upload-cert', ['as' => 'config/upload-cert', 'uses' => 'Config@uploadCert']);
    $app->get('sefaz/atualizar-receitas', ['as' => 'sefaz/atualizar-receitas', 'uses' => 'ConsultarUF@atualizar']);
    $app->get('sefaz/consultar-uf/{uf}/{receita}', ['as' => 'sefaz/consultar-uf', 'uses' => 'ConsultarUF@consultarUf']);
    $app->get('sefaz/enviar-lote', ['as' => 'sefaz/enviar', 'uses' => 'Lotes@enviar']);
    $app->get('sefaz/enviar-lote/{id}', ['as' => 'sefaz/enviar-by-id', 'uses' => 'Lotes@enviarById']);
    $app->get('sefaz/consultar-lote', ['as' => 'sefaz/consultar', 'uses' => 'Lotes@consultar']);
    $app->get('sefaz/consultar-lote/{id}', ['as' => 'sefaz/consultar-by-id', 'uses' => 'Lotes@consultarById']);
    $app->get('sefaz/gerar-guias', ['as' => 'sefaz/gerar-guias', 'uses' => 'GerarGuias@pdfLotes']);
    $app->get('sefaz/gerar-guias/{id}', ['as' => 'sefaz/gerar-guias-by-id', 'uses' => 'GerarGuias@pdfGuia']);
    $app->get('sefaz/enviar-consultar-gerar', ['as' => 'sefaz/enviar-consultar-gerar', 'uses' => 'Lotes@enviarConsultarGerar']);
    $app->get('sefaz/enviar-consultar-gerar/{id}',['as' => 'sefaz/enviar-consultar-gerar-by-id', 'uses' => 'Lotes@enviarConsultarGerarById']);
});