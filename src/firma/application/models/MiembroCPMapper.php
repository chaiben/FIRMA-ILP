<?php

class Application_Model_MiembroCPMapper
{
    protected $_db_table;

    public function __construct(){
        $this->_db_table = new Application_Model_DbTable_MiembroCP();
    }

    public function save(Application_Model_MiembroCP $miembroCP_object){
        $data = array(
            "mc_email" => $miembroCP_object->mc_email,
            "mc_name" => $miembroCP_object->mc_name,
            "mc_lastname" => $miembroCP_object->mc_lastname,
            "mc_phone1" => $miembroCP_object->mc_phone1,
            "mc_phone2" => $miembroCP_object->mc_phone2,
            "mc_salt" => $miembroCP_object->mc_salt,
            "mc_password" => $miembroCP_object->mc_password,
        );

        if( is_null($miembroCP_object->mc_id) ) {
            $data['mc_salt'] = $miembroCP_object->mc_salt;
            $data['mc_created_date'] = date('Y-m-d H:i:s');
            $data['mc_update_date'] = $data['mc_created_date'];
            $this->_db_table->insert($data);
        } else {
            $data['mc_update_date'] = date('Y-m-d H:i:s');
            $this->_db_table->update($data, array('mc_id = ?' => $miembroCP_object->mc_id));
        }

    }

    public function load($id){
        $result = $this->_db_table->find($id);
        if( count($result) == 0 ) {
            throw new Exception('MiembroCP not found');
        }

        $row = $result->current();
        $miembroCP_object = new Application_Model_MiembroCP($row);

        return $miembroCP_object;
    }

    public function loadByEmail($mc_email){
        $result = $this->_db_table->select()
            ->where('mc_email = ?', $mc_email);

        if( count($result) == 0 ) {
            throw new Exception('MiembroCP not found');
        }

        $row = $this->_db_table->fetchRow($result);
        $miembroCP_object = new Application_Model_MiembroCP($row);

        return $miembroCP_object;
    }

}

