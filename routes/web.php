<?php

use Illuminate\Http\Request;

$app->get('/', 'Home@show');
$app->get('home', 'Home@show');
$app->get('configuracoes', 'Configuracoes@show');
$app->post('configuracoes/upload-certificado', 'Configuracoes@uploadCertificado');
$app->group([], function() use ($app) {
    $app->get('sefaz/gerar-guias', 'GerarGuias@pdfLotes');
    $app->get('sefaz/gerar-guias/{id}', 'GerarGuias@pdfGuia');
});
$app->get('sefaz/enviar-lote', 'Lotes@enviar');
$app->get('sefaz/consultar-lote', 'Lotes@consultar');
$app->get('sefaz/consultar-recibo/{numero}', 'Lotes@consultarRecibo');
$app->get('sefaz/atualizar-receitas', 'ConsultarUF@atualizar');
$app->get('sefaz/consultar-uf/{uf}/{receita}', 'ConsultarUF@consultarUf');
$app->get('sefaz/enviar-consultar-gerar', 'Lotes@enviarConsultarGerar');
