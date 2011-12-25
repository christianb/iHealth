<?php

/*
 * Controller for user management.
 */

/**
 * The controller class handles all the user transactions as rights requests and user management.
 *
 * @author Benjamin Oertel <mail@benjaminoertel.com>
 * @version 1.0
 */
class HospitalStayController extends Zend_Controller_Action{

  /**
   * Initalizes registry and namespace instance in the controller and allows to display flash messages in the view.
   * @see Zend_Controller_Action::init()
   */
  public function init(){
    $this->_em = Zend_Registry::getInstance()->entitymanager;
    $this->_defaultNamespace = new Zend_Session_Namespace('Default');
    $this->view->flashMessages = $this->_helper->flashMessenger->getMessages();
  }

  public function chartAction(){
    
  }

  public function listAction(){
    $patientId = $this->_getParam('id');

    if(!empty($patientId)){
      $patientId = preg_replace('/[^0-9]/', '', $patientId);
      $patient = $this->_em->getRepository('Application_Model_Patient')->findOneById($patientId);
      if($patient){
        $this->view->patient = $patient;
      }else{
        $this->_helper->flashMessenger->addMessage('Kein Patient gefunden.');
      }
      $qb = $this->_em->createQueryBuilder();
      $qb->add('select', 'h')
          ->add('from', 'Application_Model_Hospital_Stay h')
          ->add('where', 'h.patient = ' . $patientId)
          ->add('orderBy', 'h.checkOut DESC');
      $query = $qb->getQuery();
      $hospitalStays = $query->getResult();
      $this->view->listHospitalStays = $hospitalStays;
      $this->view->patient = $patient;
    }
  }

}
?>
