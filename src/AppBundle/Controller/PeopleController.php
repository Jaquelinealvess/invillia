<?php


namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Person;


class PeopleController extends BaseController
{

    /**
     * @Route("api/people",name="people", methods={"GET"})
     * @return $json_object
     */
    public function getPersons(){
        $persons = $this->getDoctrine()->getRepository(Person::class)->findAll();
        $json = $this->serializer->serialize(array("people"=>$persons),'json');
        return $this->sendJsonResponse($json);
    }

    /**
     * @Route("api/people/person/{id}",name="people_show", methods={"GET"})
     */
    public function getPersonId($id){
        $person = $this->getDoctrine()->getRepository(Person::class)->find($id);
        $json = $this->serializer->serialize($person,'json');
        return $this->sendJsonResponse($json);
    }




}