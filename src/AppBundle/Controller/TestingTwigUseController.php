<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * TestingTwigUSe controller.
 *
 * @Route("/test")
 */
class TestingTwigUseController extends Controller
{
    /**
     * @Route("/twig_use", name="twig_use")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {

        return array();
    }

}
