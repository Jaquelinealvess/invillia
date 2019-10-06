<?php

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="person")
 */
class Person
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     */
    private $id;


    /**
     * @var string
     * @ORM\Column(name="personname", type="string")
     */
    private $personname;


    /**
     * Get id
     *
     * @return int
     */
    public function getPersonid()
    {
        return $this->id;
    }

    /**
     * Set person id
     *
     * @param integer $id
     *
     * @return Person
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Set personname
     *
     * @param string $personname
     *
     * @return Person
     */
    public function setPersonname($personname)
    {
        $this->personname = $personname;

        return $this;
    }

    /**
     * Get personname
     *
     * @return string
     */
    public function getPersonname()
    {
        return $this->personname;
    }

    /**
     * @ORM\OneToMany(targetEntity="Phone", mappedBy="person")
     */
    private $phones;

    public function getPhones(){
        return $this->phones;
    }

    public function setPhones($phones){
        $this->phones = $phones;
        return $this;
    }

    /**
     * @ORM\OneToMany(targetEntity="ShipOrder", mappedBy="person")
     */
    private $shiporders;


    public function __construct()
    {
        $this->phones = new ArrayCollection();
        $this->shiporders = new ArrayCollection();
    }
}

