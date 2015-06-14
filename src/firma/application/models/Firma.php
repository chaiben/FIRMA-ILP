<?php

class Application_Model_Firma
{
    private $fi_doc;
    private $ilp_id;
    private $fi_name;
    private $fi_first_surname;
    private $fi_second_surname;
    private $fi_birthday;
    private $fi_timestamp;
    private $fi_xml;

    public function __construct($row = null){
        if( !is_null($row) && $row instanceof Zend_Db_Table_Row ) {
            $this->fi_doc = $row->fi_doc;
            $this->ilp_id = $row->ilp_id;
            $this->fi_name = $row->fi_name;
            $this->fi_first_surname = $row->fi_first_surname;
            $this->fi_second_surname = $row->fi_second_surname;
            $this->fi_birthday = $row->fi_birthday;
            $this->fi_timestamp = $row->fi_timestamp;
            $this->fi_xml = $row->fi_xml;
        }
    }

    public function __set($name, $value){
        $this->$name = $value;
    }


    public function __get($name){
        return $this->$name;
    }

    public function loadFromXades($xades){
        $xml=simplexml_load_string($xades) or die("Error: Cannot create object");

        $ilp_mapper = new Application_Model_IlpMapper();
        $ilp = $ilp_mapper->load($xml->datosilp->codigoilp);

        $this->fi_doc = (string) $xml->firmante->id;
        $this->ilp_id = $ilp->ilp_id;
        $this->fi_name = (string) $xml->firmante->nomb;
        $this->fi_first_surname = (string) $xml->firmante->ape1;
        $this->fi_second_surname = (string) $xml->firmante->ape2;
        $this->fi_birthday = substr((string) $xml->firmante->fnac, 0, 4)."-".substr((string) $xml->firmante->fnac, 4, 2)."-".substr((string)$xml->firmante->fnac, 6, 2);
        $this->fi_timestamp = date("Y-m-d H:i:s");
        $this->fi_xml = $xades;
    }

    public function saveFromXades($xades){
        $this->loadFromXades($xades);
        $ilp_mapper = new Application_Model_FirmaMapper();
        $ilp_mapper->save($this);
    }

}

