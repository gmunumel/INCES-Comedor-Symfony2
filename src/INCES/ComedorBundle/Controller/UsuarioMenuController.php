<?php

namespace INCES\ComedorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INCES\ComedorBundle\Entity\UsuarioMenu;
use INCES\ComedorBundle\Form\UsuarioMenuType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


/**
 * UsuarioMenu controller.
 *
 */
class UsuarioMenuController extends Controller
{
    /**
     * Lists all UsuarioMenu entities.
     *
     */
    /*
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('INCESComedorBundle:UsuarioMenu')->findAll();

        //return array('entities' => $entities);
        return $this->render('INCESComedorBundle:UsuarioMenu:index.html.twig', array(
             'entities' => $entities
        ));
    }
     */

    /**
     * Finds and displays a UsuarioMenu entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INCESComedorBundle:UsuarioMenu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UsuarioMenu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('INCESComedorBundle:UsuarioMenu:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new UsuarioMenu entity.
     *
     */
    public function newAction()
    {
        $entity = new UsuarioMenu();
        $form   = $this->createForm(new UsuarioMenuType(), $entity);

        return $this->render('INCESComedorBundle:UsuarioMenu:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new UsuarioMenu entity.
     *
     */
    public function createAction()
    {
        $entity  = new UsuarioMenu();
        $request = $this->getRequest();
        $form    = $this->createForm(new UsuarioMenuType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('usuariomenu_show', array('id' => $entity->getId())));

        }

        return $this->render('INCESComedorBundle:UsuarioMenu:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing UsuarioMenu entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INCESComedorBundle:UsuarioMenu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UsuarioMenu entity.');
        }

        $editForm = $this->createForm(new UsuarioMenuType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('INCESComedorBundle:UsuarioMenu:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing UsuarioMenu entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INCESComedorBundle:UsuarioMenu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UsuarioMenu entity.');
        }

        $editForm   = $this->createForm(new UsuarioMenuType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            //return $this->redirect($this->generateUrl('usuariomenu_edit', array('id' => $id)));
            $route = $request->getBaseUrl();
            return new Response($route.'/#!/usuariomenu/'.$entity->getId().'/show');
        }

        return $this->render('INCESComedorBundle:UsuarioMenu:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a UsuarioMenu entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('INCESComedorBundle:UsuarioMenu')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UsuarioMenu entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        $route = $request->getBaseUrl();
        return new Response($route.'/#!/usuariomenu');
        //return $this->redirect($this->generateUrl('usuariomenu'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    public function _indexAction($query, $field = null, $attr = null){

        $em = $this->get('doctrine.orm.entity_manager');
        $emConfig = $em->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        $emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');

        $dql = $em->createQueryBuilder();
        if (is_null($field))
            if(!$query || $query == '*')
                $dql->add('select', 'um')
                ->add('from', 'INCESComedorBundle:UsuarioMenu um');
            else
                $dql = "SELECT um FROM INCES\ComedorBundle\Entity\UsuarioMenu um WHERE " . $query;

        /* TODO arreglar para filtrar por usuario y menu */
        elseif ($attr == '1')
            $dql->add('select', 'um')
            ->add('from', 'INCESComedorBundle:UsuarioMenu um')
            ->add('orderBy', 'um.'.$field.' ASC');
        else
            $dql->add('select', 'um')
            ->add('from', 'INCESComedorBundle:UsuarioMenu um')
            ->add('orderBy', 'um.'.$field.' DESC');

        $qry = $em->createQuery($dql);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $qry,
            $this->get('request')->query->get('page', 1),//page number
            $this->container->getParameter('RESULTS_PER_PAGE')//limit per page
        );
        return $pagination;
    }

    /*
     * Debe ser de la forma *\/*\/* - 20/01/2002
     */
    public function setDate($val){
        $res = "";
        $params = trim($val);
        $explote = explode("/", $params);

        if(count($explote) != 3) return $res;
        if(!is_numeric($explote[0]))
            if($explote[0] != "*")
                return $res;
        if(!is_numeric($explote[1]))
            if($explote[1] != "*")
                return $res;
        if(!is_numeric($explote[2]))
            if($explote[2] != "*")
                return $res;
        if($explote[0] != '*')
            $res .= " (DAY(um.dia) = " . $explote[0] . ") AND";
        if($explote[1] != '*')
            $res .= " (MONTH(um.dia) = " . $explote[1] . ") AND";
        if($explote[2] != '*')
            $res .= " (YEAR(um.dia) = " . $explote[2] . ") AND";
        return $res;
    }

    public function params($params){
        $params = trim($params);
        $explote = explode(" ", $params);
        $res = "";

        foreach($explote as $value){
            $res .= $this->setDate($value);
        }
        if(strlen($res) > 3)
            $res = substr_replace($res ,"",-4);
        return $res;
    }

    /*
     *  Search Ajax
     */
    public function searchAjaxAction(){
        $request = $this->get('request');
        $query = $request->request->get('query');
        if(is_null($query))
            $query   = $request->query->get('query')."*";

        if (!$query) {
            $field      = $request->request->get('field');
            $attr       = $request->request->get('attr');
            $pagination = $this->_indexAction($query, $field, $attr);
            return $this->render('INCESComedorBundle:UsuarioMenu:_index.html.twig', array(
                'pagination' => $pagination
                ,'query' => $query
                ,'field' => $field
                ,'attr'  => $attr
            ));
        }else{
            if ($request->isXmlHttpRequest()){
                if ('*' == $query){
                    $query = '';
                    $field = $request->request->get('field');
                    $attr  = $request->request->get('attr');
                    $pagination = $this->_indexAction($query, $field, $attr);
                    return $this->render('INCESComedorBundle:UsuarioMenu:_index.html.twig', array(
                        'pagination' => $pagination
                        ,'query' => $query
                        ,'field' => $field
                        ,'attr'  => $attr
                    ));
                }
                $query = substr_replace($query ,"",-1);
                $_query = $this->params($query);
                $pagination = $this->_indexAction($_query);
                return $this->render('INCESComedorBundle:UsuarioMenu:_list.html.twig', array(
                    'pagination'  => $pagination
                    ,'query'      => $query
                ));
            }
        }
    }
}
