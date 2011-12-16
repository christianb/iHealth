<?php

/**
 * The class represents a rfid tag.
 * It defines also the structure of the database table for the ORM.
 *
 * @author Benjamin Oertel <mail@benjaminoertel.com>
 * @version 1.0
 * 
 * @Entity
 * @Table(name="rfid_tags")
 * @HasLifeCycleCallbacks
 */
class Application_Model_Rfid
{
    
    /**
     * The rfid tag id that is a unique identifier for the rfid tag.
     * @var integer The rfid tag id.
     * 
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /** 
     * The rfid tag tag.
     * @var string The rfid tag tag.
     * 
     * @Column(type="string", length=64)
     */
    private $tag;
    /**
     * @OneToOne(targetEntity="Application_Model_Patient", inversedBy="rfid")
     * @JoinColumn(name="patient_id", referencedColumnName="id")
     */
    private $patient;

    /**
     * Constructor.
     */
    public function __construct($data) {
      if(isset($data["tag"])){
        $this->tag = $data["tag"];
      }
      if(isset($data["patient"])){
        $this->patient = $data["patient"];
      }
    }
    
    public function getId(){
      return $this->id;
    }

    public function getTag(){
      return $this->tag;
    }

    public function getPatient(){
      return $this->patient;
    }
    
    public function setPatient($patient){
      $this->patient = $patient;
    }





}