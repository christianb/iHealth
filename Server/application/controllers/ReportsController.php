<?php

class ReportsController extends Zend_Rest_Controller
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
        // POST /reports/note/:note
        
        $note = $this->getRequest()->getParam("note");
        
        $response["statuscode"] = 100;
        $response["statusmessage"] = "Report was created successfully.";
        $response["response"]["reportId"] = 999;

        $this->getResponse()->appendBody(json_encode($response));
    }
    
    public function putAction()
    {
        // PUT /reports/id/:id/note/:note
        
        $id = $this->getRequest()->getParam("id");
        $note = $this->getRequest()->getParam("note");
        
        $response["statuscode"] = 100;
        $response["statusmessage"] = "Report was updated successfully.";
        $response["response"]["reportId"] = $id;

        $this->getResponse()->appendBody(json_encode($response));
    }
    
    public function deleteAction()
    {
        $response = "404";
        
        $this->getResponse()->appendBody($response);

    }
}