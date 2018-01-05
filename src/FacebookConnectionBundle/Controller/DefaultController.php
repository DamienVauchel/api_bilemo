<?php

namespace FacebookConnectionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route(
     *     path="/",
     *     name="home"
     * )
     */
    public function indexAction()
    {
        return $this->render('FacebookConnectionBundle/index.html.twig');
    }

    /**
     * @Get(
     *     path="/connection",
     *     name="app_back_connection"
     * )
     *
     * @param $request
     * @return mixed
     */
    public function getCodeAction(Request $request)
    {
        if ($request->query->get('code'))
        {
            return $this->redirectToRoute('home');
        }
    }
}
