<?php

namespace App\Http\Controllers;

class ControllerLotes extends Controller {

    public function __construct() {
        
    }

    public function getNotificacoesLote($id_lote) {
        return app('db')->select("SELECT msg.* FROM senda.vcom_03_02_01_a10_msg msg WHERE msg.id_lote = ?", [$id_lote]);
    }

}
