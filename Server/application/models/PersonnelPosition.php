<?php

/**
 * The class represents a personnel position.
 * It defines also the structure of the database table for the ORM.
 *
 * @author Benjamin Oertel <mail@benjaminoertel.com>
 * @version 1.0
 * 
 * @Entity
 * @Table(name="personnel_positions")
 * @HasLifeCycleCallbacks
 */
class Application_Model_PersonnelPosition
{
    
    /**
     * The personnel position id that is a unique identifier for the personnel position.
     * @var integer The personnel position id.
     * @access private
     * 
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /** 
     * The personnel position title.
     * @var string The position title.
     * @access private
     * 
     * @Column(type="string", length=128)
     */
    private $title;
    /** 
     * The personnel position beleg position.
     * @var string The personnel position beleg position.
     * @access private
     * 
     * @Column(type="string", length=64)
     */
    private $belegPosition;

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

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getBelegPosition() {
        return $this->belegPosition;
    }

    public function setBelegPosition($belegPosition) {
        $this->belegPosition = $belegPosition;
    }


}