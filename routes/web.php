<?php

use Illuminate\Http\Request;

$app->get('/','Home@show');
$app->get('dashboard','Home@show');
$app->get('configuracoes','Configuracoes@show');
$app->post('configuracoes/upload-certificado','Configuracoes@uploadCertificado');
$app->get('sefaz/enviar-lote','Lotes@enviar');
$app->get('sefaz/consultar-lote','Lotes@consultar');
$app->get('sefaz/consultar-recibo/{numero}','Lotes@consultarRecibo');
$app->get('sefaz/atualizar-receitas','Receita@atualizar');
$app->get('sefaz/consultar-uf/{uf}/{receita}','ConsultarUF@consultarUf');

$app->group(['prefix' => ''], function() {
    define('STATUS_INCLUIDO','1');
    define('STATUS_ENVIADO','2');
    define('STATUS_PROCESSADO','3');
    define('STATUS_CONTINGENCIA','4');
    define('STATUS_FALHA','5');
    define('STATUS_REJEICAO','9');
});