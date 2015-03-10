<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\QuotationRequest;
use AppBundle\Entity\QuotationRequestServiceRelation;
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
        $is_repo = $this->getDoctrine()->getRepository('AppBundle:BusinessService');
        return array('entities' => $is_repo->findEnabled());
    }

    /**
     * @Route("/debosselage-sans-peinture",  name="debosselage-sans-peinture")
     * @Method("GET")
     * @Template("AppBundle:FrontBusinessService:debosselage-sans-peinture.html.twig")
     */
    public function DSPAction()
    {
        $actionParameters = $this->getBusinessServiceActionParameters('DSP');
        return $actionParameters;
    }

    public function getBusinessServiceActionParameters($businessServiceRef)
    {

        $is_repo = $this->getDoctrine()->getRepository('AppBundle:ImageSite');
        $entities = $is_repo->findVisibleByService($businessServiceRef);
        $active_item_id = (isset($entities[0]) ? $entities[0]->getId() : null);

        return [
            'entities' => $entities,
            'active_item_id' => $active_item_id];
    }

    /**
     * @Route("/renovation-optiques",  name="renovation-optiques")
     * @Method("GET")
     * @Template("AppBundle:FrontBusinessService:renovation-optiques.html.twig")
     */
    public function OPTAction()
    {
        $actionParameters = $this->getBusinessServiceActionParameters('OPT');
        return $actionParameters;
    }

    /**
     * @Route("/renovation-carrosserie",  name="renovation-carrosserie")
     * @Method("GET")
     * @Template("AppBundle:FrontBusinessService:renovation-carrosserie.html.twig")
     */
    public function CARAction()
    {
        $actionParameters = $this->getBusinessServiceActionParameters('CAR');
        return $actionParameters;
    }


    /**
     * Creates a new QuotationRequest entity.
     *
     * @Route("/", name="frontend_devis_create")
     * @Method("POST")
     * @Template("AppBundle:QuotationRequest:new.html.twig")
     */
    public function createQRAction(Request $request)
    {

        $entity = new QuotationRequest();
        $form = $this->createQRForm($entity);
        $form->handleRequest($request);

        $notifier = $this->get('autodom.notifier');

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.quotation_request_manager');
            $em->persistAndFlushWithRelation(
                $entity,
                $form->get('quotationRequestServiceRelations')->getData());

            $notifier->sendQuotationRequestNotification($entity);
            return $this->redirect($this->generateUrl('home'));
        }

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
        $qr = new FrontQuotationRequestType();
        $form = $this->createForm($qr, $entity, array(
            'action' => $this->generateUrl('frontend_devis_create'),
            'method' => 'POST',
            'em' => $this->getDoctrine()->getManager(),
        ));

        $form->add('submit', 'submit', array('label' => 'Envoyer ma demande'));

        return $form;
    }

    /**
     * @Route("/demande-devis",  name="quotation_request")
     * @Method("GET")
     * @Template("AppBundle:Frontend:quotationRequest.html.twig")
     */
    public function newQRRequestAction()
    {
        $entity = new QuotationRequest();
        $form = $this->createQRForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
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
