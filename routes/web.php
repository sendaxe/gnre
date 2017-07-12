<?php

use Illuminate\Http\Request;

$app->get('/','Home@show');
$app->get('home','Home@show');
$app->get('configuracoes','Configuracoes@show');
$app->post('configuracoes/upload-certificado','Configuracoes@uploadCertificado');
$app->group([], function() use ($app) {
    define('DOMPDF_ENABLE_AUTOLOAD',false);
    $app->get('sefaz/gerar-guias','GerarGuias@pdfLotes');
    $app->get('sefaz/gerar-guias/{id}','GerarGuias@pdfGuia');
});
$app->get('sefaz/enviar-lote','Lotes@enviar');
$app->get('sefaz/consultar-lote','Lotes@consultar');
$app->get('sefaz/consultar-recibo/{numero}','Lotes@consultarRecibo');
$app->get('sefaz/atualizar-receitas','Receita@atualizar');
$app->get('sefaz/consultar-uf/{uf}/{receita}','ConsultarUF@consultarUf');

$app->group([], function() {
    define('STATUS_INCLUIDO','1');
    define('STATUS_ENVIADO','2');
    define('STATUS_PROCESSADO','3');
    define('STATUS_PENDENCIA','4');
    define('STATUS_CONTINGENCIA','5');
    define('STATUS_GUIAGERADA','6');
    define('STATUS_FALHA','8');
    define('STATUS_REJEICAO','9');
});