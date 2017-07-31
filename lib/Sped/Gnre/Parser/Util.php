<?php

namespace Sped\Gnre\Parser;

class Util {

    /**
     * Esse método é utilizado para obter o valor de uma determinada tag
     * em um xml que contenha campos únicos em todo o seu contexto
     * @see \Sped\Gnre\Parser\SefazRetorno
     * @param string $content
     * @param int $positionStart
     * @param int $length
     * @return string
     */
    public static function getTag($content, $tag) {
        $startTag = 0;
        $endTag = 0;
        if (strpos($content, '<' . $tag . '>') !== FALSE) {
            $startTag = (strpos($content, '<' . $tag . '>') + strlen('<' . $tag . '>'));
        } else if (strpos($content, '<' . $tag)) {
            $startTag = strpos($content, '>', strpos($content, '<' . $tag)) + 1; //'<tag codigo="">teste</tag>'
        }
        $endTag = strpos($content, '</' . $tag . '>');
        if ($startTag > 0 && $endTag > 0) {
            return substr($content, $startTag, $endTag - $startTag);
        }
        return null;
    }

    public static function getTagAtributo($content, $atributo) {
        $startAtt = 0;
        $endAtt = 0;
        if (strpos($content, $atributo . '="') !== FALSE) {
            $startAtt = (strpos($content, $atributo . '="') + strlen($atributo . '="'));
            if ($startAtt > 0) {
                $endAtt = strpos($content,'"',$startAtt);
            }
        } else if (strpos($content, $atributo . '=') !== FALSE) {
            $startAtt = (strpos($content, $atributo . '=') + strlen($atributo . '='));
            if ($startAtt > 0) {
                $endAtt = strpos($content,' ',$startAtt);
            }
        }
        if ($startAtt > 0 && $endAtt > 0) {
            return substr($content, $startAtt, $endAtt - $startAtt);
        }
        return null;
    }

    public static function getValue($value) {
        return (empty($value) && $value <> "0") ? NULL : $value;
    }

    public static function convertDateDB($dateDB) {
        if (!empty($dateDB) && strpos($dateDB, '-') !== FALSE) {
            return date('d/m/Y', strtotime($dateDB));
        }
        return null;
    }

}
