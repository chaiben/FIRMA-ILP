<?php

class ComisionPromotoraTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function setUp()
    {
        $this->bootstrap = new Zend_Application('development', APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }

    public function testLoad(){
        $object_mapper = new Application_Model_ComisionPromotoraMapper();
        $object = $object_mapper->load(1, 11);
        $this->assertSame('1',     $object->ilp_id,      '"ilp_id" was not load correctly'      );
        $this->assertSame('11',    $object->mc_id,       '"mc_id" was not load correctly'       );
        $this->assertSame('Admin', $object->cp_position, '"cp_position" was not load correctly' );
        $this->assertSame('Desc',  $object->cp_desc,     '"cp_desc" was not load correctly'     );
        $this->assertSame('1',     $object->cp_admin,    '"cp_admin" was not load correctly'    );
    }

    public function testSave(){
        $object_mapper = new Application_Model_ComisionPromotoraMapper();
        $object = $object_mapper->load(1, 11);
        $object->cp_position = 'Admin2';
        $object_mapper->save($object, $object->ilp_id, $object->mc_id);
        $object = $object_mapper->load($object->ilp_id, $object->mc_id);
        $this->assertSame('Admin2', $object->cp_position, '"cp_position" was not saved correctly');
        $object->cp_position = 'Admin';
        $object_mapper->save($object, $object->ilp_id, $object->mc_id);
    }
}