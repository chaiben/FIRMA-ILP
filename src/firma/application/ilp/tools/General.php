<?php

class Ilp_Tool_General
{
    public static function ConvertDateToILP($date){
        $date = str_replace('/', '-', $date);
        return date("Ymd", strtotime($date));

    }

    public static function CreateHash($string, $n = null){
        $n = (is_null($n)) ? rand(1 , 100) : $n;
        $c = $string.SECRET_KEY;
        for($i=0; $i<$n; $i++)
            $c = sha1($c);
        return array($c, $n);
    }

    public static function ValidateHash($hash, $string, $n){
        $result = self::CreateHash($string, $n);
        $hg = $result[0];
        return ($hash == $hg);
    }

    public static function getILPFromXades($xades){
        $xml=simplexml_load_string($xades) or die("Error: Cannot create object");

        $firmaXML = new Application_Model_FirmaXML();
        $xml = $firmaXML->createXMLDoc($xml->firmante->nomb, $xml->firmante->ape1, $xml->firmante->ape2, $xml->firmante->fnac, $xml->firmante->tipoid, $xml->firmante->id, $xml->datosilp->tituloilp, $xml->datosilp->codigoilp);

        return $xml;
    }

    public static function utf8StringToHexString($string) {
        $nums = array();
        $convmap = array(0x0, 0xffff, 0, 0xffff);
        $strlen = mb_strlen($string, "UTF-8");
        for ($i = 0; $i < $strlen; $i++) {
            $ch = mb_substr($string, $i, 1, "UTF-8");
            $decimal = substr(mb_encode_numericentity($ch, $convmap, 'UTF-8'), -5, 4);
            $nums[] = '\u00' .base_convert($decimal, 10, 16);
        }
        return implode("", $nums);
    }
}

?>