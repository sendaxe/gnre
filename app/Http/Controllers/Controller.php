<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController {

    private $empresa;

    public function __construct() {
        
    }

    public function getEmpresaById($id_empresa) {
        if (!empty($id_empresa) && is_numeric($id_empresa) && empty($this->empresa)) {
            $this->empresa = app('db')->select(
                    "SELECT " .
                    "   emp.codigo, " .
                    "   emp.nome, " .
                    "   emp.apelido, " .
                    "   emp.cnpj, " .
                    "   (SELECT COUNT(1) FROM senda.cad_01_02_a1 a WHERE a.gera_gnre = 'T') AS qtd_habilitadas, " .
                    "   aux.* " .
                    "   REPLACE(aux.gnre_pasta_guias, chr(92), chr(92)||chr(92)) AS pasta_guias, " .
                    "   REPLACE(aux.gnre_pasta_xml, chr(92), chr(92)||chr(92)) AS pasta_xml " .
                    "FROM senda.cad_01_02 emp " .
                    "LEFT JOIN senda.cad_01_02_a1 aux ON (aux.cod_empresa = emp.codigo)" .
                    "WHERE emp.codigo = ?" .
                    "AND aux.gera_gnre = 'T'" .
                    "LIMIT 1"
                    , [$id_empresa]
            );
            $this->empresa = end($this->empresa);
        }
        if(!$this->empresa){
            $this->empresa = NULL;
        }
        return $this->empresa;
    }

    function getEmpresa() {
        return $this->empresa;
    }

    function setEmpresa($empresa) {
        $this->empresa = $empresa;
    }

    function validarParametrosEmpresa($empresa = NULL) {
        if (empty($empresa)) {
            $empresa = $this->empresa;
        }
        $arrMensagens = [];
        if (!empty($empresa)) {
            if (empty($empresa->pasta_guias)) {
                $arrMensagens[] = ['mensagem' => 'Pasta para geração de PDF não informado no cadastro de empresas.'];
            } else {
                if (!file_exists($empresa->pasta_guias)) {
                    $arrMensagens[] = ['mensagem' => 'Pasta para geração de PDF não está acessível.'];
                }
            }
            if (empty($empresa->pasta_xml)) {
                $arrMensagens[] = ['mensagem' => 'Pasta para geração de XML não informado no cadastro de empresas.'];
            } else {
                if (!file_exists($empresa->pasta_xml)) {
                    $arrMensagens[] = ['mensagem' => 'Pasta para geração de XML não está acessível.'];
                }
            }
            if (empty($empresa->gnre_ambiente) && $empresa->gnre_ambiente != 0) {
                $arrMensagens[] = ['mensagem' => 'Ambiente não informado no cadastro de empresas.'];
            }
        } else {
            $arrMensagens[] = ['mensagem' => 'Empresa não habilitada ou indisponível.'];
        }
        if(!empty($arrMensagens)){
            array_unshift($arrMensagens,['mensagem' => 'VERIFICAR CONFIGURAÇÕES']);
        }
        return $arrMensagens;
    }

}
