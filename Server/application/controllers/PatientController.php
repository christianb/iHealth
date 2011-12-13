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
class PatientController extends Zend_Controller_Action{

  /**
   * Initalizes registry and namespace instance in the controller and allows to display flash messages in the view.
   * @see Zend_Controller_Action::init()
   */
  public function init(){
    $this->_em = Zend_Registry::getInstance()->entitymanager;
    $this->_defaultNamespace = new Zend_Session_Namespace('Default');
    $this->view->flashMessages = $this->_helper->flashMessenger->getMessages();
  }

  public function indexAction(){
    
  }
  
    public function listAction(){
    $query = $this->_em->createQuery('SELECT f FROM Application_Model_Patient f');
    $patients = $query->getResult();

    $this->view->listPatients = $patients;
 
  }
}
?>
