<?php

/**
 * The class represents a hopspital.
 * It defines also the structure of the database table for the ORM.
 *
 * @author Benjamin Oertel <mail@benjaminoertel.com>
 * @version 1.0
 * 
 * @Entity
 * @Table(name="hospitals")
 * @HasLifeCycleCallbacks
 */
class Application_Model_Hospital
{
    
    /**
     * The hospital id that is a unique identifier for the hospital.
     * @var integer The hospital id.
     * 
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /** 
     * The hospital name.
     * @var string The hospital name.
     * 
     * @Column(type="string", length=64)
     */
    private $name;
    /** 
     * The hospital ik.
     * @var string The hospital ik.
     * 
     * @Column(type="string", length=64)
     */
    private $ik;
    /** 
     * The hospital operator.
     * @var string The hospital operator.
     * 
     * @Column(type="string", length=64)
     */
    private $operator;
    /** 
     * The hospital operator type.
     * @var string The hospital operator type.
     * 
     * @Column(type="string", length=64)
     */
    private $opteratorType;
    /** 
     * Whether the hospital is a teaching hospital or not.
     * @var string The hospital name.
     * 
     * @Column(type="boolean") 
     */
    private $isTeachingHospital;

    /**
     * Constructor.
     */
    public function __construct() {
    }   
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getIk() {
        return $this->ik;
    }

    public function setIk($ik) {
        $this->ik = $ik;
    }

    public function getOperator() {
        return $this->operator;
    }

    public function setOperator($operator) {
        $this->operator = $operator;
    }

    public function getOpteratorType() {
        return $this->opteratorType;
    }

    public function setOpteratorType($opteratorType) {
        $this->opteratorType = $opteratorType;
    }

    public function getIsTeachingHospital() {
        return $this->isTeachingHospital;
    }

    public function setIsTeachingHospital($isTeachingHospital) {
        $this->isTeachingHospital = $isTeachingHospital;
    }

}