<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Phone;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\Response;

class PhoneController extends FOSRestController
{
    /**
     * @Get(
     *     path="/api/phones/{id}",
     *     name="app_phone_show",
     *     requirements={"id"="\d+"}
     * )
     * @View()
     *
     * @param Phone $phone
     * @return Phone
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

        return $response;
    }

//    /**
//     * @Post(
//     *     path="/api/phones",
//     *     name="app_phone_creation"
//     * )
//     * @View(StatusCode=201)
//     *
//     * @ParamConverter("phone", converter="fos_rest.request_body")
//     *
//     * @param Phone $phone
//     * @return Phone
//     */
//    public function createAction(Phone $phone)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($phone);
//        $em->flush();
//
//        return $phone;
//    }
}
