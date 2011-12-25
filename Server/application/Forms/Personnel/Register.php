<?php

/*
 * Form for user registration.
 */

/**
 * The form class generates a form for registering a new user.
 *
 * @author Benjamin Oertel <mail@benjaminoertel.com>
 * @version 1.0
 */
class Application_Form_Personnel_Register extends Zend_Form{

  /**
   * Creates the form to register a new user.
   * @see Zend_Form::init()
   */
  public function init(){
    $this->setMethod('post');
    $this->setAction("/personnel/register/");

    $emailElement = new Zend_Form_Element_Text('email');
    $emailElement->setLabel("E-Mail");
    $emailElement->addValidator('regex', false, array('/^[a-z0-9ßöäüâáàéèñ]/i'));
    $emailElement->addValidator('stringLength', false, array(2, 64));
    $emailElement->addValidator('EmailAddress', true);
    $emailElement->addValidator(new Unplagged_Validate_NoRecordExists('Application_Model_Personnel','email'));
    $emailElement->setAttrib('maxLength', 64);
    $emailElement->setRequired(true);

    $usernameElement = new Zend_Form_Element_Text('username');
    $usernameElement->setLabel("Benutzername");
    $usernameElement->addValidator('regex', false, array('/^[a-z0-9ßöäüâáàéèñ]/i'));
    $usernameElement->addValidator('stringLength', false, array(2, 64));
    $usernameElement->addValidator(new Unplagged_Validate_NoRecordExists('Application_Model_Personnel','username'));
    $usernameElement->setAttrib('maxLength', 64);
    $usernameElement->setRequired(true);

    $passwordElement = new Zend_Form_Element_Password('password');
    $passwordElement->setLabel("Passwort");
    $passwordElement->addValidator('regex', false, array('/^[a-z0-9ßöäüâáàéèñ]/i'));
    $passwordElement->addValidator('stringLength', false, array(8, 32));
    $passwordElement->setAttrib('maxLength', 32);
    $passwordElement->setRequired(true);
    
    $reenterPasswordElement = new Zend_Form_Element_Password('confirmedPassword');
    $reenterPasswordElement->setLabel("Passwort erneut eingeben");
    $reenterPasswordElement->setAttrib('maxLength', 32);
    $reenterPasswordElement->addValidator('Identical', false, array('token' => 'password'));
    $reenterPasswordElement->setRequired(true);


    $submitElement = new Zend_Form_Element_Submit('submit');
    $submitElement->setLabel('Registrieren');
    $submitElement->setIgnore(true);
    $submitElement->setAttrib('class', 'submit');
    $submitElement->removeDecorator('DtDdWrapper');

    $this->addElements(array(
      $emailElement
      ,$usernameElement
      ,$passwordElement
      ,$reenterPasswordElement
    ));

    $this->addDisplayGroup(array(
       'username'
      ,'email'
      , 'password'
      ,'confirmedPassword'
        )
        , 'credentialGroup'
        , array('legend'=>'Zugangsdaten')
    );

    $this->addElements(array(
      $submitElement
    ));
  }

}

