<?php

class Application_Model_IlpMapper
{
    protected $_db_table;

    public function __construct(){
        $this->_db_table = new Application_Model_DbTable_Ilp();
    }

    public function save(Application_Model_Ilp $object){
        $data = array(
            "ilp_id"          => $object->ilp_id,
            "ilp_code"        => $object->ilp_code,
            "ilp_title"       => $object->ilp_title,
            "ilp_short_desc"  => $object->ilp_short_desc,
            "ilp_long_desc"   => $object->ilp_long_desc,
            "ilp"             => $object->ilp,
            "ilp_start_date"  => $object->ilp_start_date,
            "ilp_end_date"    => $object->ilp_end_date,
            "ilp_create_date" => $object->ilp_create_date,
            "ilp_update_date" => $object->ilp_update_date,
        );

        if( is_null($object->ilp_id) ) {
            $data['ilp_create_date'] = date('Y-m-d H:i:s');
            $data['ilp_update_date'] = $data['ilp_create_date'];
            $this->_db_table->insert($data);
        } else {
            $data['ilp_update_date'] = $data['ilp_create_date'];
            $this->_db_table->update($data, array(
                'ilp_id = ?' => $object->ilp_id,
                )
            );
        }

    }

    public function load($ilp_code){
        $select = $this->_db_table->select()
            ->where("ilp_code = ?", $ilp_code);
        $result = $this->_db_table->fetchAll($select);
        if( count($result) == 0 ) {
            return false;
        }

        $row = $result->current();
        $object = new Application_Model_Ilp($row);

        return $object;
    }


}

