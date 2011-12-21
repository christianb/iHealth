<?php

class Application_Form_Rfid_Create extends Zend_Form{

  /**
   * Creates the form to create a new case.
   * @see Zend_Form::init()
   */
  public function init(){
    $this->setMethod('post');
    $this->setAction("/rfid/create");

    $tagElement = new Zend_Form_Element_Text('tag');
    $tagElement->setLabel("Tag");
    $tagElement->addValidator('regex', false, array('/^[a-z0-9ßöäüâáàéèñ]/i'));
    $tagElement->addValidator('stringLength', false, array(2, 64));
    $tagElement->setRequired(true);

    $submitElement = new Zend_Form_Element_Submit('submit');
    $submitElement->setLabel('Anlegen');
    $submitElement->setIgnore(true);
    $submitElement->setAttrib('class', 'submit');
    $submitElement->removeDecorator('DtDdWrapper');

    $this->addElements(array(
      $tagElement
    ));

    $this->addDisplayGroup(array('tag')
        , 'informationGroup'
        , array('legend'=>'Tag Informationen')
    );

    $this->addElements(array(
      $submitElement
        )
    );
  }

}

?>