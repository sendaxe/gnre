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
                    "FROM senda.cad_01_02 emp " .
                    "LEFT JOIN senda.cad_01_02_a1 aux ON (aux.cod_empresa = emp.codigo)" .
                    "WHERE emp.codigo = ?" .
                    "LIMIT 1"
                    , [$id_empresa]
            );
            $this->empresa = end($this->empresa);
        }
        return $this->empresa;
    }

    function getEmpresa() {
        return $this->empresa;
    }

    function setEmpresa($empresa) {
        $this->empresa = $empresa;
    }
}
