<?php

class FirmaXMLTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function setUp()
    {
        $this->bootstrap = new Zend_Application('development', APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }

    public function testCreateXMLDoc(){
        $nomb = "nomb";
        $ape1 = "ape1";
        $ape2 = "ape2";
        $fnac = "fnac";
        $tipoid = "tipoid";
        $id = "id";
        $tituloilp = "tituloilp";
        $codigoilp = "codigoilp";
        $firmaXML = new Application_Model_FirmaXML();

        $firmaXML->createXMLDoc($nomb, $ape1, $ape2, $fnac, $tipoid, $id, $tituloilp, $codigoilp);


        $this->assertXmlStringEqualsXmlString('<ilp> <firmante> <nomb>nomb</nomb> <ape1>ape1</ape1> <ape2>ape2</ape2> <fnac>fnac</fnac> <tipoid>tipoid</tipoid> <id>id</id> </firmante> <datosilp> <tituloilp>tituloilp</tituloilp> <codigoilp>codigoilp</codigoilp> </datosilp> </ilp>', $firmaXML->getDoc());
    }
}