<?php

/**
 * The class represents a patient.
 * It defines also the structure of the database table for the ORM.
 *
 * @author Benjamin Oertel <mail@benjaminoertel.com>
 * @version 1.0
 * 
 * @Entity
 * @Table(name="patients")
 * @HasLifeCycleCallbacks
 */
class Application_Model_Patient
{
    
    /**
     * The patient id that is a unique identifier for the patient.
     * @var integer The patient id.
     * 
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /** 
     * The patient firstname.
     * @var string The patient firstname.
     * 
     * @Column(type="string", length=64)
     */
    private $firstname;
    /** 
     * The patient lastname.
     * @var string The patient lastname.
     * 
     * @Column(type="string", length=64)
     */
    private $lastname;
    /** 
     * The patient street.
     * @var string The patient street.
     * 
     * @Column(type="string", length=64)
     */
    private $street;
    /** 
     * The patient city.
     * @var string The patient city.
     * 
     * @Column(type="string", length=64)
     */
    private $city;
    /** 
     * The patient zipcode.
     * @var string The patient zipcode.
     * 
     * @Column(type="string", length=5)
     */
    private $zipcode;
    /** 
     * The patient weight in gramm.
     * @var string The patient weight in gramm.
     * 
     * @Column(type="integer", length=7)
     */
    private $weight;
    /** 
     * The patient size in cm.
     * @var string The patient size in cm.
     * 
     * @Column(type="string", length=64)
     */
    private $size;
    /** 
     * The patient blood group.
     * @var string The patient blood group.
     * 
     * @Column(type="string", length=5)
     */
    private $bloodGroup;
    /**
     * @OneToOne(targetEntity="Application_Model_Rfid", mappedBy="patient")
     */
    private $rfid;
    /** 
     * The patient rfid.
     * @var string The patient rfid.
     * 
     * @OneToMany(targetEntity="Application_Model_HospitalStay", mappedBy="patient")
     * @JoinColumn(name="hospital_stay_id_fk", referencedColumnName="id")
     */
    private $hospitalStays;

    /**
     * Constructor.
     */
    public function __construct() {
        $this->hospitalStays = new \Doctrine\Common\Collections\ArrayCollection();
    }   
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getFirstname() {
        return $this->firstname;
    }

    public function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    public function getStreet() {
        return $this->street;
    }

    public function setStreet($street) {
        $this->street = $street;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function getZipcode() {
        return $this->zipcode;
    }

    public function setZipcode($zipcode) {
        $this->zipcode = $zipcode;
    }

    public function getWeight() {
        return $this->weight;
    }

    public function setWeight($weight) {
        $this->weight = $weight;
    }

    public function getSize() {
        return $this->size;
    }

    public function setSize($size) {
        $this->size = $size;
    }

    public function getBloodGroup() {
        return $this->bloodGroup;
    }

    public function setBloodGroup($bloodGroup) {
        $this->bloodGroup = $bloodGroup;
    }

    public function getRfidTag() {
        return $this->rfidTag;
    }

    public function setRfidTag($rfidTag) {
        $this->rfidTag = $rfidTag;
    }

    public function getHospitalStays() {
        return $this->hospitalStays;
    }

    public function setHospitalStays($hospitalStays) {
        $this->hospitalStays = $hospitalStays;
    }
    
          public function getName(){
      return $this->firstname . " " . $this->lastname;
    }
    
    


}