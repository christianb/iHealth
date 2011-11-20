<?php

/**
 * The class represents a personnel user.
 * It defines also the structure of the database table for the ORM.
 *
 * @author Benjamin Oertel <mail@benjaminoertel.com>
 * @version 1.0
 * 
 * @Entity
 * @Table(name="personnel")
 * @HasLifeCycleCallbacks
 */
class Application_Model_Personnel
{
    
    /**
     * The personnel id that is a unique identifier for the measurement.
     * @var integer The personnel id.
     * @access private
     * 
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /** 
     * The personnel username.
     * @var string The personnel username.
     * @access private
     * 
     * @Column(type="string", length=32)
     */
    private $username;
    /** 
     * The personnel password.
     * @var string The personnel password.
     * @access private
     * 
     * @Column(type="string", length=32)
     */
    private $password;
        /** 
     * The personnel academic title.
     * @var string The personnel academic title.
     * @access private
     * 
     * @Column(type="string", length=32)
     */
    private $academicTitle;
    /** 
     * The personnel firstname.
     * @var string The personnel firstname.
     * @access private
     * 
     * @Column(type="string", length=64)
     */
    private $firstname;
        /** 
     * The personnel lastname.
     * @var string The personnel lastname.
     * @access private
     * 
     * @Column(type="string", length=64)
     */
    private $lastname;
    /** 
     * The personnel current position.
     * @var string The current position.
     * @access private
     * 
     * @OneToOne(targetEntity="Application_Model_PersonnelPosition")
     * @JoinColumn(name="personnel_position_id_fk", referencedColumnName="id")
     */
    private $position;
    /** 
     * The personnel position layed in date.
     * @var Date The layed in date.
     * @access private
     * 
     * @Column(type="datetime", nullable="true")
     */
    private $layedIn;
    /** 
     * The personnel position layed out date.
     * @var Date The layed out date.
     * @access private
     * 
     * @Column(type="datetime", nullable="true")
     */
    private $layedOut;
    /** 
     * The personnel position degree date.
     * @var Date The degree date.
     * @access private
     * 
     * @Column(type="date", nullable="true")
     */
    private $degreeDate;
    
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

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getAcademicTitle() {
        return $this->academicTitle;
    }

    public function setAcademicTitle($academicTitle) {
        $this->academicTitle = $academicTitle;
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

    public function getPosition() {
        return $this->position;
    }

    public function setPosition($position) {
        $this->position = $position;
    }

    public function getLayedIn() {
        return $this->layedIn;
    }

    public function setLayedIn($layedIn) {
        $this->layedIn = $layedIn;
    }

    public function getLayedOut() {
        return $this->layedOut;
    }

    public function setLayedOut($layedOut) {
        $this->layedOut = $layedOut;
    }

    public function getDegreeDate() {
        return $this->degreeDate;
    }

    public function setDegreeDate($degreeDate) {
        $this->degreeDate = $degreeDate;
    }


}