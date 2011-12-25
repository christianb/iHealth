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
class Application_Form_Personnel_Modify extends Zend_Form{

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

    $lastnameElement = new Zend_Form_Element_Text('lastname');
    $lastnameElement->setLabel("Nachname");
    $lastnameElement->addValidator('stringLength', false, array(2, 64));
    $lastnameElement->setAttrib('maxLength', 64);

    // professional group elements
    $academicTitleElement = new Zend_Form_Element_Text('academicTitle');
    $academicTitleElement->setLabel("Akademischer Titel");
    $academicTitleElement->addValidator('stringLength', false, array(2, 64));
    $academicTitleElement->setAttrib('maxLength', 64);

    $positionElement = new Zend_Form_Element_Select('position');
    $positionElement->setLabel("Position");
    $qb = $em->createQueryBuilder();
    $qb->add('select', 'p')
        ->add('from', 'Application_Model_Personnel_Position p');
    $query = $qb->getQuery();
    $positions = $query->getResult();
    $positionElement->addMultiOption("", "Bitte wählen");
    foreach($positions as $position){
      $positionElement->addMultiOption($position->getId(), $position->getTitle());
    }
    $positionElement->addValidator('regex', false, array('/^[0-9]/i'));
    $positionElement->setRequired(true);

    $degreeDateElement = new Zend_Form_Element_Text('degreeDate');
    $degreeDateElement->setLabel("Abschluss am");
    $degreeDateElement->addValidator(new Zend_Validate_Date());

    $layedInElement = new Zend_Form_Element_Text('layedIn');
    $layedInElement->setLabel("Angestellt am");
    $layedInElement->addValidator(new Zend_Validate_Date());


    $layedOutElement = new Zend_Form_Element_Text('layedOut');
    $layedOutElement->setLabel("Ausgeschieden am");
    $layedOutElement->addValidator(new Zend_Validate_Date());


    // rights group elements

    $measurementsRightElement = new Zend_Form_Element_Checkbox('measurementsRight');
    $measurementsRightElement->setLabel("Messungsverwaltung");

    $hospitalsRightElement = new Zend_Form_Element_Checkbox('hospitalsRight');
    $hospitalsRightElement->setLabel("Krankenhäuserverwaltung");

    $personnelRightElement = new Zend_Form_Element_Checkbox('personnelRight');
    $personnelRightElement->setLabel("Personalverwaltung");

    $patientsRightElement = new Zend_Form_Element_Checkbox('patientsRight');
    $patientsRightElement->setLabel("Patientenverwaltung");

    $rfidsRightElement = new Zend_Form_Element_Checkbox('rfidsRight');
    $rfidsRightElement->setLabel("RFID-Tag-Verwaltung");

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
      , $academicTitleElement
      , $positionElement
      , $degreeDateElement
      , $layedInElement
      , $layedOutElement
      , $measurementsRightElement
      , $hospitalsRightElement
      , $personnelRightElement
      , $patientsRightElement
      , $rfidsRightElement
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

    $this->addDisplayGroup(array(
      'academicTitle'
      , 'degreeDate'
      , 'position'
      , 'layedIn'
      , 'layedOut'
        )
        , 'professionalGoup'
        , array('legend'=>'Professional Informationen')
    );

    $this->addDisplayGroup(array(
      'measurementsRight'
      , 'hospitalsRight'
      , 'personnelRight'
      , 'patientsRight'
      , 'rfidsRight'
        )
        , 'rightsGoup'
        , array('legend'=>'Rechte')
    );

    $this->addElements(array(
      $submitElement
    ));
  }

}

