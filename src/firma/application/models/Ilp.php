<?php

class Application_Model_Ilp
{
    private $ilp_id;
    private $ilp_code;
    private $ilp_title;
    private $ilp_short_desc;
    private $ilp_long_desc;
    private $ilp;
    private $ilp_start_date;
    private $ilp_end_date;
    private $ilp_create_date;
    private $ilp_update_date;

    public function __construct($row = null){
        if( !is_null($row) && $row instanceof Zend_Db_Table_Row ) {
            $this->ilp_id = $row->ilp_id;
            $this->ilp_code = $row->ilp_code;
            $this->ilp_title = $row->ilp_title;
            $this->ilp_short_desc = $row->ilp_short_desc;
            $this->ilp_long_desc = $row->ilp_long_desc;
            $this->ilp = $row->ilp;
            $this->ilp_start_date = $row->ilp_start_date;
            $this->ilp_end_date = $row->ilp_end_date;
            $this->ilp_create_date = $row->ilp_create_date;
            $this->ilp_update_date = $row->ilp_update_date;
        }
    }

    public function getStartDate($format="dd/MM/YYYY"){
        $date = new Zend_Date($this->ilp_start_date);
        return $date->get($format);
    }

    public function getEndDate($format="dd/MM/YYYY"){
        $date = new Zend_Date($this->ilp_end_date);
        return $date->get($format);
    }

    public function __set($name, $value){
        $this->$name = $value;
    }


    public function __get($name){
        return $this->$name;
    }

}

