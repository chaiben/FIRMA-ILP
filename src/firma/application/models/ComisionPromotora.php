<?php

class Application_Model_ComisionPromotora
{
    private $ilp_id;
    private $mc_id;
    private $cp_position;
    private $cp_desc;
    private $cp_admin;

    public function __construct($row = null){
        if( !is_null($row) && $row instanceof Zend_Db_Table_Row ) {
            $this->ilp_id = $row->ilp_id;
            $this->mc_id = $row->mc_id;
            $this->cp_position = $row->cp_position;
            $this->cp_desc = $row->cp_desc;
            $this->cp_admin = $row->cp_admin;
        }
    }

    public function __set($name, $value){
        $this->$name = $value;
    }


    public function __get($name){
        return $this->$name;
    }

}

