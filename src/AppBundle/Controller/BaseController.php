<?php


namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class BaseController extends Controller
{
    protected  $serializer = null;

    public function __construct()
    {
        $encoders = array(new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizer->setIgnoredAttributes(
            array(
                "__initializer__",
                "__cloner__",
                "__isInitialized__",
            ));
        $normalizers = array($normalizer);
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    protected function sendJsonResponse($json_values){
        $response = new Response($json_values);
        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }
}