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
class Application_Model_RFIDTag
{
    
    /**
     * The rfid tag id that is a unique identifier for the rfid tag.
     * @var integer The rfid tag id.
     * @access private
     * 
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /** 
     * The rfid tag tag.
     * @var string The rfid tag tag.
     * @access private
     * 
     * @Column(type="string", length=64)
     */
    private $tag;

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

    public function getTag() {
        return $this->tag;
    }

    public function setTag($tag) {
        $this->tag = $tag;
    }


}