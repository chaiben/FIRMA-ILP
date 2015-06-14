<?php

class Application_Model_FirmaMapper
{
    protected $_db_table;

    public function __construct(){
        $this->_db_table = new Application_Model_DbTable_Firma();
    }

    public function save(Application_Model_Firma $object, $fi_doc=null, $ilp_id=null){
        $data = array(
            "fi_doc" => $object->fi_doc,
            "ilp_id" => $object->ilp_id,
            "fi_name" => $object->fi_name,
            "fi_first_surname" => $object->fi_first_surname,
            "fi_second_surname" => $object->fi_second_surname,
            "fi_birthday" => $object->fi_birthday,
            "fi_timestamp" => $object->fi_timestamp,
            "fi_xml" => $object->fi_xml,
        );

        if( is_null($fi_doc) || is_null($ilp_id) ) {
            $this->_db_table->insert($data);
        } else {
            $this->_db_table->update($data, array(
                'fi_doc = ?' => $fi_doc,
                'ilp_id = ?' => $ilp_id,
                )
            );
        }

    }

    public function load($fi_doc, $ilp_id){
        $result = $this->_db_table->find($fi_doc, $ilp_id);
        if( count($result) == 0 ) {
            return false;
        }

        $row = $result->current();
        $object = new Application_Model_Firma($row);

        return $object;
    }

}

