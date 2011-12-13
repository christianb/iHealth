<?php

class Application_Form_Rfid_Create extends Zend_Form{

  /**
   * Creates the form to create a new case.
   * @see Zend_Form::init()
   */
  public function init(){
    $em = Zend_Registry::getInstance()->entitymanager;
    $this->setMethod('post');
    $this->setAction("/rfid/create");

    $tagElement = new Zend_Form_Element_Text('tag');
    $tagElement->setLabel("Tag");
    $tagElement->addValidator('regex', false, array('/^[a-z0-9ßöäüâáàéèñ]/i'));
    $tagElement->addValidator('stringLength', false, array(2, 64));
    $tagElement->setRequired(true);
    
    $patientElement = new Zend_Form_Element_Select('patient');
    $patientElement->setLabel("Patient");
    $query = $em->createQuery('SELECT f FROM Application_Model_Patient f');
    $patients = $query->getResult();
    foreach($patients as $patient) {
      $patientElement->addMultiOption($patient->getId(), $patient->getName());
    }
    $patientElement->addValidator('regex', false, array('/^[0-9]/i'));
    $patientElement->setRequired(true);   

    $submitElement = new Zend_Form_Element_Submit('submit');
    $submitElement->setLabel('Create');
    $submitElement->setIgnore(true);
    $submitElement->setAttrib('class', 'submit');
    $submitElement->removeDecorator('DtDdWrapper');

    $this->addElements(array(
      $tagElement,
      $patientElement
    ));

    $this->addDisplayGroup(array('tag', 'patient')
      , 'informationGroup'
      , array('legend'=>'Tag Information')
    );

    $this->addElements(array(
      $submitElement
      )
        );
  }

}

?>