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
class PersonnelController extends Zend_Controller_Action{

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
    $query = $this->_em->createQuery('SELECT f FROM Application_Model_Personnel f');
    $personnel = $query->getResult();

    $this->view->listPersonnel = $personnel;
  }

  /**
   * Displays a form for registering a user.
   */
  public function registerAction(){
    // create the form
    $registerForm = new Application_Form_Personnel_Register();

    // form has been submitted through post request
    if($this->_request->isPost()){
      $formData = $this->_request->getPost();

      // if the form doesn't validate, pass to view and return
      if($registerForm->isValid($formData)){
        // create new user object
        $data = array();
        $data["username"] = $this->getRequest()->getParam('username');
        $data["password"] = Unplagged_Helper::hashString($this->getRequest()->getParam('password'));
        $data["email"] = $this->getRequest()->getParam('email');
        $data["verificationHash"] = Unplagged_Helper::generateRandomHash();
        $data["state"] = 'registered';
        $user = new Application_Model_Personnel($data);

        // write back to persistence manager and flush it
        $this->_em->persist($user);
        $this->_em->flush();

        // send registration mail
        Unplagged_Mailer::sendRegistrationMail($user);

        $this->_helper->flashMessenger->addMessage('Die Registrierung wurde erfolgreich abgeschlossen.');
        $this->_helper->redirector('index', 'index');
      }
    }

    // send form to view
    $this->view->registerForm = $registerForm;
  }

  /**
   * Verifies a user by a given hash in database.
   */
  public function verifyAction(){

    $verificationHash = preg_replace('/[^0-9a-z]/i', '', $this->getRequest()->getParam('hash'));

    // if no valid verification hash is set
    if(empty($verificationHash)){
      $this->_helper->redirector('index', 'index');
    }

    $user = $this->_em->getRepository('Application_Model_Personnel')->findOneByVerificationHash($verificationHash);
    if(empty($user) || $user->getState() != 'registered'){
      $this->_helper->flashMessenger->addMessage('Die Verifizierung ist fehlgeschlagen.');
      $this->_helper->redirector('index', 'index');
    }else{
      $user->setState('activated');

      // write back to persistence manage and flush it
      $this->_em->persist($user);
      $this->_em->flush();

      // send verification mail
      Unplagged_Mailer::sendActivationMail($user);

      $this->_helper->flashMessenger->addMessage('Die Verifizierung wurde erfolgreich abgeschlossen.');
      $this->_helper->redirector('index', 'index');
    }
  }

  /**
   * Displays a form for editing a user profile.
   */
  public function editAction(){
    $personnelId = preg_replace('/[^0-9]/', '', $this->getRequest()->getParam('id'));

    // if either the user is not logged in or no valid user id is defined
    if(empty($personnelId) || !$this->_defaultNamespace->user->hasRight(CRUD_PERSONNEL)){
      $this->_helper->redirector('index', 'index');
    }

    $personnel = $this->_em->getRepository('Application_Model_Personnel')->findOneById($personnelId);
    if(empty($personnel)){
      $this->_helper->flashMessenger->addMessage('Kein Benutzer mit dieser Id gefunden.');
      $this->_helper->redirector('index', 'index');
    }else{
      // display the form with user data pre-loaded
      $editForm = new Application_Form_Personnel_Modify();
      $editForm->setAction("/personnel/edit/id/" . $personnelId);

      $editForm->getElement("email")->setValue($personnel->getEmail());
      $editForm->getElement("username")->setValue($personnel->getUsername());
      $editForm->getElement("firstname")->setValue($personnel->getFirstname());
      $editForm->getElement("lastname")->setValue($personnel->getLastname());

      $editForm->getElement("academicTitle")->setValue($personnel->getAcademicTitle());
      if($personnel->getDegreeDate()){
        $editForm->getElement("degreeDate")->setValue($personnel->getDegreeDate()->format("Y-m-d"));
      }
      if($personnel->getPosition()){
        $editForm->getElement("position")->setValue($personnel->getPosition()->getId());
      }
      if($personnel->getLayedIn()){
        $editForm->getElement("layedIn")->setValue($personnel->getLayedIn()->format("Y-m-d"));
      }
      if($personnel->getLayedOut()){
        $editForm->getElement("layedOut")->setValue($personnel->getLayedOut()->format("Y-m-d"));
      }
      $editForm->getElement("measurementsRight")->setValue($personnel->hasRight(CRUD_MEASUREMENTS));
      $editForm->getElement("hospitalsRight")->setValue($personnel->hasRight(CRUD_HOSPITALS));
      $editForm->getElement("personnelRight")->setValue($personnel->hasRight(CRUD_PERSONNEL));
      $editForm->getElement("patientsRight")->setValue($personnel->hasRight(CRUD_PATIENTS));
      $editForm->getElement("rfidsRight")->setValue($personnel->hasRight(CRUD_RFID));

      // form has been submitted through post request
      if($this->_request->isPost()){
        $formData = $this->_request->getPost();

        // if the form doesn't validate, pass to view and return
        if($editForm->isValid($formData)){

          //  echo $this->_defaultNamespace->user->setRight(CRUD_MEASUREMENTS);
          // select the user and update the values
          $personnel->setFirstname($formData['firstname']);
          $personnel->setLastname($formData['lastname']);
          $personnel->setAcademicTitle($formData['academicTitle']);
          if($formData['degreeDate']){
            $personnel->setDegreeDate(DateTime::createFromFormat("Y-m-d", $formData['degreeDate']));
          }
          $position = $this->_em->getRepository('Application_Model_Personnel_Position')->findOneById($formData['position']);
          $personnel->setPosition($position);
          if($formData['layedIn']){
            $personnel->setLayedIn(DateTime::createFromFormat("Y-m-d", $formData['layedIn']));
          }
          if($formData['layedOut']){
            $personnel->setLayedOut(DateTime::createFromFormat("Y-m-d", $formData['layedOut']));
          }

          $formData['measurementsRight'] == 1 ? $personnel->setRight(CRUD_MEASUREMENTS) : $personnel->unsetRight(CRUD_MEASUREMENTS);
          $formData['hospitalsRight'] == 1 ? $personnel->setRight(CRUD_HOSPITALS) : $personnel->unsetRight(CRUD_HOSPITALS);
          $formData['personnelRight'] == 1 ? $personnel->setRight(CRUD_PERSONNEL) : $personnel->unsetRight(CRUD_PERSONNEL);
          $formData['patientsRight'] == 1 ? $personnel->setRight(CRUD_PATIENTS) : $personnel->unsetRight(CRUD_PATIENTS);
          $formData['rfidsRight'] == 1 ? $personnel->setRight(CRUD_RFID) : $personnel->unsetRight(CRUD_RFID);


          // write back to persistence manage and flush it
          $this->_em->persist($personnel);
          $this->_em->flush();

          $this->_helper->flashMessenger->addMessage('Der Benutzer wurde erfolgreich gespeichert.');
          $this->_helper->redirector('list', 'personnel');
        }
      }

      // send form to view
      $this->view->editForm = $editForm;
    }
  }

  /**
   * Displays a form for editing a user profile.
   */
  public function updateProfileAction(){
    $personnelId = $this->_defaultNamespace->user->getId();
    // if either the user is not logged in or no valid user id is defined
    if(empty($personnelId)){
      $this->_helper->redirector('index', 'index');
    }

    $personnel = $this->_em->getRepository('Application_Model_Personnel')->findOneById($personnelId);
    if(empty($personnel)){
      $this->_helper->flashMessenger->addMessage('Ihr Profile wurde erfolgreich gespeichert.');
      $this->_helper->redirector('index', 'index');
    }elseif($this->_defaultNamespace->user->getId() != $personnelId){
      $this->_helper->flashMessenger->addMessage('Dazu fehlt Ihnen die Berechtigung.');
      $this->_helper->redirector('index', 'index');
    }else{
      // display the form with user data pre-loaded
      $profileForm = new Application_Form_Personnel_Profile();
      $profileForm->setAction("/personnel/update-profile/id/" . $personnelId);

      $profileForm->getElement("email")->setValue($personnel->getEmail());
      $profileForm->getElement("username")->setValue($personnel->getUsername());
      $profileForm->getElement("firstname")->setValue($personnel->getFirstname());
      $profileForm->getElement("lastname")->setValue($personnel->getLastname());

      // form has been submitted through post request
      if($this->_request->isPost()){
        $formData = $this->_request->getPost();

        // if the form doesn't validate, pass to view and return
        if($profileForm->isValid($formData)){
          // select the user and update the values
          $personnel->setFirstname($formData['firstname']);
          $personnel->setLastname($formData['lastname']);

          // write back to persistence manage and flush it
          $this->_em->persist($personnel);
          $this->_em->flush();

          $this->_helper->flashMessenger->addMessage('Ihr Profil wurde erfolgreich gespeichert.');
          $this->_helper->redirector('index', 'index');
        }
      }

      // send form to view
      $this->view->profileForm = $profileForm;
    }
  }

}
