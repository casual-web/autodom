<?php

namespace AppBundle\Controller;

use AppBundle\Entity\QuotationRequestServiceRelation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\QuotationRequest;
use AppBundle\Form\QuotationRequestType;

/**
 * QuotationRequest controller.
 *
 * @Route("/admin/devis")
 */
class QuotationRequestController extends Controller
{

    /**
     * Lists all QuotationRequest entities.
     *
     * @Route("/", name="admin_devis")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:QuotationRequest')->findBy(array(), array('created' => 'DESC'));

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to create a new QuotationRequest entity.
     *
     * @Route("/carte", name="admin_devis_map")
     * @Method("GET")
     * @Template("AppBundle:QuotationRequest:map.html.twig")
     */
    public function showMapAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:QuotationRequest')->findAllGeoLocated();

        return array(
            'entities' => $entities,
        );
    }



    /**
     * Creates a new QuotationRequest entity.
     *
     * @Route("/", name="admin_devis_create")
     * @Method("POST")
     * @Template("AppBundle:QuotationRequest:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new QuotationRequest();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.quotation_request_manager');
            $entity->setQuotationRequestServiceRelations($form->get('quotationRequestServiceRelations')->getData());
            $em->persistAndFlush($entity);

            return $this->redirect($this->generateUrl('admin_devis', array('id' => $entity->getId())));
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
    private function createCreateForm(QuotationRequest $entity)
    {
        $qr = new QuotationRequestType();
        $form = $this->createForm($qr, $entity, array(
            'action' => $this->generateUrl('admin_devis_create'),
            'method' => 'POST',
            'em' => $this->getDoctrine()->getManager(),
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new QuotationRequest entity.
     *
     * @Route("/new", name="admin_devis_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new QuotationRequest();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a QuotationRequest entity.
     *
     * @Route("/{id}", name="admin_devis_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:QuotationRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find QuotationRequest entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }


    /**
     * Creates a form to delete a QuotationRequest entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_devis_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer'))
            ->getForm();
    }

    /**
     * Displays a form to edit an existing QuotationRequest entity.
     *
     * @Route("/{id}/edit", name="admin_devis_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:QuotationRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find QuotationRequest entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a QuotationRequest entity.
     *
     * @param QuotationRequest $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(QuotationRequest $entity)
    {
        $qr = new QuotationRequestType();
        $form = $this->createForm($qr, $entity, array(
            'action' => $this->generateUrl('admin_devis_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'em' => $this->getDoctrine()->getManager(),
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }

    /**
     * Edits an existing QuotationRequest entity.
     *
     * @Route("/{id}", name="admin_devis_update")
     * @Method("PUT")
     * @Template("AppBundle:QuotationRequest:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:QuotationRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de retrouver cet objet dans la base de donnée..');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em = $this->get('doctrine.orm.quotation_request_manager');
            $em->persistAndFlushWithRelations(
                $entity,
                $editForm->get('quotationRequestServiceRelations')->getData());
            return $this->redirect($this->generateUrl('admin_devis_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a QuotationRequest entity.
     *
     * @Route("/{id}", name="admin_devis_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:QuotationRequest')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find QuotationRequest entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_devis'));
    }
}
