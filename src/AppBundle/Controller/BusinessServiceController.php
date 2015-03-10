<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\BusinessService;
use AppBundle\Form\BusinessServiceType;

/**
 * BusinessService controller.
 *
 * @Route("/admin/service")
 */
class BusinessServiceController extends Controller
{

    /**
     * Lists all BusinessService entities.
     *
     * @Route("/", name="admin_service")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:BusinessService')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new BusinessService entity.
     *
     * @Route("/", name="admin_service_create")
     * @Method("POST")
     * @Template("AppBundle:BusinessService:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new BusinessService();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_service'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a BusinessService entity.
     *
     * @param BusinessService $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(BusinessService $entity)
    {
        $form = $this->createForm(new BusinessServiceType(), $entity, array(
            'action' => $this->generateUrl('admin_service_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new BusinessService entity.
     *
     * @Route("/new", name="admin_service_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new BusinessService();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a BusinessService entity.
     *
     * @Route("/{id}", name="admin_service_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:BusinessService')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BusinessService entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to delete a BusinessService entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_service_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer'))
            ->getForm();
    }

    /**
     * Displays a form to edit an existing BusinessService entity.
     *
     * @Route("/{id}/edit", name="admin_service_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:BusinessService')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BusinessService entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a BusinessService entity.
    *
    * @param BusinessService $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(BusinessService $entity)
    {
        $form = $this->createForm(new BusinessServiceType(), $entity, array(
            'action' => $this->generateUrl('admin_service_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }

    /**
     * Edits an existing BusinessService entity.
     *
     * @Route("/{id}", name="admin_service_update")
     * @Method("PUT")
     * @Template("AppBundle:BusinessService:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:BusinessService')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BusinessService entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_service_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a BusinessService entity.
     *
     * @Route("/{id}", name="admin_service_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:BusinessService')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BusinessService entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_service'));
    }

    public function enabledBusinessServicesAction()
    {
        // get list of business services object
        $em = $this->get('doctrine.orm.entity_manager');
        $repository = $em->getRepository('AppBundle\Entity\BusinessService');
        $businessServices = $repository->findEnabled();

        return $this->render(
            'AppBundle:FrontendLayout:enabled_bservices_list.html.twig',
            array('businessServices' => $businessServices)
        );
    }
}
