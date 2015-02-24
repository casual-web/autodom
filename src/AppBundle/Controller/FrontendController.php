<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\QuotationRequest;
use AppBundle\Form\FrontQuotationRequestType;


class FrontendController extends Controller
{
    /**
     * @Route("/",  name="home")
     * @Method("GET")
     * @Template()
     */
    public function homeAction()
    {

        return array(// ...
        );
    }

    /**
     * @Route("/demande-devis",  name="quotation_request")
     * @Method("GET")
     * @Template()
     */
    public function quotationRequestAction()
    {
        $entity = new QuotationRequest();
        $form = $this->createQRForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );

    }

    /**
     * Creates a form to create a QuotationRequest entity.
     *
     * @param QuotationRequest $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createQRForm(QuotationRequest $entity)
    {
        $em = $this->getDoctrine()->getManager();
        $choices = $em->getRepository('AppBundle:BusinessService')->getChoices();
        $qr = new FrontQuotationRequestType();
        $form = $this->createForm($qr, $entity, array(
            'action' => $this->generateUrl('quotation_request'),
            'method' => 'POST',
            'enabled_business_services' => $choices
        ));

        $form->add('submit', 'submit', array('label' => 'Envoyer ma demande'));

        return $form;
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
