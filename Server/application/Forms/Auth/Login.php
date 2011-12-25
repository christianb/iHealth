<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Form_Auth_Login extends Zend_Form{

  /**
   * Creates the form to log in.
   * @see Zend_Form::init()
   */
  public function init(){

    $this->setMethod('post');
    $this->setAction("/auth/login/");

    $usernameElement = new Zend_Form_Element_Text('username');
    $usernameElement->setLabel("Benutzername");
    $usernameElement->addValidator('regex', false, array('/^[a-z0-9]/i'));
    $usernameElement->addValidator('stringLength', false, array(2, 64));
    $usernameElement->setAttrib('maxLength', 64);
    $usernameElement->setRequired(true);

    $passwordElement = new Zend_Form_Element_Password('password');
    $passwordElement->setLabel("Passwort");
    $passwordElement->addValidator('regex', false, array('/^[a-z0-9]/i'));
    $passwordElement->addValidator('stringLength', false, array(8, 32));
    $passwordElement->setAttrib('maxLength', 32);
    $passwordElement->setRequired(true);

    $submitElement = new Zend_Form_Element_Submit('submit');
    $submitElement->setLabel('Anmelden');
    $submitElement->setIgnore(true);
    $submitElement->setAttrib('class', 'submit');
    $submitElement->removeDecorator('DtDdWrapper');

    $this->addElements(array(
      $usernameElement
      , $passwordElement
    ));

    $this->addDisplayGroup(array(
      'username'
      , 'password'
        )
        , 'credentialGroup'
        , array('legend'=>'Zugangsdaten')
    );

    $this->addElements(array(
      $submitElement
    ));
  }

}

?>
