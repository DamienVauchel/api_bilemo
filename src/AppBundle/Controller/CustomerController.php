<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
use AppBundle\Exception\NotTheGoodUserException;
use AppBundle\Exception\UniqueUsernameException;
use Doctrine\DBAL\DBALException;
use FacebookConnectionBundle\Exception\ResourceValidationException;
use FacebookConnectionBundle\Exception\UserExistException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\ConstraintViolationList;
use Swagger\Annotations as SWG;

class CustomerController extends FOSRestController
{
    // CREATE
    /**
     * @Post(
     *     path="/api/customers",
     *     name="app_customer_creation"
     * )
     * @ParamConverter("customer", converter="fos_rest.request_body")
     *
     * @View(StatusCode=201)
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @param Customer $customer
     * @param ConstraintViolationList $violations
     * @return mixed
     * @throws
     *
     * @SWG\Parameter(
     *     name="username",
     *     in="header",
     *     type="string",
     *     description="customer's username or fullname. Have to be unique",
     *     required=true
     * )
     * @SWG\Parameter(
     *     name="email",
     *     in="header",
     *     type="string",
     *     description="customer's email.",
     *     required=true
     * )
     * @SWG\Parameter(
     *     name="password",
     *     in="header",
     *     type="string",
     *     description="customer's password.",
     *     required=true
     * )
     * @SWG\Parameter(
     *     name="first_name",
     *     in="header",
     *     type="string",
     *     description="customer's first name.",
     *     required=true
     * )
     * @SWG\Parameter(
     *     name="last_name",
     *     in="header",
     *     type="string",
     *     description="customer's last name.",
     *     required=true
     * )
     *
     * @SWG\Response(
     *     response=201,
     *     description="Manually create a new customer. Success",
     *     @Model(type=Customer::class)
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Invalid data sent, missing field(s) or username already exists in the database"
     * )
     * @SWG\Response(
     *     response=403,
     *     description="You don't have the permission to access this URL. Login or signup, you need a valid access token."
     * )
     * @SWG\Tag(name="Customers")
     */
    public function createAction(Customer $customer, ConstraintViolationList $violations)
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

        $user = $this->get('user_finder')
            ->findUser();
        $customer->setUser($user);

        $em = $this->getDoctrine()->getManager();
        $em->persist($customer);
        try
        {
            $em->flush();
        }
        catch (DBALException $exception)
        {
            throw new UniqueUsernameException(sprintf("Username is already taken, chose another one"));
        }

        return $this->redirectToRoute('app_customer_list');
    }

    // READ
    /**
     * @Get(
     *     path="/api/customers",
     *     name="app_customer_list"
     * )
     *
     * @View(StatusCode=200)
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @SWG\Response(
     *     response=200,
     *     description="customer list. Success",
     *     @Model(type=Customer::class)
     * )
     * @SWG\Response(
     *     response=403,
     *     description="You don't have the permission to access this URL. Login or signup, you need a valid access token."
     * )
     * @SWG\Tag(name="Customers")
     */
    public function listAction()
    {
        $user = $this->get('user_finder')
            ->findUser();
        $user_id = $user->getId();

        $customers = $this->getDoctrine()
            ->getRepository('AppBundle:Customer')
            ->getCustomersUser($user_id);

        $data = $this->get('jms_serializer')
            ->serialize(
                $customers,
                'json'
            );

        $response = new Response($data);
        $response->headers
            ->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Get(
     *     path="/api/customers/{id}",
     *     name="app_customer_show",
     *     requirements={"id"="\d+"}
     * )
     * @View(StatusCode=200)
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @param Customer $customer
     * @return Customer
     * @throws
     *
     * @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     type="integer",
     *     description="Unique id to identify the customer.",
     *     required=true
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="customer's detail. Success",
     *     @Model(type=Customer::class)
     * )
     * @SWG\Response(
     *     response=403,
     *     description="You don't have the permission to access this URL. Login, signup or change account, you need a valid access token."
     * )
     * @SWG\Tag(name="Customers")
     */
    public function showAction(Customer $customer)
    {
        $user = $this->get('user_finder')
            ->findUser();
        if ($user === $customer->getUser())
        {
            return $customer;
        }
        else
        {
            throw new NotTheGoodUserException(sprintf("This client isn't from your database, log in with the good account."));
        }
    }

    /**
     * @Delete(
     *     path="/api/customers/{id}",
     *     name="app_customer_delete",
     *     requirements={ "id"="\d+" }
     * )
     * @View(StatusCode=200)
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @param Customer $customer
     * @return mixed
     * @throws
     *
     * @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     type="integer",
     *     description="Unique id to identify the user.",
     *     required=true
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Delete a customer. Success.",
     *     @Model(type=Customer::class)
     * )
     * @SWG\Response(
     *     response=403,
     *     description="You don't have the permission to access this URL. Login, signup or change account, you need a valid access token."
     * )
     * @SWG\Tag(name="Customers")
     */
    public function deleteAction(Customer $customer)
    {
        $user = $this->get('user_finder')
            ->findUser();
        if ($user === $customer->getUser())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($customer);
            $em->flush();

            return $this->redirectToRoute('app_customer_list');
        }
        else
        {
            throw new NotTheGoodUserException(sprintf("This client isn't from your database, log in with the good account."));
        }
    }
}