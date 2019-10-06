<?php


namespace AppBundle\Security;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\User\UserProviderInterface;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;


class ApiKeyUserProvider implements UserProviderInterface
{
    private $userRepository = null;
    public function __construct(EntityManager $entityManager)
    {
        $this->userRepository = $entityManager->getRepository(User::class);

    }

    public function loadUserByUsername($username)
    {
        $user = $this->userRepository->findOneBy(array("username"=>$username));
        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return User::class === $class;
    }
}