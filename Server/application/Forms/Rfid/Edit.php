<?php

class Application_Form_Rfid_Edit extends Zend_Form{

  /**
   * Creates the form to create a new case.
   * @see Zend_Form::init()
   */
  public function init(){
    $em = Zend_Registry::getInstance()->entitymanager;
    $this->setMethod('post');
    $this->setAction("/rfid/edit/id/".$this->getAttrib("tagId"));
    
    $patientElement = new Zend_Form_Element_Select('patient');
    $patientElement->setLabel("Patient");
    $query = $em->createQuery('SELECT f FROM Application_Model_Patient f');
    $patients = $query->getResult();
    $patientElement->addMultiOption("", "Bitte wählen");
    foreach($patients as $patient) {
      $patientElement->addMultiOption($patient->getId(), $patient->getName());
    }
    $patientElement->addValidator('regex', false, array('/^[0-9]/i'));
    $patientElement->setRequired(true);
    $patientElement->setValue($this->getAttrib("patientId"));

    $submitElement = new Zend_Form_Element_Submit('submit');
    $submitElement->setLabel('Create');
    $submitElement->setIgnore(true);
    $submitElement->setAttrib('class', 'submit');
    $submitElement->removeDecorator('DtDdWrapper');

    $this->addElements(array(
      $patientElement
    ));

    $this->addDisplayGroup(array('patient')
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