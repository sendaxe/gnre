
{foreach $guiaViaInfo as $key => $via}
    <table cellspacing="0" cellpadding="1" style="width:100%;">
        <tr>
            <td style="width: 65%;" valign="top" class="noborder">
                <table cellspacing="0" cellpadding="1" style="width:100%">
                    <tr>
                        <td class="columnone gnre" colspan="2">
                            Guia Nacional de Recolhimento de Tributos Estaduais - GNRE
                        </td>
                    </tr>
                    <tr>
                        <td class="center nobrdtb" colspan="2">
                            Dados do emitente
                        </td>
                    </tr>
                    <tr>
                        <td class="borderleft">
                            Razão Social
                        </td>
                        <td class="borderright" style="width: 50px">
                            CNPJ/CPF/Insc. Est.
                        </td>
                    </tr>
                    <tr>
                        <td class="borderleft">
                            {$guia->c16_razaoSocialEmitente}
                        </td>
                        <td class="borderright">
                            {$guia->c03_idContribuinteEmitente}
                        </td>
                    </tr>
                    <tr>
                        <td class="notop nobottom" colspan="2">
                            Endereço: {$guia->c18_enderecoEmitente}
                        </td>
                    </tr>
                    <tr>
                        <td class="borderleft">
                            Município: {$guia->c19_municipioEmitente}
                        </td>
                        <td class="borderright">
                            UF: {$guia->c20_ufEnderecoEmitente}
                        </td>
                    </tr>
                    <tr>
                        <td class="noright notop">
                            CEP: {$guia->c21_cepEmitente}
                        </td>
                        <td class="noleft notop">
                            DDD/Telefone: {$guia->c22_telefoneEmitente}
                        </td>
                    </tr>
                    <tr >
                        <td class="center nobrdtb" colspan="2">
                            Dados do Destinatário
                        </td>
                    </tr>
                    <tr>
                        <td class="notop nobottom" colspan="2">
                            CNPJ/CPF/Insc. Est.: {$guia->c35_idContribuinteDestinatario}
                        </td>
                    </tr>
                    <tr>
                        <td class="notop" colspan="2">
                            Município: {$guia->c38_municipioDestinatario}
                        </td>
                    </tr>
                    <tr>
                        <td class="center nobrdtb" colspan="2">
                            Informações à Fiscalização
                        </td>
                    </tr>
                    <tr>
                        <td class="notop nobottom" colspan="2">
                            Convênio/Protocolo: {$guia->c15_convenio}
                        </td>
                    </tr>
                    <tr>
                        <td class="notop" colspan="2">
                            Produto: {$guia->c26_produto}
                        </td>
                    </tr>
                    <tr>
                        <td class="nobrdtb" colspan="2" style="height:67px" valign="top">
                            Informações Complementares: {$guia->retornoInformacoesComplementares}
                        </td>
                    </tr>
                    <tr>
                        <td class="notop" colspan="2">
                            Documento válido para pagamento até {$guia->c14_dataVencimento}
                        </td>
                    </tr>
                </table>
            </td>
            <td class="noborder" valign="top">
                <table cellspacing="0" cellpadding="1" style="width:100%; margin-left: -1px;">
                    <tr>
                        <td class="nobottom">UF Favorecida</td>
                        <td style="width: 120px" colspan="2" class="nobottom">Código da Receita</td>
                    </tr>
                    <tr>
                        <td class="notop" align="right">{$guia->c01_UfFavorecida}</td>
                        <td class="notop" align="right" colspan="2">{$guia->c02_receita}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="nobottom">Nº de Controle</td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right" class="notop">{$guia->retornoNumeroDeControle}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="nobottom">Data de Vencimento</td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right" class="notop">{$guia->c14_dataVencimento}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="nobottom">Nº do Documento de Origem</td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right" class="notop">{$guia->c04_docOrigem}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="nobottom">Período de Referência</td>
                        <td class="nobottom" align="left">Nº Parcela</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="notop" align="right">{($guia->ano > 0)?$guia->mes / $guia->ano:''}</td>
                        <td class="notop" align="right">{$guia->parcela}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="nobottom">Valor Principal</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="notop" align="right">R$ {$guia->c06_valorPrincipal}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="nobottom">Atualização Monetária</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="notop" align="right">R$ {$guia->retornoAtualizacaoMonetaria}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="nobottom">Juros</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="notop" align="right">R$ {$guia->retornoJuros}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="nobottom">Multa</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="notop" align="right">R$ {$guia->retornoMulta}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="nobottom">Total a Recolher</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="notop" align="right">{$guia->c10_valorTotal}</td>
                    </tr>
                    <tr>
                        <td  colspan="3" style="text-align:right;">{$via}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="noborder" style="padding-left:140px;">
                {$guia->retornoRepresentacaoNumerica}
            </td>
        </tr>
        <tr>
            <td class="noborder" style="padding-left:90px;" >
                <img src="data:image/jpeg;base64,{$barcode->getCodigoBarrasBase64()}"/>
            </td>
            <td class="noborder" align="right" >

            </td>
        </tr>
    </table>
    <br/>
{/foreach}