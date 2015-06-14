<?php

class IlpTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function setUp()
    {
        $this->bootstrap = new Zend_Application('development', APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }

    public function testLoad(){
        $object_mapper = new Application_Model_IlpMapper();
        $object = $object_mapper->load("ilpCode");
        $this->assertSame('1',            $object->ilp_id,          '"ilp_id" was not load correctly'         );
        $this->assertSame('ilpCode',      $object->ilp_code,        '"ilp_code" was not load correctly'       );
        $this->assertSame('ilpTitle',     $object->ilp_title,       '"ilp_title" was not load correctly'      );
        $this->assertSame('ilpShortDesc', $object->ilp_short_desc,  '"ilp_short_desc" was not load correctly' );
        $this->assertSame('ilpLongDesc',  $object->ilp_long_desc,   '"ilp_long_desc" was not load correctly'  );
        $this->assertSame('ilpTEXT',      $object->ilp,             '"ilp" was not load correctly'            );

        $object = $object_mapper->load("invalidIlp");
        $this->assertSame(false, $object);
    }

    public function testSave(){
        $object_mapper = new Application_Model_IlpMapper();
        $object = $object_mapper->load("ilpCode");
        $object->ilp = "Text2";
        $object_mapper->save($object);
        $object = $object_mapper->load($object->ilp_code);
        $this->assertSame('Text2', $object->ilp, '"Ilp" was not saved correctly');
        $object->ilp = "ilpTEXT";
        $object_mapper->save($object);
    }
}
