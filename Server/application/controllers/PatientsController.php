<?php

class PatientsController extends Zend_Rest_Controller{

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
    // GET /patients/:rfid

    $rfid = $this->getRequest()->getParam("id");

    $tag = $this->_em->getRepository("Application_Model_Rfid")->findOneBy(array("tag"=>$rfid));

    if(!empty($tag)){
      $response["statuscode"] = 200;
      $response["statusmessage"] = "User was found.";
      $response["response"]["userId"] = $tag->getPatient()->getId();
      $response["response"]["firstname"] = $tag->getPatient()->getFirstname();
      $response["response"]["lastname"] = $tag->getPatient()->getLastname();

      $measurement["id"] = "999";
      $measurement["type"] = "temperature";
      $measurement["value"] = "32";
      $measurement["note"] = "Hello Developers - World";
      $measurement["date"] = "2011-11-20 12:33:45";

      $response["response"]["measurements"][] = $measurement;
      $response["response"]["measurements"][] = $measurement;
      $response["response"]["measurements"][] = $measurement;
    }else{
      $response["statuscode"] = 404;
      $response["statusmessage"] = "No patient with this RFID found.";
    }
    $this->getResponse()->appendBody(json_encode($response));
  }

  public function postAction(){
    $response = "404";
    $this->getResponse()->appendBody($response);
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

