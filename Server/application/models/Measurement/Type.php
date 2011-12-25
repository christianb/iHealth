<?php

/**
 * The class represents a measurement type.
 * It defines also the structure of the database table for the ORM.
 *
 * @author Benjamin Oertel <mail@benjaminoertel.com>
 * @version 1.0
 * 
 * @Entity
 * @Table(name="measurement_types")
 * @HasLifeCycleCallbacks
 */
class Application_Model_Measurement_Type{

  /**
   * The measurement type id that is a unique identifier for the measurement type.
   * @var integer The measurement type id.
   * 
   * @Id @Column(type="integer")
   * @GeneratedValue
   */
  private $id;

  /**
   * The measurement name.
   * @var string The measurement name.
   * 
   * @Column(type="string", length=64)
   */
  private $name;

  /**
   * The measurement unit.
   * @var string The measurement unit.
   * 
   * @Column(type="string", length=32)
   */
  private $unit;

  /**
   * Constructor.
   */
  public function __construct(){
    
  }

  public function getId(){
    return $this->id;
  }

  public function setId($id){
    $this->id = $id;
  }

  public function getName(){
    return $this->name;
  }

  public function setName($name){
    $this->name = $name;
  }

  public function getUnit(){
    return $this->unit;
  }

  public function setUnit($unit){
    $this->unit = $unit;
  }

}