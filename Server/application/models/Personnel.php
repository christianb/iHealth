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
     * 
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /** 
     * The personnel email.
     * @var string The personnel email.
     * 
     * @Column(type="string", length=32)
     */
    private $email;
    /** 
     * The personnel username.
     * @var string The personnel username.
     * 
     * @Column(type="string", length=32)
     */
    private $username;
    /** 
     * The personnel password.
     * @var string The personnel password.
     * 
     * @Column(type="string", length=64)
     */
    private $password;
        /** 
     * The personnel academic title.
     * @var string The personnel academic title.
     * 
     * @Column(type="string", length=32, nullable=true)
     */
    private $academicTitle;
    /** 
     * The personnel firstname.
     * @var string The personnel firstname.
     * 
     * @Column(type="string", length=64, nullable=true)
     */
    private $firstname;
        /** 
     * The personnel lastname.
     * @var string The personnel lastname.
     * 
     * @Column(type="string", length=64, nullable=true)
     */
    private $lastname;
            /** 
     * The personnel state.
     * @var string The personnel state.
     * 
     * @Column(type="string", length=64, nullable=true)
     */
    private $state;
    /** 
     * The personnel current position.
     * @var string The current position.
     * 
     * @OneToOne(targetEntity="Application_Model_Personnel_Position")
     * @JoinColumn(name="personnel_position_id_fk", referencedColumnName="id")
     */
    private $position;
    /** 
     * The personnel position layed in date.
     * @var Date The layed in date.
     * 
     * @Column(type="datetime", nullable="true")
     */
    private $layedIn;
    /** 
     * The personnel position layed out date.
     * @var Date The layed out date.
     * 
     * @Column(type="datetime", nullable="true")
     */
    private $layedOut;
    /** 
     * The personnel position degree date.
     * @var Date The degree date.
     * 
     * @Column(type="date", nullable="true")
     */
    private $degreeDate;
      /**
   * The users registration hash, used to verify the account.
   * @var string The registration hash.
   * 
   * @Column(type="string", length=32, unique=true)
   */
  private $verificationHash;
  
    /**
     * Constructor.
     */
    public function __construct($data = array()){
    if(isset($data["username"])){
      $this->username = $data["username"];
    }

    if(isset($data["password"])){
      $this->password = $data["password"];
    }

    if(isset($data["email"])){
      $this->email = $data["email"];
    }

    if(isset($data["firstname"])){
      $this->firstname = $data["firstname"];
    }

    if(isset($data["lastname"])){
      $this->lastname = $data["lastname"];
    }

    if(isset($data["verificationHash"])){
      $this->verificationHash = $data["verificationHash"];
    }

    if(isset($data["state"])){
      $this->state = $data["state"];
    }
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
    
    public function getEmail(){
      return $this->email;
    }

    public function setEmail($email){
      $this->email = $email;
    }

    public function getState(){
      return $this->state;
    }

    public function setState($state){
      $this->state = $state;
    }

    public function getVerificationHash(){
      return $this->verificationHash;
    }

    public function setVerificationHash($verificationHash){
      $this->verificationHash = $verificationHash;
    }
    
        public function getName(){
      return $this->firstname . " " . $this->lastname;
    }

}