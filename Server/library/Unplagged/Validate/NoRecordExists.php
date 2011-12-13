<?php

/*
 * Validator for checking that a record does not exist yet.
 */

/**
 * This validator helps to check if a specific column in the databse contains a specific record already.
 *
 * @author Benjamin Oertel <mail@benjaminoertel.com>
 * @version 1.0
 */
class Unplagged_Validate_NoRecordExists extends Zend_Validate_Abstract{

  private $_table;
  private $_field;

  const OK = '';

  protected $_messageTemplates = array(
    self::OK=>"'%value%' ist bereits in der Datenbank"
  );

  public function __construct($table, $field){
    $this->_em = Zend_Registry::getInstance()->entitymanager;
    $this->_table = $table;
    $this->_field = $field;
  }

  public function isValid($value){
    $this->_setValue($value);

    $element = $this->_em->getRepository($this->_table)->findBy(array($this->_field => $value));

    if(empty($element)){
      return true;
    } else {
      $this->_error(self::OK);
      return false;
    }
  }

}
