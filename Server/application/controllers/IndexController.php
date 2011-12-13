<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_em = Zend_Registry::getInstance()->entitymanager;
        $this->_defaultNamespace = new Zend_Session_Namespace('Default');
        $this->view->flashMessages = $this->_helper->flashMessenger->getMessages();
    }
    public function indexAction()
    {
        // action body
    }


}

