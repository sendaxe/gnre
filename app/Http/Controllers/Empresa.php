<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Empresa extends Controller {

    public function show(Request $request, $id_empresa) {
        if (!is_numeric($id_empresa) || empty($this->getEmpresaById($id_empresa))) {
            return view('errors.404', []);
        }
        return view('empresa', ['empresa' => $this->getEmpresaById($id_empresa)]);
    }

}
