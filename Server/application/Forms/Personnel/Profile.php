<?php

/*
 * Form for user profile update.
 */

/**
 * The form class generates a form for editing a user profile and upgrading rights.
 *
 * @author Benjamin Oertel <mail@benjaminoertel.com>
 * @version 1.0
 */
class Application_Form_Personnel_Profile extends Zend_Form{

  /**
   * Initializes the form.
   * @param integer $userId The id of an user whos data is loaded to the form.
   */
  public function __construct(){
    parent::__construct();
  }

  /**
   * Creates the form to edit a user profile.
   * @see Zend_Form::init()
   */
  public function init(){
    $em = Zend_Registry::getInstance()->entitymanager;
    $defaultNamespace = new Zend_Session_Namespace('Default');

    $this->setMethod('post');

    $usernameElement = new Zend_Form_Element_Text('username');
    $usernameElement->setLabel("Benutzername");
    $usernameElement->setIgnore(true);

    $emailElement = new Zend_Form_Element_Text('email');
    $emailElement->setLabel("E-Mail");
    $emailElement->setIgnore(true);

    $firstnameElement = new Zend_Form_Element_Text('firstname');
    $firstnameElement->setLabel("Vorname");
    $firstnameElement->addValidator('stringLength', false, array(2, 64));
    $firstnameElement->setAttrib('maxLength', 64);
    $firstnameElement->setRequired(true);

    $lastnameElement = new Zend_Form_Element_Text('lastname');
    $lastnameElement->setLabel("Nachname");
    $lastnameElement->addValidator('stringLength', false, array(2, 64));
    $lastnameElement->setAttrib('maxLength', 64);
    $lastnameElement->setRequired(true);

    $submitElement = new Zend_Form_Element_Submit('submit');
    $submitElement->setLabel('Speichern');
    $submitElement->setIgnore(true);
    $submitElement->setAttrib('class', 'submit');
    $submitElement->removeDecorator('DtDdWrapper');

    $this->addElements(array(
      $emailElement
      , $usernameElement
      , $firstnameElement
      , $lastnameElement
    ));

    $this->addDisplayGroup(array(
      'email'
      , 'username'
      , 'firstname'
      , 'lastname'
        )
        , 'personalGoup'
        , array('legend'=>'Persönliche Informationen')
    );

    $this->addElements(array(
      $submitElement
    ));
  }

}

