<?php

/**
 * The controller class handles all the login and logout behaviour.
 *
 * @author Benjamin Oertel <benjamin.oertel@student.htw-berlin.de>
 * @version 1.0
 */
class AuthController extends Zend_Controller_Action{

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
    $auth = Zend_Auth::getInstance();
    if($auth->hasIdentity()){
      $this->_helper->redirector('index', 'index');
    }

    $this->_forward("login");
  }

  public function loginAction(){

    $auth = Zend_Auth::getInstance();
    if($auth->hasIdentity()){
      $this->_helper->redirector('index', 'index');
    }

    $loginForm = new Application_Form_Auth_Login();
    $request = $this->getRequest();
    if($request->isPost()){
      $formData = $this->_request->getPost();

      if($loginForm->isValid($formData)){
        $username = $this->getRequest()->getParam('username');
        $password = Unplagged_Helper::hashString($this->getRequest()->getParam("password"));

        $adapter = new Unplagged_Auth_Adapter_Doctrine($this->_em, "Application_Model_Personnel", "username", "password", $username, $password);
        $result = $auth->authenticate($adapter);

        if($result->isValid()){
          $defaultNamespace = new Zend_Session_Namespace('Default');
          $defaultNamespace->user = $result->getIdentity();
          ;

          $this->_helper->flashMessenger->addMessage('Sie wurden erfolgreich am System angemeldet.');
          $this->_helper->redirector('index', 'index');
        }else{
          $this->_helper->flashMessenger->addMessage('Das Login ist fehlgeschlagen.');
          $this->_helper->redirector('login', 'auth');
        }
      }
    }

    $this->view->loginForm = $loginForm;
  }

  /**
   * Logs the user off. The identity is removed and the session is cleared.
   */
  public function logoutAction(){
    Zend_Auth::getInstance()->clearIdentity();
    Zend_Session::forgetMe();
    unset($this->_defaultNamespace->user);

    $this->_helper->flashMessenger->addMessage('Sie wurden erfolgreich vom System abgemeldet.');
    $this->_helper->redirector('index', 'index');
  }

}