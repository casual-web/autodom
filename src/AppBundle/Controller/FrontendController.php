<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class FrontendController extends Controller
{
    /**
     * @Route("/",  name="home")
     * @Method("GET")
     * @Template()
     */
    public function homeAction()
    {
        // get list of business services object
        $em = $this->get('doctrine.orm.entity_manager');
        $repository = $em->getRepository('AppBundle\Entity\BusinessService');
        $businessServices = $repository->findEnabled();

        return array('businessServices' => $businessServices);
    }

    /**
     * @Route("/demande-devis",  name="quotation_request")
     * @Method("GET")
     * @Template()
     */
    public function quotationRequestAction()
    {
        return array(// ...
        );
    }

    /**
     * @Route("/realisations",  name="gallery")
     * @Method("GET")
     * @Template()
     */
    public function galleryAction()
    {
        return array(// ...
        );
    }

    /**
     * @Route("/charte-qualite",  name="quality_charter")
     * @Method("GET")
     * @Template()
     */
    public function qualityCharterAction()
    {
        return array(// ...
        );
    }

    /**
     * @Route("/partenaires",  name="partners")
     * @Method("GET")
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
