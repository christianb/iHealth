<?php

class Application_Form_Patient_Modify extends Zend_Form{

  /**
   * Creates the form to create a new case.
   * @see Zend_Form::init()
   */
  public function init(){
    $em = Zend_Registry::getInstance()->entitymanager;
    $this->setMethod('post');

    $firstnameElement = new Zend_Form_Element_Text('firstname');
    $firstnameElement->setLabel("Vorname");
    $firstnameElement->addValidator('regex', false, array('/^[a-z0-9ßöäüâáàéèñ]/i'));
    $firstnameElement->addValidator('stringLength', false, array(2, 64));
    $firstnameElement->setRequired(true);
    
    $lastnameElement = new Zend_Form_Element_Text('lastname');
    $lastnameElement->setLabel("Nachname");
    $lastnameElement->addValidator('regex', false, array('/^[a-z0-9ßöäüâáàéèñ]/i'));
    $lastnameElement->addValidator('stringLength', false, array(2, 64));
    $lastnameElement->setRequired(true);
    
    $sizeElement = new Zend_Form_Element_Text('size');
    $sizeElement->setLabel("Körpergröße in cm");
    $sizeElement->addValidator('regex', false, array('/^[a-z0-9ßöäüâáàéèñ]/i'));
    $sizeElement->addValidator('stringLength', false, array(2, 64));
    
    $weightElement = new Zend_Form_Element_Text('weight');
    $weightElement->setLabel("Gewicht in kg");
    $weightElement->addValidator('regex', false, array('/^[a-z0-9ßöäüâáàéèñ]/i'));
    $weightElement->addValidator('stringLength', false, array(2, 64));
    
    $bloodGroupElement = new Zend_Form_Element_Text('bloodGroup');
    $bloodGroupElement->setLabel("Blutgruppe");
    $bloodGroupElement->addValidator('regex', false, array('/^[a-z0-9ßöäüâáàéèñ]/i'));
    $bloodGroupElement->addValidator('stringLength', false, array(2, 64));
    
    $streetElement = new Zend_Form_Element_Text('street');
    $streetElement->setLabel("Straße");
    $streetElement->addValidator('regex', false, array('/^[a-z0-9ßöäüâáàéèñ]/i'));
    $streetElement->addValidator('stringLength', false, array(2, 64));
    
    $zipcodeElement = new Zend_Form_Element_Text('zipcode');
    $zipcodeElement->setLabel("Postleitzahl");
    $zipcodeElement->addValidator('regex', false, array('/^[a-z0-9ßöäüâáàéèñ]/i'));
    $zipcodeElement->addValidator('stringLength', false, array(2, 64));
    
    $cityElement = new Zend_Form_Element_Text('city');
    $cityElement->setLabel("Stadt");
    $cityElement->addValidator('regex', false, array('/^[a-z0-9ßöäüâáàéèñ]/i'));
    $cityElement->addValidator('stringLength', false, array(2, 64));
    
    
    $submitElement = new Zend_Form_Element_Submit('submit');
    $submitElement->setLabel('Speichern');
    $submitElement->setIgnore(true);
    $submitElement->setAttrib('class', 'submit');
    $submitElement->removeDecorator('DtDdWrapper');

    $this->addElements(array(
      $firstnameElement,
      $lastnameElement,
      $sizeElement,
      $weightElement,
      $bloodGroupElement,
      $streetElement,
      $zipcodeElement,
      $cityElement
    ));

    $this->addDisplayGroup(array('firstname', 'lastname')
      , 'informationGroup'
      , array('legend'=>'Allgemeine Informationen')
    );

    $this->addDisplayGroup(array('size', 'weight', 'bloodGroup')
      , 'vitalGroup'
      , array('legend'=>'Vital Informationen')
    );
        
    $this->addDisplayGroup(array('street', 'zipcode', 'city')
      , 'addressGroup'
      , array('legend'=>'Adresse')
    );
    
    $this->addElements(array(
      $submitElement
      )
        );
  }

}

?>