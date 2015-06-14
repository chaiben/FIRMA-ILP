<?php

class Application_Model_FirmaXML
{
    private $doc;
    private $firmed_doc;

    public function __construct(){

    }

    public function getDoc(){
        return $this->doc;
    }

    public function createXMLDoc($nomb, $ape1, $ape2, $fnac, $tipoid, $id, $tituloilp, $codigoilp){
        $ilp_array = array(
            "firmante" => array(
                "nomb" => $nomb,
                "ape1" => $ape1,
                "ape2" => $ape2,
                "fnac" => $fnac,
                "tipoid" => $tipoid,
                "id" => $id
                ),
            "datosilp" => array(
                "tituloilp" => $tituloilp,
                "codigoilp" => $codigoilp
                )
            );

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><ilp/>');
        self::array_to_xml($ilp_array,$xml);
        $this->doc = $xml->asXML();
        return $this->doc;
    }

    public static function array_to_xml($values_array, &$xml) {
        foreach($values_array as $key => $value) {
            if(is_array($value)) {
                if(!is_numeric($key)){
                    $subnode = $xml->addChild("$key");
                    self::array_to_xml($value, $subnode);
                }
                else{
                    $subnode = $xml->addChild("item$key");
                    self::array_to_xml($value, $subnode);
                }
            }
            else {
                $xml->addChild("$key",htmlspecialchars("$value"));
            }
        }
    }
}
