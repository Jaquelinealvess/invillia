<?php


namespace AppBundle\Controller;

use AppBundle\Entity\ShipOrder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class ApiShipOrderController extends BaseController
{


    /**
     * @Route("api/shiporders",name="shiporders", methods={"GET"})
     */
    public function getShipOrders(){
        $shiporders = $this->getDoctrine()->getRepository(ShipOrder::class)->findAll();
        $json = $this->serializer->serialize(array("shiporders"=>$shiporders), 'json');
        return $this->sendJsonResponse($json);
    }


    /**
    * @Route("api/shiporders/id/{id}",name="shiporder_show", methods={"GET"})
    */
    public function getShipOrder($id){
        $shipordder = $this->getDoctrine()->getRepository(ShipOrder::class)->find($id);
        $json = $this->serializer->serialize($shipordder,'json');
        return $this->sendJsonResponse($json);
    }

    /**
     * @Route("api/shiporders/person/{person_id}",name="shiporder_person", methods={"GET"})
     */
    public function getShipOrderPerson($person_id){
        $shipordder = $this->getDoctrine()->getRepository(ShipOrder::class)->findBy(array(
            'person'=>$person_id
        ));
        $json = $this->serializer->serialize($shipordder,'json');
        return $this->sendJsonResponse($json);
    }


}