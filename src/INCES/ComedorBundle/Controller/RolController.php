<?php

namespace INCES\ComedorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INCES\ComedorBundle\Entity\Rol;
use INCES\ComedorBundle\Form\RolType;

/**
 * Rol controller.
 *
 */
class RolController extends Controller
{
    /**
     * Lists all Rol entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('INCESComedorBundle:Rol')->findAll();

        //return array('entities' => $entities);
        return $this->render('INCESComedorBundle:Rol:index.html.twig', array(
             'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Rol entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INCESComedorBundle:Rol')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Rol entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('INCESComedorBundle:Rol:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new Rol entity.
     *
     */
    public function newAction()
    {
        $entity = new Rol();
        $form   = $this->createForm(new RolType(), $entity);

        return $this->render('INCESComedorBundle:Rol:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Rol entity.
     *
     */
    public function createAction()
    {
        $entity  = new Rol();
        $request = $this->getRequest();
        $form    = $this->createForm(new RolType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            //return $this->redirect($this->generateUrl('rol_show', array('id' => $entity->getId())));
            $route = $request->getBaseUrl();
            return new Response($route.'/#!/rol/'.$entity->getId().'/show');
        }

        return $this->render('INCESComedorBundle:Rol:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Rol entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INCESComedorBundle:Rol')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Rol entity.');
        }

        $editForm = $this->createForm(new RolType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('INCESComedorBundle:Rol:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Rol entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INCESComedorBundle:Rol')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Rol entity.');
        }

        $editForm   = $this->createForm(new RolType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            //return $this->redirect($this->generateUrl('rol_edit', array('id' => $id)));
            $route = $request->getBaseUrl();
            return new Response($route.'/#!/rol/'.$entity->getId().'/show');
        }

        return $this->render('INCESComedorBundle:Rol:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Rol entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('INCESComedorBundle:Rol')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Rol entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        $route = $request->getBaseUrl();
        return new Response($route.'/#!/rol');
        //return $this->redirect($this->generateUrl('rol'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
