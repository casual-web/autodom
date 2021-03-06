<?php

namespace AppBundle\Controller;

use AppBundle\Form\ImageSiteType;
use AppBundle\Form\ImageUploadType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\ImageSite;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_tableaudebord")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $repository = $em->getRepository('AppBundle\Entity\QuotationRequest');
        $metrics = $repository->findDashboardMetrics();

        return array('metrics' => $metrics);

    }

}
