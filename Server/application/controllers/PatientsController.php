<?php

class PatientsController extends Zend_Rest_Controller{

  public function init(){
    
  }

  public function getAction(){
    // GET /patients/:rfid

    $rfid = $this->getRequest()->getParam("rfid");

    $response["request"] = $this->getRequest()->getParams();
    $response["statuscode"] = 100;
    $response["statusmessage"] = "User was found.";
    $response["response"]["userId"] = 999;
    $response["response"]["firstname"] = "Max";
    $response["response"]["lastname"] = "Mustermann";

    $measurement["id"] = "999";
    $measurement["type"] = "temperature";
    $measurement["value"] = "32";
    $measurement["note"] = "Hello Developers - World";
    $measurement["date"] = "2011-11-20 12:33:45";

    $response["response"]["measurements"][] = $measurement;
    $response["response"]["measurements"][] = $measurement;
    $response["response"]["measurements"][] = $measurement;

    $this->getResponse()->appendBody(json_encode($response));
    $this->_helper->viewRenderer->setNoRender(true);
  }

  public function postAction(){
    $response = "404";
    $this->getResponse()->appendBody($response);
    $this->_helper->viewRenderer->setNoRender(true);
  }

  public function putAction(){
    $response = "404";
    $this->getResponse()->appendBody($response);
    $this->_helper->viewRenderer->setNoRender(true);
  }

  public function deleteAction(){
    $response = "404";
    $this->getResponse()->appendBody($response);
    $this->_helper->viewRenderer->setNoRender(true);
  }

}

