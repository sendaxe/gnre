<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Home extends Controller {

    public function show() {
        $arrEmpresas = app('db')->select("SELECT emp.codigo, emp.nome, emp.cnpj FROM senda.cad_01_02 emp WHERE EXISTS(SELECT cod_empresa FROM senda.cad_01_02_a1 aux WHERE aux.cod_empresa = emp.codigo AND aux.gera_gnre = 'T' LIMIT 1) ORDER BY emp.codigo", []);
        if (count($arrEmpresas) == 1){
            return redirect()->route('empresa', ['id_empresa'=>end($arrEmpresas)->codigo]);
        }
        return view('home', ['arrEmpresas'=>$arrEmpresas]);
    }
}
