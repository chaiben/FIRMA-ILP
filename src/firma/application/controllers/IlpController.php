<?php

class IlpController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $code = ($this->getRequest()->getParam("code")) ? $this->getRequest()->getParam("code") : "ILP2015001";

    // Get ILP info
        $ilp_mapper = new Application_Model_IlpMapper();
        $ilp = $ilp_mapper->load($code);

        $this->view->ilp = $ilp;

    }

    public function getDocAction()
    {
        $result = array("error" => "");

        $this->_helper->layout()->disableLayout();
        // Receiving data from POST
        $name_input = mb_strtoupper($this->getRequest()->getPost("name_input"), 'UTF-8');
        $first_surname = mb_strtoupper($this->getRequest()->getPost("first_surname"), 'UTF-8');
        $second_surname = mb_strtoupper($this->getRequest()->getPost("second_surname"), 'UTF-8');
        $birthday_input = mb_strtoupper($this->getRequest()->getPost("birthday_input"), 'UTF-8');
        $birthday_input = Ilp_Tool_General::ConvertDateToILP($birthday_input);
        $doc = mb_strtoupper($this->getRequest()->getPost("doc"), 'UTF-8');
        $ilp_code = $this->getRequest()->getPost("ilp_code");

        // Check received data
        if(empty($name_input)){
            $result["error"] = $this->view->translate('El campo "Nombre" no puede ser vacío.');
        }
        if(empty($first_surname)){
            $result["error"] = $this->view->translate('El campo "Primer Apellido" no puede ser vacío.');
        }
        if(empty($second_surname)){
            $result["error"] = $this->view->translate('El campo "Segundo Apellido" no puede ser vacío.');
        }
        if(empty($birthday_input)){
            $result["error"] = $this->view->translate('Error en el campo "Fecha de nacimiento".');
        }
        if(empty($doc)){
            $result["error"] = $this->view->translate('El campo "DNI" no puede ser vacío.');
        }
        if(empty($ilp_code)){
            $result["error"] = $this->view->translate('No fue enviado el código de la ILP');
        }


        // Get ilp info
        $ilp_mapper = new Application_Model_IlpMapper();
        $ilp = $ilp_mapper->load($ilp_code);
        if(!$ilp){
            $result['error'] = $this->view->translate("ILP invalida.");
            $this->view->result = $result;
            return;
        }

        // Check if this DNI already sign this ILP
        $firma_mapper = new Application_Model_FirmaMapper();
        $firma = $firma_mapper->load($doc, $ilp->__get("ilp_id"));
        if($firma){
            $result['error'] = $this->view->translate("Ya has firmado esta ILP.");
            $this->view->result = $result;
            return;
        }

        // Create XML for the ILP
        $firmaXML = new Application_Model_FirmaXML();
        $result["doc_xml"] = $firmaXML->createXMLDoc($name_input, $first_surname, $second_surname, $birthday_input, "DNI", $doc, $ilp->__get("ilp_title"), $ilp->__get("ilp_code"));

        // Create Hash to avoid user change XML
        $createHash = Ilp_Tool_General::createHash($result["doc_xml"]);
        $result["h"] = $createHash[0];
        $result["n"] = $createHash[1];
        $STR = Ilp_Tool_General::utf8StringToHexString("$first_surname $second_surname $name_input");
        $result["filter"] = "*$STR*$doc*";

        $this->view->result = $result;
    }

    public function getSignXML()
    {
    }

    public function saveSignAction()
    {
        $this->_helper->layout()->disableLayout();
        // Receiving data from POST
        $xml_hash = $this->getRequest()->getPost("xml_hash");
        $n = $this->getRequest()->getPost("n");
        $xml_signed = $this->getRequest()->getPost("xml_signed");

        $ilp_xml = Ilp_Tool_General::getILPFromXades($xml_signed);
        $valid = Ilp_Tool_General::ValidateHash($xml_hash, $ilp_xml, $n);

        if($valid){
            // It's a valid xml - save it at Database
            $firma = new Application_Model_Firma();
            $firma->saveFromXades($xml_signed);
            $result["error"] = 0;
        } else {
            // Invalid xml data.
            $result["error"] = 1;
            $result["xml"] = $xml_signed;
        }
        $this->view->result = $result;
    }
}



