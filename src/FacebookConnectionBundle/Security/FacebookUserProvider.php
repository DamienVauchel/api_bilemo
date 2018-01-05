<?php

namespace FacebookConnectionBundle\Security;

use FacebookConnectionBundle\Entity\User;
use GuzzleHttp\Client;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use FacebookConnectionBundle\Manager\UserManager;

class FacebookUserProvider implements UserProviderInterface
{
    private $client;
    private $serializer;
    private $userManager;

    public function __construct(Client $client, SerializerInterface $serializer, UserManager $userManager)
    {
        $this->client = $client;
        $this->serializer = $serializer;
        $this->userManager = $userManager;
    }

    public function loadUserByUsername($accessToken)
    {
        $url = "https://graph.facebook.com/me?access_token=".$accessToken."&fields=id,name,email,birthday,gender,first_name,last_name";

        $response = $this->client->get($url);
        $res = $response->getBody()->getContents();
        $userData = $this->serializer->deserialize($res, 'array', 'json');

        if (!$userData)
        {
            throw new \LogicException('Did not managed to get your user info from Facebook.');
        }

        $user = new User(
            $userData['id'],
            $userData['name'],
//            $userData['email'],
            $userData['gender'],
            $userData['first_name'],
            $userData['last_name']
        );

        $this->userManager->save($user);

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class))
        {
            throw new UnsupportedUserException();
        }

        return $user;
    }

    public function supportsClass($class)
    {
        return 'FacebookConnectionBundle\Entity\User' === $class;
    }

}