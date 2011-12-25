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

    if(empty($tag)){
      $response["statuscode"] = 404;
      $response["statusmessage"] = "No patient with this RFID found.";
    }else{
      $patient = $tag->getPatient();
      if(empty($patient)){
        $response["statuscode"] = 404;
        $response["statusmessage"] = "No patient with this RFID found.";
      }else{
        $response["statuscode"] = 200;
        $response["statusmessage"] = "User was found.";
        $response["response"]["userId"] = $tag->getPatient()->getId();
        $response["response"]["firstname"] = $tag->getPatient()->getFirstname();
        $response["response"]["lastname"] = $tag->getPatient()->getLastname();
        $response["response"]["bloodGroup"] = $tag->getPatient()->getBloodGroup();
        $response["response"]["size"] = $tag->getPatient()->getSize();

        $response["response"]["address"]["street"] = $tag->getPatient()->getStreet();
        $response["response"]["address"]["zipcode"] = $tag->getPatient()->getZipcode();
        $response["response"]["address"]["city"] = $tag->getPatient()->getCity();
      }
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

