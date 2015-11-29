<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\ImageSite;
use AppBundle\Form\ImageSiteType;
use AppBundle\EventListener\FileManagementException;

/**
 * ImageSite controller.
 *
 * @Route("/admin/photos")
 */
class ImageSiteController extends Controller
{

    /**
     * Lists all ImageSite entities.
     *
     * @Route("/", name="admin_photos")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:ImageSite')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new ImageSite entity.
     *
     * @Route("/", name="admin_photos_create")
     * @Method("POST")
     * @Template("AppBundle:ImageSite:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ImageSite();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_photos_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a ImageSite entity.
     *
     * @param ImageSite $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ImageSite $entity)
    {
        $form = $this->createForm(new ImageSiteType(), $entity, array(
            'action' => $this->generateUrl('admin_photos_create'),
            'method' => 'POST',
            'em' => $this->getDoctrine()->getManager()
        ));

        $form->add('submit', 'submit', array('label' => 'Ajouter'));

        return $form;
    }

    /**
     * Displays a form to create a new ImageSite entity.
     *
     * @Route("/new", name="admin_photos_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ImageSite();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a ImageSite entity.
     *
     * @Route("/{id}", name="admin_photos_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ImageSite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ImageSite entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to delete a ImageSite entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_photos_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer'))
            ->getForm();
    }

    /**
     * Displays a form to edit an existing ImageSite entity.
     *
     * @Route("/{id}/edit", name="admin_photos_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:ImageSite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Enregistrement introuvable.');
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
     * Creates a form to edit a ImageSite entity.
     *
     * @param ImageSite $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(ImageSite $entity)
    {
        $form = $this->createForm(new ImageSiteType(), $entity, array(
            'action' => $this->generateUrl('admin_photos_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'em' => $this->getDoctrine()->getManager()
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }

    /**
     * Edits an existing ImageSite entity.
     *
     * @Route("/{id}", name="admin_photos_update")
     * @Method("PUT")
     * @Template("AppBundle:ImageSite:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ImageSite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ImageSite entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_photos_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a ImageSite entity.
     *
     * @Route("/{id}", name="admin_photos_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:ImageSite')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ImageSite entity.');
            }

            try {
                $em->remove($entity);
                $em->flush();
            } catch (FileManagementException $fme) {
                return $this->render(
                    'AppBundle:Admin:message.html.twig', array(
                        'message' => 'L\'enregistrement a bien été supprimé mais le fichier image correspondant n\'a pu être trouvé.',
                        'level' => 'warning'
                    )
                );
            }
        }

        return $this->redirect($this->generateUrl('admin_photos'));
    }
}
