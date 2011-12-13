<?php

/**
 * The class represents a measurement.
 * It defines also the structure of the database table for the ORM.
 *
 * @author Benjamin Oertel <mail@benjaminoertel.com>
 * @version 1.0
 * 
 * @Entity
 * @Table(name="measurements")
 * @HasLifeCycleCallbacks
 */
class Application_Model_Measurement
{
    
    /**
     * The measurement id that is a unique identifier for the measurement.
     * @var integer The measurement id.
     * 
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /** 
     * The measurement memo.
     * @var string The measurement memo.
     * 
     * @Column(type="string", length=256)
     */
    private $memo;
    /** 
     * The measurement value.
     * @var string The measurement value.
     * 
     * @Column(type="string", length=32)
     */
    private $value;
    /** 
     * The measurement date.
     * @var string The measurement date.
     * 
     * @Column(type="datetime", nullable=true)
     */
    private $date;
    /** 
     * The measurement user.
     * @var string The measurement user.
     * 
     * @ManyToOne(targetEntity="Application_Model_Patient")
     * @JoinColumn(name="patient_id_fk", referencedColumnName="id")
     */
    private $patient;
    /** 
     * The measurement type.
     * @var string The measurement type.
     * 
     * @ManyToOne(targetEntity="Application_Model_MeasurementType")
     * @JoinColumn(name="measurement_type_id_fk", referencedColumnName="id")
     */
    private $measurementType;
    /** 
     * The measurement personnel.
     * @var string The measurement personnel.
     * 
     * @ManyToOne(targetEntity="Application_Model_Personnel")
     * @JoinColumn(name="personnel_id_fk", referencedColumnName="id")
     */
    private $personnel;
    
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

    public function getMemo() {
        return $this->memo;
    }

    public function setMemo($memo) {
        $this->memo = $memo;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getReport() {
        return $this->report;
    }

    public function setReport($report) {
        $this->report = $report;
    }

    public function getMeasurementType() {
        return $this->measurementType;
    }

    public function setMeasurementType($measurementType) {
        $this->measurementType = $measurementType;
    }

    public function getPersonnel() {
        return $this->personnel;
    }

    public function setPersonnel($personnel) {
        $this->personnel = $personnel;
    }


}