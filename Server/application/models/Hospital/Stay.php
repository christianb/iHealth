<?php

/**
 * The class represents a hopspital stay.
 * It defines also the structure of the database table for the ORM.
 *
 * @author Benjamin Oertel <mail@benjaminoertel.com>
 * @version 1.0
 * 
 * @Entity
 * @Table(name="hospital_stays")
 * @HasLifeCycleCallbacks
 */
class Application_Model_Hospital_Stay
{
    
    /**
     * The hospital stay id that is a unique identifier for the hospital stay.
     * @var integer The hospital stay id.
     * 
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /** 
     * Whether the hospital stay was an emergency or not.
     * @var string The hospital stay was an emergency.
     * 
     * @Column(type="boolean") 
     */
    private $isEmergency;
    /** 
     * The hospital stay checkin date and time.
     * @var DateTime The checkin date and time.
     * 
     * @Column(type="datetime", nullable="true")
     */
    private $checkIn;
    /** 
     * The hospital stay checkout date and time.
     * @var DateTime The checkout date and time.
     * 
     * @Column(type="datetime", nullable="true")
     */
    private $checkOut;
    /** 
     * The hospital stay icd.
     * @var string The hospital stay icd.
     * 
     * @Column(type="string", length=64)
     */
    private $icd;
    /** 
     * The hospital stay ops.
     * @var string The hospital stay ops.
     * 
     * @Column(type="string", length=64)
     */
    private $ops;
    /** 
     * The hospital operator.
     * @var string The hospital operator.
     * 
     * @OneToOne(targetEntity="Application_Model_Patient")
     * @JoinColumn(name="patient_id_fk", referencedColumnName="id")
     */
    private $patient;
    /** 
     * The hospital operator type.
     * @var string The hospital operator type.
     * 
     * @ManyToOne(targetEntity="Application_Model_Hospital")
     * @JoinColumn(name="hospital_id_fk", referencedColumnName="id")
     */
    private $hospital;


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

    public function getIsEmergency() {
        return $this->isEmergency;
    }

    public function setIsEmergency($isEmergency) {
        $this->isEmergency = $isEmergency;
    }

    public function getCheckIn() {
        return $this->checkIn;
    }

    public function setCheckIn($checkIn) {
        $this->checkIn = $checkIn;
    }

    public function getCheckOut() {
        return $this->checkOut;
    }

    public function setCheckOut($checkOut) {
        $this->checkOut = $checkOut;
    }

    public function getIcd() {
        return $this->icd;
    }

    public function setIcd($icd) {
        $this->icd = $icd;
    }

    public function getOps() {
        return $this->ops;
    }

    public function setOps($ops) {
        $this->ops = $ops;
    }

    public function getPatient() {
        return $this->patient;
    }

    public function setPatient($patient) {
        $this->patient = $patient;
    }

    public function getHospital() {
        return $this->hospital;
    }

    public function setHospital($hospital) {
        $this->hospital = $hospital;
    }


}