<?php

/**
 * Este arquivo é parte do programa GNRE PHP
 * GNRE PHP é um software livre; você pode redistribuí-lo e/ou
 * modificá-lo dentro dos termos da Licença Pública Geral GNU como
 * publicada pela Fundação do Software Livre (FSF); na versão 2 da
 * Licença, ou (na sua opinião) qualquer versão.
 * Este programa é distribuído na esperança de que possa ser  útil,
 * mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer
 * MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a
 * Licença Pública Geral GNU para maiores detalhes.
 * Você deve ter recebido uma cópia da Licença Pública Geral GNU
 * junto com este programa, se não, escreva para a Fundação do Software
 * Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

namespace Sped\Gnre\Sefaz\Estados;

use Sped\Gnre\Sefaz\Guia;
use Sped\Gnre\Parser\Util;

abstract class Padrao {

    /**
     * @param \DOMDocument $gnre
     * @param \Sped\Gnre\Sefaz\Guia $gnreGuia
     * @return mixed
     */
    public function getNodeCamposExtras(\DOMDocument $gnre, Guia $gnreGuia) {
        if (is_array($gnreGuia->c39_camposExtras) && count($gnreGuia->c39_camposExtras) > 0) {
            $c39_camposExtras = $gnre->createElement('c39_camposExtras');

            foreach ($gnreGuia->c39_camposExtras as $key => $campos) {
                $campoExtra = $gnre->createElement('campoExtra');
                $codigo = $gnre->createElement('codigo', $campos['campoExtra']['codigo']);
                $tipo = $gnre->createElement('tipo', $campos['campoExtra']['tipo']);
                $valor = $gnre->createElement('valor', $campos['campoExtra']['valor']);

                $campoExtra->appendChild($codigo);
                $campoExtra->appendChild($tipo);
                $campoExtra->appendChild($valor);

                $c39_camposExtras->appendChild($campoExtra);
            }

            return $c39_camposExtras;
        }

        return null;
    }

    /**
     * @param \DOMDocument $gnre
     * @param \Sped\Gnre\Sefaz\Guia $gnreGuia
     * @return \DOMElement
     */
    public function getNodeReferencia(\DOMDocument $gnre, Guia $gnreGuia) {
        if (!$gnreGuia->periodo && !$gnreGuia->mes && !$gnreGuia->ano && !$gnreGuia->parcela) {
            return null;
        }
        $c05 = $gnre->createElement('c05_referencia');
        if (is_numeric($gnreGuia->periodo)) {
            $periodo = $gnre->createElement('periodo', $gnreGuia->periodo);
            $c05->appendChild($periodo);
        }
        if (!empty(Util::getValue($gnreGuia->mes)) && is_numeric($gnreGuia->mes)) {
            $mes = $gnre->createElement('mes', $gnreGuia->mes);
            $c05->appendChild($mes);
        }
        if (!empty(Util::getValue($gnreGuia->ano)) && is_numeric($gnreGuia->ano)) {
            $ano = $gnre->createElement('ano', $gnreGuia->ano);
            $c05->appendChild($ano);
        }
        if (!empty(Util::getValue($gnreGuia->parcela)) && is_numeric($gnreGuia->parcela)) {
            $parcela = $gnre->createElement('parcela', $gnreGuia->parcela);
            $c05->appendChild($parcela);
        }
        return $c05;
    }

}
