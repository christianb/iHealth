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
        $response["statusmessage"] = "Patient was found.";
        $response["response"]["patientId"] = $tag->getPatient()->getId();
        $response["response"]["firstname"] = $tag->getPatient()->getFirstname();
        $response["response"]["lastname"] = $tag->getPatient()->getLastname();
        $response["response"]["bloodGroup"] = $tag->getPatient()->getBloodGroup();
        $response["response"]["weight"] = $tag->getPatient()->getWeight();
        $response["response"]["sex"] = $tag->getPatient()->getSex();
        $response["response"]["birthday"] = $tag->getPatient()->getBirthday()->format("Y-m-d");
        $response["response"]["size"] = $tag->getPatient()->getSize();
        
        $qb = $this->_em->createQueryBuilder();
        $qb->add('select', 'h')
            ->add('from', 'Application_Model_Hospital_Stay h')
            ->add('where', 'h.patient = ' . $tag->getPatient()->getId() . ' AND h.checkOut is NULL')
            ->add('orderBy', 'h.checkIn DESC');
        $qb->setMaxResults(1);
        $query = $qb->getQuery();
        $currentStay = $query->getResult();
        if($currentStay){
          $response["response"]["stay"]["checkIn"] = $currentStay[0]->getCheckIn()->format("Y-m-d");
          $response["response"]["stay"]["ops"] = $currentStay[0]->getOps();
          $response["response"]["stay"]["icd"] = $currentStay[0]->getIcd();
          $response["response"]["stay"]["isEmergency"] = $currentStay[0]->getIsEmergency() ? "1" : "0";
        }
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

