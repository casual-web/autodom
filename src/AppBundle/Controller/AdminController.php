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


    /**
     * @Route("/image-upload", name="admin_image-upload")
     * @Template()
     */
    public function imageSiteUploadAction(Request $request)
    {
        $document = new ImageSite();
        $em = $this->getDoctrine()->getManager();
        $bsRepo = $em->getRepository('AppBundle:BusinessService');
        $form = $this->createFormBuilder($document)
            ->add('name')
            ->add('file', 'file')
            ->add('carouselOrder')
            ->add('location')
            ->add('damageType')
            ->add('vehicleElement')
            ->add('businessServiceRef', 'choice', [
                'label' => 'Catégorie du service',
                'choices' => $bsRepo->getChoices()
            ])
            ->add('submit', 'submit', array('label' => 'Enregistrer'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($document);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_tableaudebord'));
        }

        return array('form' => $form->createView());
    }



}
