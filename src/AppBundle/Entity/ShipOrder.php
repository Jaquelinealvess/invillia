<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="shiporder")
 */

class ShipOrder
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="shiporders", cascade={"persist"})
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $person;




    /**
     * @ORM\OneToOne(targetEntity="ShipTo", mappedBy="shiporder", cascade={"persist"})
     */
    private $shipto;


    /**
     * Set shiporder id
     *
     * @param integer $id
     *
     * @return ShipOrder
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getOrderid()
    {
        return $this->id;
    }




    /**
     * @param Person
     * @return ShipOrder
     */
    public function setPerson($person){
        $this->person = $person;
        return $this;
    }



    /**
     * @return $person_id
     */
    public function getOrderperson(){
        return $this->person;
    }

    /**
     * Set shipto
     *
     * @param ShipTo $shipto
     *
     * @return ShipOrder
     */
    public function setShipto($shipto)
    {
        $this->shipto = $shipto;

        return $this;
    }

    /**
     * Get shiptos
     *
     * @return ShipTo
     */
    public function getShipto()
    {
        return $this->shipto;
    }

    /**
     * @return ArrayCollection
     */
    public function getItems(){
        return $this->items;
    }

    /**
     * @param $items
     * @return $this
     */
    public function setItems($items){
        $this->items = $items;
        return $this;
    }


    /**
     * @ORM\OneToMany(targetEntity="Item", mappedBy="shiporder")
     */
    private $items;
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }


}

