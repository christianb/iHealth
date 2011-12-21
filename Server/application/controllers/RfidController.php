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
class RfidController extends Zend_Controller_Action{

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

  public function createAction(){

    $createForm = new Application_Form_Rfid_Create();

    if($this->_request->isPost()){
      $formData = $this->_request->getPost();

      if($createForm->isValid($formData)){

        $data["tag"] = $formData["tag"];

        $rfid = new Application_Model_Rfid($data);

        // write back to persistence manager and flush it
        $this->_em->persist($rfid);
        $this->_em->flush();

        $this->_helper->flashMessenger->addMessage('Das RFID-Tag wurde erfolgreich angelegt.');
        $this->_helper->redirector('list', 'rfid');
      }
    }
    $this->view->createForm = $createForm;
  }

  public function editAction(){
    $tagId = $this->getRequest()->getParam('id');
    $tag = $this->_em->getRepository('Application_Model_Rfid')->findOneById($tagId);
    
    $patient = $tag->getPatient();
    $patientId = isset($patient) ? $patient->getId() : null;
    
    $editForm = new Application_Form_Rfid_Edit(array("tagId" => $tagId, "patientId" => $patientId));

    if($this->_request->isPost()){
      $formData = $this->_request->getPost();

      if($editForm->isValid($formData)){
        $tag->setPatient($this->_em->getRepository('Application_Model_Patient')->findOneById($formData["patient"]));

        // write back to persistence manager and flush it
        $this->_em->persist($tag);
        $this->_em->flush();

        $this->_helper->flashMessenger->addMessage('Das RFID-Tag wurde erfolgreich bearbeitet.');
        $this->_helper->redirector('list', 'rfid');
      }
    }
    $this->view->editForm = $editForm;
  }

  public function listAction(){
    $query = $this->_em->createQuery('SELECT f FROM Application_Model_Rfid f');
    $tags = $query->getResult();

    $this->view->listRfidTags = $tags;
  }

  public function deleteAction(){
    $tagId = $this->_getParam('id');

    if(!empty($tagId)){
      $tagId = preg_replace('/[^0-9]/', '', $tagId);
      $tag = $this->_em->getRepository('Application_Model_Rfid')->findOneById($tagId);
      if($tag){
        $this->_em->remove($tag);
        $this->_em->flush();
      }else{
        $this->_helper->flashMessenger->addMessage('Kein RFID-Tag mit dieser Id gefunden.');
      }
    }

    $this->_helper->redirector('list', 'rfid');

    // disable view
    $this->view->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender(true);
  }

  public function clearAction(){
    $tagId = $this->_getParam('id');

    if(!empty($tagId)){
      $tagId = preg_replace('/[^0-9]/', '', $tagId);
      $rfid = $this->_em->getRepository('Application_Model_Rfid')->findOneById($tagId);
      if($rfid){
        $rfid->setPatient(null);
        $this->_em->persist($rfid);
        $this->_em->flush();
      }else{
        $this->_helper->flashMessenger->addMessage('Kein RFID-Tag mit dieser Id gefunden.');
      }
    }

    $this->_helper->redirector('list', 'rfid');

    // disable view
    $this->view->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender(true);
  }

}

?>
