<?php

namespace INCES\ComedorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INCES\ComedorBundle\Entity\UserAdmin;
use INCES\ComedorBundle\Form\UserAdminType;
use Symfony\Component\HttpFoundation\Response;

/**
 * UserAdmin controller.
 *
 */
class UserAdminController extends Controller
{
    /**
     * Lists all UserAdmin entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('INCESComedorBundle:UserAdmin')->findAll();

        return $this->render('INCESComedorBundle:UserAdmin:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a UserAdmin entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INCESComedorBundle:UserAdmin')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserAdmin entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('INCESComedorBundle:UserAdmin:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a UserAdmin entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('INCESComedorBundle:UserAdmin')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UserAdmin entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        //return $this->redirect($this->generateUrl('useradmin'));
        $route = $request->getBaseUrl();
        return new Response($route.'/#!/admin');
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
