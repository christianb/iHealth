<?php

class LoginController extends Zend_Rest_Controller{

  public function init(){
    $this->_em = Zend_Registry::getInstance()->entitymanager;
    $this->_helper->viewRenderer->setNoRender(true);
    $this->view->layout()->disableLayout();
  }

  public function indexAction(){
    $response = "404";

    $this->getResponse()->appendBody($response);
  }

  public function getAction(){
    $response = "404";

    $this->getResponse()->appendBody($response);
  }

  public function postAction(){
    $username = $this->getRequest()->getParam("username");
    $password = $this->getRequest()->getParam("hash");

    $auth = Zend_Auth::getInstance();
    $adapter = new Unplagged_Auth_Adapter_Doctrine($this->_em, "Application_Model_Personnel", "username", "password", $username, $password);
    $result = $auth->authenticate($adapter);

    if($result->isValid()){
      $user = $result->getIdentity();

      $response["statuscode"] = 200;
      $response["statusmessage"] = "User was logged in successfully.";
      $response["response"]["userId"] = $user->getId();
    }else{
      $response["statuscode"] = 404;
      $response["statusmessage"] = "User not found.";
    }

    $this->getResponse()->appendBody(json_encode($response));
  }

  public function putAction(){
    $response = "404";

    $this->getResponse()->appendBody($response);
  }

  public function deleteAction(){
    $response = "404";

    $this->getResponse()->appendBody($response);
  }

}