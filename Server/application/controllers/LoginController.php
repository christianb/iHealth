<?php

class LoginController extends Zend_Rest_Controller
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
        // GET /login/username/:username/password/:password
        
        $username = $this->getRequest()->getParam("username");
        $password = $this->getRequest()->getParam("password");
        
        $response["statuscode"] = 100;
        $response["statusmessage"] = "User was logged in successfully.";
        $response["response"]["userId"] = 999;

        $this->getResponse()->appendBody(json_encode($response));
    }
    
    public function postAction()
    {
        $response = "404";
        
        $this->getResponse()->appendBody($response);
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