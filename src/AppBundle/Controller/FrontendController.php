<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class FrontendController extends Controller
{
    /**
     * @Route("/home")
     * @Template()
     */
    public function homeAction()
    {
        return array(// ...
        );
    }

    /**
     * @Route("/quotationRequest")
     * @Template()
     */
    public function quotationRequestAction()
    {
        return array(// ...
        );
    }

    /**
     * @Route("/gallery")
     * @Template()
     */
    public function galleryAction()
    {
        return array(// ...
        );
    }

    /**
     * @Route("/qualityCharter")
     * @Template()
     */
    public function qualityCharterAction()
    {
        return array(// ...
        );
    }

    /**
     * @Route("/partners")
     * @Template()
     */
    public function partnersAction()
    {
        return array(// ...
        );
    }

    /**
     * @Route("/businessService")
     * @Template()
     */
    public function businessServiceAction()
    {
        return array(// ...
        );
    }

}
