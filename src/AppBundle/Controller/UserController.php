<?php


namespace AppBundle\Controller;


use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserController extends BaseController

{

    /**
     * @param  Request $request
     * @Route("/user/create", name="user_create" ,methods={"POST"})
     * Função apenas para criar usuário para teste da api
     */
    public function createUserPost(Request $request){

        $rq = $request->request->all();
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(array('username'=>$rq['username']));
        if(!empty($user)){
            return $this->sendJsonResponse(json_decode(array("erro"=>"Username já existe")));
        }
        $user = new User();
        $user->setUsername($rq['username']);
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, $rq['password']);
        $user->setEncriptedPassword($password);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->sendJsonResponse($this->serializer->serialize($user,'json'));
    }
}