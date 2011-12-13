<?php

class LoginController extends Zend_Rest_Controller
{

    public function init()
    {
        
    }
    
    public function indexAction()
    {
        echo "index";
    }

    public function getAction()
    {
        $response = "404";
        
        $this->getResponse()->appendBody($response);
        
        $this->_helper->viewRenderer->setNoRender(true);
    }
    
    public function postAction()
    {
        $username = $this->getRequest()->getParam("username");
        $hash = $this->getRequest()->getParam("hash");
        
        $response["request"] = $this->getRequest()->getParams();
        $response["statuscode"] = 100;
        $response["statusmessage"] = "User was logged in successfully.";
        $response["response"]["userId"] = 999;

        $this->getResponse()->appendBody(json_encode($response));
        
        $this->_helper->viewRenderer->setNoRender(true);
    }
    
    public function putAction()
    {
        $response = "404";
        
        $this->getResponse()->appendBody($response);
        
        $this->_helper->viewRenderer->setNoRender(true);

    }
    
    public function deleteAction()
    {
        $response = "404";
        
        $this->getResponse()->appendBody($response);
        
        $this->_helper->viewRenderer->setNoRender(true);

    }
}