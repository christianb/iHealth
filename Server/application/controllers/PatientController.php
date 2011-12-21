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

  public function createAction(){
    $createForm = new Application_Form_Patient_Modify();
    $createForm->setAction("/patient/create");

    if($this->_request->isPost()){
      $formData = $this->_request->getPost();

      if($createForm->isValid($formData)){
        $data["firstname"] = $formData["firstname"];
        $data["lastname"] = $formData["lastname"];

        $data["street"] = $formData["street"];
        $data["city"] = $formData["city"];
        $data["zipcode"] = $formData["zipcode"];

        $data["weight"] = $formData["weight"];
        $data["size"] = $formData["size"];
        $data["bloodGroup"] = $formData["bloodGroup"];

        $patient = new Application_Model_Patient($data);

        // write back to persistence manager and flush it
        $this->_em->persist($patient);
        $this->_em->flush();

        $this->_helper->flashMessenger->addMessage('Der Patient wurde erfolgreich angelegt.');
        $this->_helper->redirector('list', 'patient');
      }
    }
    $this->view->createForm = $createForm;
  }

  public function editAction(){
    $patientId = $this->getRequest()->getParam('id');
    $patient = $this->_em->getRepository('Application_Model_Patient')->findOneById($patientId);

    $editForm = new Application_Form_Patient_Modify();
    $editForm->setAction("/patient/edit/id/" . $patientId);

    $editForm->getElement("firstname")->setValue($patient->getFirstname());
    $editForm->getElement("lastname")->setValue($patient->getLastname());

    $editForm->getElement("size")->setValue($patient->getSize());
    $editForm->getElement("weight")->setValue($patient->getWeight());
    $editForm->getElement("bloodGroup")->setValue($patient->getBloodGroup());

    $editForm->getElement("street")->setValue($patient->getStreet());
    $editForm->getElement("zipcode")->setValue($patient->getZipcode());
    $editForm->getElement("city")->setValue($patient->getCity());

    if($this->_request->isPost()){
      $formData = $this->_request->getPost();

      if($editForm->isValid($formData)){
        $patient->setFirstname($formData["firstname"]);
        $patient->setLastname($formData["lastname"]);

        $patient->setSize($formData["size"]);
        $patient->setWeight($formData["weight"]);
        $patient->setBloodGroup($formData["bloodGroup"]);

        $patient->setStreet($formData["street"]);
        $patient->setZipcode($formData["zipcode"]);
        $patient->setCity($formData["city"]);

        // write back to persistence manager and flush it
        $this->_em->persist($patient);
        $this->_em->flush();

        $this->_helper->flashMessenger->addMessage('Der Patient wurde erfolgreich gespeichert.');
        $this->_helper->redirector('list', 'patient');
      }
    }

    $this->view->editForm = $editForm;
    $this->view->patient = $patient;
  }

  public function checkinAction(){
    $patientId = $this->getRequest()->getParam('id');
    $patient = $this->_em->getRepository('Application_Model_Patient')->findOneById($patientId);
    $hospital = $this->_em->getRepository('Application_Model_Hospital')->findOneById(1);

    $checkinForm = new Application_Form_Patient_Checkin(array("patientId"=>$patientId));

    if($this->_request->isPost()){
      $formData = $this->_request->getPost();

      if($checkinForm->isValid($formData)){
        $rfid = $this->_em->getRepository('Application_Model_Rfid')->findOneById($formData["rfid"]);
        $rfid->setPatient($patient);

        $data["patient"] = $patient;
        $data["isEmergency"] = $formData["isEmergency"];
        $data["icd"] = $formData["icd"];
        $data["ops"] = $formData["ops"];
        $data["hospital"] = $hospital;

        $hospitalStay = new Application_Model_Hospital_Stay($data);

        // write back to persistence manager and flush it
        $this->_em->persist($hospitalStay);
        $this->_em->persist($patient);
        $this->_em->flush();

        $this->_helper->flashMessenger->addMessage('Der Patient wurde erfolgreich eingecheckt.');
        $this->_helper->redirector('list', 'patient');
      }
    }
    $this->view->checkinForm = $checkinForm;
    $this->view->patient = $patient;
  }

  public function checkoutAction(){
    $patientId = $this->_getParam('id');

    if(!empty($patientId)){
      $qb = $this->_em->createQueryBuilder();
      $qb->add('select', 'r')
          ->add('from', 'Application_Model_Hospital_Stay r')
          ->add('where', 'r.checkOut IS NULL AND r.patient = ' . $patientId);
      $query = $qb->getQuery();
      $hospitalStay = $query->getSingleResult();
      $hospitalStay->checkOut();
      if($hospitalStay){
        $tag = $this->_em->getRepository("Application_Model_Rfid")->findOneBy(array("patient"=>$patientId));
        if($tag){
          $tag->setPatient(null);
          $this->_em->persist($tag);
        }
        $this->_em->persist($hospitalStay);


        $this->_em->flush();
      }else{
        $this->_helper->flashMessenger->addMessage('Kein Krankenhausaufenthalt gefunden.');
      }
    }

    $this->_helper->redirector('list', 'patient');

    // disable view
    $this->view->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender(true);
  }

  public function listAction(){
    $query = $this->_em->createQuery('SELECT f FROM Application_Model_Patient f');
    $patients = $query->getResult();

    $this->view->listPatients = $patients;
  }

  public function overviewAction(){
    $patientId = $this->_getParam('id');

    if(!empty($patientId)){
      $patientId = preg_replace('/[^0-9]/', '', $patientId);
      $patient = $this->_em->getRepository('Application_Model_Patient')->findOneById($patientId);
      if($patient){
        $this->view->patient = $patient;

        $qb = $this->_em->createQueryBuilder();
        $qb->add('select', 'h')
            ->add('from', 'Application_Model_Hospital_Stay h')
            ->add('where', 'h.patient = ' . $patientId)
            ->add('orderBy', 'h.checkIn DESC');
        $qb->setMaxResults(1);
        $query = $qb->getQuery();
        $currentStay = $query->getResult();
        if($currentStay){
          $this->view->currentStay = $currentStay[0];
        }
      }else{
        $this->_helper->flashMessenger->addMessage('Kein Patient gefunden.');
      }
    }
    $this->view->personnel = $this->_defaultNamespace->user;
  }

  public function deleteAction(){
    $patientId = $this->_getParam('id');

    if(!empty($patientId)){
      $patientId = preg_replace('/[^0-9]/', '', $patientId);
      $patient = $this->_em->getRepository('Application_Model_Patient')->findOneById($patientId);
      if($patient){
        $this->_em->remove($patient);
        $this->_em->flush();
      }else{
        $this->_helper->flashMessenger->addMessage('Kein Patient gefunden.');
      }
    }

    $this->_helper->redirector('list', 'patient');

    // disable view
    $this->view->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender(true);
  }

}

?>
