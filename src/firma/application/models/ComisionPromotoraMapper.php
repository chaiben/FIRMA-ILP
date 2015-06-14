<?php

class Application_Model_ComisionPromotoraMapper
{
    protected $_db_table;

    public function __construct(){
        $this->_db_table = new Application_Model_DbTable_ComisionPromotora();
    }

    public function save(Application_Model_ComisionPromotora $object, $ilp_id=null, $mc_id=null){
        $data = array(
            "ilp_id" => $object->ilp_id,
            "mc_id" => $object->mc_id,
            "cp_position" => $object->cp_position,
            "cp_desc" => $object->cp_desc,
            "cp_admin" => $object->cp_admin,
            );

        if( is_null($ilp_id) || is_null($mc_id) ) {
            $this->_db_table->insert($data);
        } else {
            $this->_db_table->update($data, array(
                'ilp_id = ?' => $ilp_id,
                'mc_id = ?' => $mc_id,
                )
            );
        }

    }

    public function load($ilp_id, $mc_id){
        $result = $this->_db_table->find($ilp_id, $mc_id);
        if( count($result) == 0 ) {
            throw new Exception('"CP" not found');
        }

        $row = $result->current();
        $object = new Application_Model_ComisionPromotora($row);

        return $object;
    }

}

