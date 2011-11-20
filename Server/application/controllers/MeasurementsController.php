<?php

class MeasurementsController extends Zend_Rest_Controller
{

    public function init()
    {
        $this->_helper->viewRenderer->setNoRender(true);
    }
    
    public function indexAction()
    {
        $response = "404";
        $this->getResponse()->appendBody($response);
    }

    public function getAction()
    {
        $response = "404";
        
        $this->getResponse()->appendBody($response);
    }
    
    public function postAction()
    {
         // POST /measurements/reportid/:reportid/type/:type/value/:value/note/:note
        $id = $this->getRequest()->getParam("id");
        $type = $this->getRequest()->getParam("type");
        $value = $this->getRequest()->getParam("value");
        $note = $this->getRequest()->getParam("note");
        
        $response["statuscode"] = 100;
        $response["statusmessage"] = "Measurement was created successfully.";
        $response["response"]["measurementId"] = 999;

        $this->getResponse()->appendBody(json_encode($response));
    }
    
    public function putAction()
    {
        $response = "404";
        $this->getResponse()->appendBody($response);
    }
    
    public function deleteAction()
    {
        $response = "404";
        $this->getResponse()->appendBody($response);
    }
}