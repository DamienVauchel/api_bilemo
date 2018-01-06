<?php

namespace FacebookConnectionBundle\Manager;


use FacebookConnectionBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserManager
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function save(User $user)
    {
        if (!$this->facebookUserExists($user))
        {
            $this->em->persist($user);
            $this->em->flush();
        }
    }

    public function facebookUserExists(User $user)
    {
        $user = $this->em->getRepository(User::class)->findOneBy(array('facebookId' => $user->getFacebookId()));
        return isset($user) ? true : false;
    }

    public function userExists(User $user)
    {
        $user = $this->em->getRepository(User::class)->findOneBy(array('username' => $user->getUsername()));
        return isset($user) ? true : false;
    }
}