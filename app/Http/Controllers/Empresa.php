<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Empresa extends Controller {

    public function show(Request $request, $id_empresa) {
        parent::getEmpresaById($id_empresa);
        return view('empresa', ['empresa' => $this->getEmpresaById($id_empresa)]);
    }

}
