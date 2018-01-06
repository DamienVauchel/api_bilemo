<?php

namespace FacebookConnectionBundle\Security;

use AppBundle\Exception\BeLoggedException;
use GuzzleHttp\Client;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;

class FacebookAuthenticator implements SimplePreAuthenticatorInterface
{
    private $client;
    private $serializer;
    private $client_id;
    private $client_secret;
    private $redirect_uri;

    public function __construct(Client $client, SerializerInterface $serializer, $client_id, $client_secret, $redirect_uri)
    {
        $this->client = $client;
        $this->serializer = $serializer;
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->redirect_uri = $redirect_uri;
    }

    public function createToken(Request $request, $providerKey)
    {
        if ($code = $request->query->get('code'))
        {
            $code = $request->query->get('code');
            $url = "https://graph.facebook.com/v2.11/oauth/access_token?client_id=".$this->client_id."&redirect_uri=".$this->redirect_uri."&client_secret=".$this->client_secret."&code=".$code;
            $response = $this->client->get($url);
            $res = $response->getBody()->getContents();
            $userData = $this->serializer->deserialize($res, 'array', 'json');

            $accessToken = $userData['access_token'];
        }
        elseif($bearer = $request->headers->get('Authorization'))
        {
            $bearer = $request->headers->get('Authorization');

            $accessToken = substr($bearer, 7);
        }
        else
        {
            $message = "You must be logged to access this page!";
            throw new BeLoggedException($message);
        }

        return new PreAuthenticatedToken(
            'anon.',
            $accessToken,
            $providerKey
        );
    }

    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {

        $accessToken = $token->getCredentials();
        $user = $userProvider->loadUserByUsername($accessToken);

        return new PreAuthenticatedToken(
            $user,
            $accessToken,
            $providerKey,
            ['ROLE_USER']
        );
    }

    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new Response("Authentication Failed :(", 401);
    }
}