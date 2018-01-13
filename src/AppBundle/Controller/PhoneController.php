<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Phone;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;

class PhoneController extends FOSRestController
{
    /**
     * @Get(
     *     path="/api/phones/{id}",
     *     name="app_phone_show",
     *     requirements={"id"="\d+"}
     * )
     * @View(StatusCode=200)
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @param Phone $phone
     * @return Phone
     *
     * @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     type="integer",
     *     description="Unique id to identify the phone.",
     *     required=true
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Phone's detail. Success",
     *     @Model(type=Phone::class)
     * )
     * @SWG\Response(
     *     response=403,
     *     description="You don't have the permission to access this URL. Login or signup, you need a valid access token."
     * )
     * @SWG\Tag(name="Phones")
     */
    public function showAction(Phone $phone)
    {
        return $phone;
    }

    /**
     * @Get(
     *     path="/api/phones",
     *     name="app_phones_list"
     * )
     * @View(StatusCode=200)
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Phones list. Success",
     *     @Model(type=Phone::class)
     * )
     * @SWG\Response(
     *     response=403,
     *     description="You don't have the permission to access this URL. Login or signup, you need a valid access token."
     * )
     * @SWG\Tag(name="Phones")
     */
    public function listAction()
    {
        $phones = $this->getDoctrine()
            ->getRepository('AppBundle:Phone')
            ->findAll();
        $data = $this->get('jms_serializer')
            ->serialize(
                $phones,
                'json'
            );

        $response = new Response($data);
        $response->headers
            ->set('Content-Type', 'application/json');
        $response->setSharedMaxAge(3600);
        $response->headers
            ->addCacheControlDirective('must-revalidate', true);

        return $response;
    }
}
