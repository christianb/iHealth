<?php

class MeasurementsController extends Zend_Rest_Controller{

  public function init(){
    $this->_em = Zend_Registry::getInstance()->entitymanager;
    $this->_helper->viewRenderer->setNoRender(true);
    $this->view->layout()->disableLayout();
  }

  public function indexAction(){
    
  }

  public function getAction(){
    $typeName = $this->getRequest()->getParam("type");
    $patientId = $this->getRequest()->getParam("patientId");
    $limit = $this->getRequest()->getParam("limit");

    $patient = $this->_em->getRepository("Application_Model_Patient")->findOneBy(array("id"=>$patientId));
    $type = $this->_em->getRepository("Application_Model_Measurement_Type")->findOneBy(array("name"=>$typeName));

    if(empty($type)){
      $response["statuscode"] = 427;
      $response["statusmessage"] = "Invalid measurement type.";
    }elseif(empty($patient)){
      $response["statuscode"] = 404;
      $response["statusmessage"] = "Patient not found.";
    }elseif(isset($limit) && $limit < 1){
      $response["statuscode"] = 404;
      $response["statusmessage"] = "The limit has to larger than 0.";
    }else{
      if(empty($limit)){
        $limit = 10;
      }
      $response["statuscode"] = 200;
      $response["statusmessage"] = "The measurements were returned successfully.";
      $measurements = $this->_em->getRepository("Application_Model_Measurement")->findBy(array("patient"=>$patient->getId()));

      foreach($measurements as $measurement){
        $patientMeasurement = array();
        $patientMeasurement["id"] = $measurement->getId();
        $patientMeasurement["value"] = $measurement->getValue();
        $patientMeasurement["date"] = $measurement->getDate();
        $patientMeasurement["unit"] = $measurement->getType()->getUnit();
        $patientMeasurement["doctor"]["id"] = $measurement->getPersonnel()->getId();
        $patientMeasurement["doctor"]["name"] = $measurement->getPersonnel()->getName();
        $patientMeasurement["memo"] = $measurement->getMemo();

        $response["measurements"][] = $patientMeasurement;
      }
    }
    $this->getResponse()->appendBody(json_encode($response));
  }

  public function postAction(){
    // POST /measurements
    $typeName = $this->getRequest()->getParam("type");
    $value = $this->getRequest()->getParam("value");
    $note = $this->getRequest()->getParam("note");
    $patientId = $this->getRequest()->getParam('patientId');
    $personnelId = $this->getRequest()->getParam('userId');

    $data = array();
    $data["type"] = $this->_em->getRepository("Application_Model_Measurement_Type")->findOneBy(array("name"=>$typeName));
    $data["value"] = $value;
    $data["memo"] = $note;
    $data["patient"] = $this->_em->getRepository("Application_Model_Patient")->findOneBy(array("id"=>$patientId));
    $data["personnel"] = $this->_em->getRepository("Application_Model_Personnel")->findOneBy(array("id"=>$personnelId));
    $measurement = new Application_Model_Measurement($data);

    if(empty($data["type"])){
      $response["statuscode"] = 427;
      $response["statusmessage"] = "Invalid measurement type.";
    }elseif(empty($data["patient"])){
      $response["statuscode"] = 404;
      $response["statusmessage"] = "Patient not found.";
    }elseif(empty($data["personnel"])){
      $response["statuscode"] = 429;
      $response["statusmessage"] = "User not found.";
    }elseif(empty($data["value"])){
      $response["statuscode"] = 428;
      $response["statusmessage"] = "Value is required.";
    }else{
      // write back to persistence manager and flush it
      $this->_em->persist($measurement);
      $this->_em->flush();

      $response["statuscode"] = 200;
      $response["statusmessage"] = "Measurement was created successfully.";
      $response["response"]["measurementId"] = $measurement->getId();
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