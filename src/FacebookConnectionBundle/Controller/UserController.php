<?php

namespace FacebookConnectionBundle\Controller;

use FacebookConnectionBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class UserController extends FOSRestController
{
    // CREATE
    /**
     * @Post(
     *     path="/api/users",
     *     name="app_user_creation"
     * )
     */
    public function createAction()
    {

    }

    // READ
    /**
     * @Get(
     *     path="/api/users",
     *     name="app_users_list"
     * )
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function listAction()
    {
        $users = $this->getDoctrine()
            ->getRepository('FacebookConnectionBundle:User')
            ->findAll();
        $data = $this->get('jms_serializer')
            ->serialize(
                $users,
                'json'
            );

        $response = new Response($data);
        $response->headers
            ->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Get(
     *     path="/api/users/{username}",
     *     name="app_user_show"
     * )
     * @View()
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @param User $user
     * @return User
     */
    public function showAction(User $user)
    {
        return $user;
    }

    /**
     * @Delete(
     *     path="/api/delete/{username}",
     *     name="app_user_delete"
     * )
     * @View()
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @param User $user
     * @return mixed
     */
    public function deleteAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('app_users_list');
    }
}