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
        
        $this->_helper->flashMessenger->addMessage('Registration done.');
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
      $this->_helper->flashMessenger->addMessage('Verification failed.');
      $this->_helper->redirector('index', 'index');
    }else{
      $user->setState('activated');

      // write back to persistence manage and flush it
      $this->_em->persist($user);
      $this->_em->flush();

      // send verification mail
      Unplagged_Mailer::sendActivationMail($user);

      $this->_helper->flashMessenger->addMessage('Verification finished successfully.');
      $this->_helper->redirector('index', 'index');
    }
  }

  /**
   * Displays a form for editing a user profile.
   */
  public function editAction(){
    $userId = preg_replace('/[^0-9]/', '', $this->getRequest()->getParam('id'));
    // if either the user is not logged in or no valid user id is defined
    if(empty($userId) || !$this->_defaultNamespace->user){
      $this->_helper->redirector('index', 'index');
    }

    $user = $this->_em->getRepository('Application_Model_Personnel')->findOneById($userId);
    if(empty($user)){
      $this->_helper->flashMessenger->addMessage('User Profile saved successfully.');
      $this->_helper->redirector('index', 'index');
    }elseif($this->_defaultNamespace->user->getId() != $userId){
      $this->_helper->flashMessenger->addMessage('No permission to edit other users.');
      $this->_helper->redirector('index', 'index');
    }else{
      // display the form with user data pre-loaded
      $profileForm = new Application_Form_Personnel_Profile($userId);

      // form has been submitted through post request
      if($this->_request->isPost()){
        $formData = $this->_request->getPost();

        // if the form doesn't validate, pass to view and return
        if($profileForm->isValid($formData)){
          // select the user and update the values
          $user->setFirstname($this->getRequest()->getParam('firstname'));
          $user->setLastname($this->getRequest()->getParam('lastname'));

          // write back to persistence manage and flush it
          $this->_em->persist($user);
          $this->_em->flush();

          $this->_helper->flashMessenger->addMessage('User Profile saved successfully.');
          $this->_helper->redirector('index', 'index');
        }
      }

      // send form to view
      $this->view->profileForm = $profileForm;
    }
  }

}
