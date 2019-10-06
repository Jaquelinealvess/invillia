<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Item;
use AppBundle\Entity\Phone;
use AppBundle\Entity\ShipOrder;
use AppBundle\Entity\ShipTo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Person;


class HomeController extends BaseController {


    /**
     * @Route("/",name="import", methods={"GET"})
     */
    public function importXML(){
        return $this->render('index/import.html.twig');
    }


    private function processPeoplePost($xmlarray){
        $entityManager = $this->getDoctrine()->getManager();
        foreach ($xmlarray['person'] as $p){
            $person = $this->getDoctrine()->getRepository(Person::class)->find($p['personid']);
            if(empty($person)){
                $person =  new Person();
                $person->setId($p['personid']);
            }else{
                $query = $entityManager->createQuery('DELETE FROM AppBundle:Phone p WHERE p.person = :person ')->setParameter('person', $person);
                $query->execute();
            }
           $person->setPersonname($p['personname']);
           $entityManager->persist($person);
           $entityManager->flush();
           $phones = $p['phones']['phone'];
           if(is_array($phones)){
               foreach ($phones as $ph){
                   $phone = new Phone();
                   $phone->setPerson($person)->setPhonenumber($ph);
                   $entityManager->persist($phone);
                   $entityManager->flush();
               }
           }else{
               $phone = new Phone();
               $phone->setPerson($person)->setPhonenumber($phones);
               $entityManager->persist($phone);
               $entityManager->flush();
           }

        }
        return $this->sendJsonResponse(json_encode(array('error'=>false,'response_text'=>'Persons importado com sucesso')));
    }

    private function processShipOrderPost($xmlarray){
        $entityManager = $this->getDoctrine()->getManager();
        $shiporder2save = array();
        $shipto2save = array();
        $item2save = array();

        foreach ($xmlarray['shiporder'] as $so){
            $shiporder = $this->getDoctrine()->getRepository(ShipOrder::class)->find($so['orderid']);
            if(empty($shiporder)){
                $shiporder = new ShipOrder();
            }else{
                /*$query = $entityManager->createQuery('DELETE FROM AppBundle:ShipTo p WHERE p.shiporder = :shiporder ')->setParameter('shiporder', $shiporder);
                $query->execute();

                $query = $entityManager->createQuery('DELETE FROM AppBundle:Item p WHERE p.shiporder = :shiporder ')->setParameter('shiporder', $shiporder);
                $query->execute();
                */
                $entityManager->remove($shiporder);

            }
            $shiporder->setId($so['orderid']);
            $person = $this->getDoctrine()->getRepository(Person::class)->find($so['orderperson']);
            if(empty($person)){
                return $this->sendJsonResponse(json_encode(array('error'=>true,'response_text'=>'Person id '.$so['orderperson'].' não encontado. Por favor selecione person.xml primeiro')));
            }
            $shiporder->setPerson($person);

            $st = $so['shipto'];
            $shipto = new ShipTo();
            $shipto->setName($st['name'])->setAddress($st['address'])->setCity($st['city'])->setCountry($st['country'])->setShipOrder($shiporder);
            array_push($shipto2save, $shipto);
            $shiporder->setShipto($shipto);

            foreach ($so['items'] as $it){
                if(!empty($it[0])){
                    foreach ($it as $i){
                        $item = new Item();
                        $item->setShipOrder($shiporder)->setNote($i['note'])->setPrice($i['price'])->setQuantity($i['quantity'])->setTitle($i['title']);
                        array_push($item2save, $item);
                    }
                }else{
                    $item = new Item();
                    $item->setShipOrder($shiporder)->setNote($it['note'])->setPrice($it['price'])->setQuantity($it['quantity'])->setTitle($it['title']);
                    array_push($item2save, $item);
                }

            }
            array_push($shiporder2save, $shiporder);
        }

        //se não ocorrer nenhum erro, então salva no banco de dados
        foreach ($shiporder2save as $shiporder){
            $entityManager->persist($shiporder);
            $entityManager->flush();
        }
        foreach ($shipto2save as $shipto){
            $entityManager->persist($shipto);
            $entityManager->flush();
        }
        foreach ($item2save as $item){
            $entityManager->persist($item);
            $entityManager->flush();
        }

        return $this->sendJsonResponse(json_encode(array('error'=>false,'response_text'=>'Shiporders importado com sucesso')));
    }


    /**
     * @Route("/upload/xml",name="upload_xml", methods={"POST"})
     */
    public function importXMLPost(Request $request){
        $file = $request->files->get('xml');
        $xmlfile = file_get_contents($file);
        $xmlObject = simplexml_load_string($xmlfile);
        $xmljson = json_encode($xmlObject);
        $xmlarray = json_decode($xmljson, true);

        if(!empty($xmlarray['person'])){
            return $this->processPeoplePost($xmlarray);
        }
        if(!empty($xmlarray['shiporder'])){
            return $this->processShipOrderPost($xmlarray);
        }
        try{
            echo "";
        }catch (\Exception $ex){

            return $this->sendJsonResponse(json_encode(array('error'=>true,'response_text'=>'XML mal formatado')));
        }

    }

}