<?php

class Application_Model_MiembroCP
{
    private $mc_id;
    private $mc_email;
    private $mc_name;
    private $mc_lastname;
    private $mc_phone1;
    private $mc_phone2;
    private $mc_salt;
    private $mc_password;
    private $mc_created_date;
    private $mc_update_date;

    public function __construct($row = null){
        if( !is_null($row) && $row instanceof Zend_Db_Table_Row ) {
            $this->mc_id = $row->mc_id;
            $this->mc_email = $row->mc_email;
            $this->mc_name = $row->mc_name;
            $this->mc_lastname = $row->mc_lastname;
            $this->mc_phone1 = $row->mc_phone1;
            $this->mc_phone2 = $row->mc_phone2;
            $this->mc_salt = $row->mc_salt;
            $this->mc_password = $row->mc_password;
            $this->mc_created_date = $row->mc_created_date;
            $this->mc_update_date = $row->mc_update_date;
        }
    }

    public function __set($name, $value){
        switch($name) {
            case 'mc_id':
                if( !is_null($this->mc_id) ) {
                    throw new Exception('Cannot update MiembroCP\'s mc_id!');
                }
                break;
            case 'mc_created_date':
                if( !is_null($this->mc_created_date) ) {
                    throw new Exception('Cannot update MiembroCP\'s mc_created_date');
                }
                break;
            case 'mc_password':
                //if you're updating the mc_password, hash it first with the salt
                $value = sha1($value.$this->mc_salt);
                break;
        }

        //set the attribute with the value
        $this->$name = $value;
    }

    public function __get($name){
        return $this->$name;
    }
}

