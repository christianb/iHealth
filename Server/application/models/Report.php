<?php

/**
 * The class represents a report.
 * It defines also the structure of the database table for the ORM.
 *
 * @author Benjamin Oertel <mail@benjaminoertel.com>
 * @version 1.0
 * 
 * @Entity
 * @Table(name="reports")
 * @HasLifeCycleCallbacks
 */
class Application_Model_Report
{
    
    /**
     * The report id that is a unique identifier for the report.
     * @var integer The report id.
     * @access private
     * 
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /** 
     * The hospital stay the report belongs to.
     * @var string The hospital stay the report belongs to.
     * @access private
     * 
     * @ManyToOne(targetEntity="Application_Model_HospitalStay")
     * @JoinColumn(name="hospital_stay_id_fk", referencedColumnName="id")
     */
    private $hospitalStay;
    /** 
     * The report measurements.
     * @var string The report measurements.
     * @access private
     * 
     * @OneToMany(targetEntity="Application_Model_Measurement", mappedBy="id")
     */
    private $measurements;

    /**
     * Constructor.
     */
    public function __construct() {
        $this->measurements = new \Doctrine\Common\Collections\ArrayCollection();
    }   
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getHospitalStay() {
        return $this->hospitalStay;
    }

    public function setHospitalStay($hospitalStay) {
        $this->hospitalStay = $hospitalStay;
    }

    public function getMeasurements() {
        return $this->measurements;
    }

    public function setMeasurements($measurements) {
        $this->measurements = $measurements;
    }


}