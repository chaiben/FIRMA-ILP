<?php

class MiembroCPTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function setUp()
    {
        $this->bootstrap = new Zend_Application('development', APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }

    public function testLoad(){
        $miembro_cp_mapper = new Application_Model_MiembroCPMapper();
        $miembro_cp = $miembro_cp_mapper->loadByEmail('test@gmail.com');
        $this->assertSame('11',              $miembro_cp->mc_id,       '"mc_id" was not load correctly');
        $this->assertSame('test@gmail.com',  $miembro_cp->mc_email,    '"mc_email" was not load correctly');
        $this->assertSame('Marçal',          $miembro_cp->mc_name,     '"mc_name" was not load correctly');
        $this->assertSame('Machado Chaiben', $miembro_cp->mc_lastname, '"mc_lastname" was not load correctly');
        $this->assertSame('677527749',       $miembro_cp->mc_phone1,   '"mc_phone1" was not load correctly');
        $this->assertSame('',                $miembro_cp->mc_phone2,   '"mc_phone2" was not load correctly');
    }

    public function testSave(){
        $miembro_cp_mapper = new Application_Model_MiembroCPMapper();
        $miembro_cp = $miembro_cp_mapper->loadByEmail('test@gmail.com');
        $miembro_cp->mc_email = "test1@gmail.com";
        $miembro_cp_mapper->save($miembro_cp);
        $miembro_cp = $miembro_cp_mapper->load($miembro_cp->mc_id);
        $this->assertSame(
            'test1@gmail.com',
            $miembro_cp->mc_email,
            '"Email" was not saved correctly'
        );
        $miembro_cp->mc_email = "test@gmail.com";
        $miembro_cp_mapper->save($miembro_cp);

    }
}
