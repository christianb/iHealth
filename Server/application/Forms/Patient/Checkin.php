<?php

class Application_Form_Patient_Checkin extends Zend_Form{

  /**
   * Creates the form to create a new case.
   * @see Zend_Form::init()
   */
  public function init(){
    $em = Zend_Registry::getInstance()->entitymanager;
    $this->setMethod('post');
    $this->setAction("/patient/checkin/id/" . $this->getAttrib("patientId"));

    $isEmergencyElement = new Zend_Form_Element_Checkbox('isEmergency');
    $isEmergencyElement->setLabel("Ist Notfall");

    $icdElement = new Zend_Form_Element_Text('icd');
    $icdElement->setLabel("ICD");
    $icdElement->addValidator('regex', false, array('/^[a-z0-9ßöäüâáàéèñ]/i'));
    $icdElement->addValidator('stringLength', false, array(2, 64));
    $icdElement->setRequired(true);

    $opsElement = new Zend_Form_Element_Text('ops');
    $opsElement->setLabel("OPS");
    $opsElement->addValidator('regex', false, array('/^[a-z0-9ßöäüâáàéèñ]/i'));
    $opsElement->addValidator('stringLength', false, array(2, 64));
    $opsElement->setRequired(true);

    $rfidElement = new Zend_Form_Element_Select('rfid');
    $rfidElement->setLabel("RFID-Tag");
    $qb = $em->createQueryBuilder();
    $qb->add('select', 'r')
        ->add('from', 'Application_Model_Rfid r')
        ->add('where', 'r.patient IS NULL');
    $query = $qb->getQuery();
    $rfids = $query->getResult();
    $rfidElement->addMultiOption("", "Bitte wählen");
    foreach($rfids as $rfid){
      $rfidElement->addMultiOption($rfid->getId(), $rfid->getTag());
    }
    $rfidElement->addValidator('regex', false, array('/^[0-9]/i'));
    $rfidElement->setRequired(true);

    $submitElement = new Zend_Form_Element_Submit('submit');
    $submitElement->setLabel('Einchecken');
    $submitElement->setIgnore(true);
    $submitElement->setAttrib('class', 'submit');
    $submitElement->removeDecorator('DtDdWrapper');

    $this->addElements(array(
      $isEmergencyElement,
      $rfidElement,
      $icdElement,
      $opsElement
    ));

    $this->addDisplayGroup(array('isEmergency', 'icd', 'ops', 'reason', 'rfid')
        , 'informationGroup'
        , array('legend'=>'Allgemeine Informationen')
    );

    $this->addElements(array(
      $submitElement
        )
    );
  }

}
?>
   
