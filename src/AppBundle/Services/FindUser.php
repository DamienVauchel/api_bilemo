<?php

namespace AppBundle\Services;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class FindUser
{
    private $tokenStorage;
    private $em;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $em)
    {
        $this->tokenStorage = $tokenStorage;
        $this->em = $em;
    }

    public function findUser()
    {
        $user_username = $this->tokenStorage
            ->getToken()
            ->getUser()
            ->getUsername();

        $user = $this->em
            ->getRepository('FacebookConnectionBundle:User')
            ->findByUsername($user_username);

        return $user;
    }

}