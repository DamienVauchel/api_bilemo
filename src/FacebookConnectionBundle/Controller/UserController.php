<?php

namespace FacebookConnectionBundle\Controller;

use FacebookConnectionBundle\Entity\User;
use FacebookConnectionBundle\Exception\ResourceValidationException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\ConstraintViolationList;

class UserController extends FOSRestController
{
    // CREATE
    /**
     * @Post(
     *     path="/api/users",
     *     name="app_user_creation"
     * )
     * @ParamConverter("user", converter="fos_rest.request_body")
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @param User $user
     * @param ConstraintViolationList $violations
     * @return mixed
     * @throws
     */
    public function createAction(User $user, ConstraintViolationList $violations)
    {
        if (count($violations))
        {
            $message = "The JSON sent contains invalid data: ";
            foreach ($violations as $violation)
            {
                $message .= sprintf(
                    "Field %s: %s",
                    $violation->getPropertyPath(),
                    $violation->getMessage()
                );
            }
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('app_users_list');
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