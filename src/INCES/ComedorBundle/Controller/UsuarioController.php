<?php

namespace INCES\ComedorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INCES\ComedorBundle\Entity\Usuario;
use INCES\ComedorBundle\Form\UsuarioType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Usuario controller.
 *
 * @Route("/usuario")
 */
class UsuarioController extends Controller
{
    /**
     * Lists all Usuario entities.
     *
     * @Route("/", name="usuario")
     * @Template()
     */
    public function indexFacturarAction($query = '')
    {
        /*
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('INCESComedorBundle:Usuario')->findAll();

        return array('entities' => $entities);
         */
        $em = $this->get('doctrine.orm.entity_manager');
        $dql = $em->createQueryBuilder();
            $dql->add('select', 'a')
            ->add('from', 'INCESComedorBundle:Usuario a');
        $qry = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $qry,
            $this->get('request')->query->get('page', 1),//page number
            2//limit per page
        );
        return $this->render('INCESComedorBundle:Usuario:index_facturar.html.twig', array(
             'pagination' => $pagination
            ,'query' => $query
        ));
    }

    /**
     * Lists all Usuario entities.
     *
     * @Route("/", name="usuario")
     * @Template()
     */
    public function indexAction($query = '')
    {
        /*
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('INCESComedorBundle:Usuario')->findAll();

        return array('entities' => $entities);
         */
        $em = $this->get('doctrine.orm.entity_manager');
        $dql = $em->createQueryBuilder();
            $dql->add('select', 'a')
            ->add('from', 'INCESComedorBundle:Usuario a');
        $qry = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $qry,
            $this->get('request')->query->get('page', 1),//page number
            2//limit per page
        );
        return $this->render('INCESComedorBundle:Usuario:index.html.twig', array(
             'pagination' => $pagination
            ,'query' => $query
        ));
    }

    /**
     * Finds and displays a Usuario entity.
     *
     * @Route("/{id}/show", name="usuario_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INCESComedorBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Finds and displays a Usuario entity.
     *
     */
    public function showFacturarAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INCESComedorBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('INCESComedorBundle:Usuario:show_facturar.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new Usuario entity.
     *
     */
    public function newAction()
    {
        $entity = new Usuario();
        $form   = $this->createForm(new UsuarioType(), $entity);

        return $this->render('INCESComedorBundle:Usuario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Usuario entity.
     *
     */
    public function createAction()
    {
        $entity  = new Usuario();
        $request = $this->getRequest();
        $form    = $this->createForm(new UsuarioType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            $dir = dirname(__FILE__).'/../../../../web/img/uploaded/';

            try{
                $file = $form->getData()->getImage()->move($dir);
            }catch(\ErrorException $e){
                continue;
            }

            return $this->redirect($this->generateUrl('usuario_show', array('id' => $entity->getId())));
            //$route = $request->getBaseUrl();
            //return new Response($route.'/usuario/'.$entity->getId().'/show');
        }

        return $this->render('INCESComedorBundle:Usuario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     * @Route("/{id}/edit", name="usuario_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INCESComedorBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $editForm = $this->createForm(new UsuarioType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Usuario entity.
     *
     * @Route("/{id}/update", name="usuario_update")
     * @Method("post")
     * @Template("INCESComedorBundle:Usuario:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INCESComedorBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $editForm   = $this->createForm(new UsuarioType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            //return $this->redirect($this->generateUrl('usuario_edit', array('id' => $id)));
            $route = $request->getBaseUrl();
            return new Response($route.'/usuario/');
            //return new Response($route.'/usuario/'.$entity->getId().'/edit');
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Usuario entity.
     *
     * @Route("/{id}/delete", name="usuario_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('INCESComedorBundle:Usuario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Usuario entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        $route = $request->getBaseUrl();
        return new Response($route.'/usuario');
        //return $this->redirect($this->generateUrl('usuario'));
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
        $dql = $em->createQueryBuilder();
        if (is_null($field))
            if(!$query || $query == '*')
                $dql->add('select', 'u')
                ->add('from', 'INCESComedorBundle:Usuario u');
            else
                $dql = "SELECT u FROM INCES\ComedorBundle\Entity\Usuario u WHERE " . $query;

        elseif ($attr == '1')
            $dql->add('select', 'u')
            ->add('from', 'INCESComedorBundle:Usuario u')
            ->add('orderBy', 'u.'.$field.' ASC');
        else
            $dql->add('select', 'u')
            ->add('from', 'INCESComedorBundle:Usuario u')
            ->add('orderBy', 'u.'.$field.' DESC');

        $qry = $em->createQuery($dql);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $qry,
            $this->get('request')->query->get('page', 1),//page number
            2//limit per page
        );
        return $pagination;
    }

    public function _indexActionFacturar($query, $field = null, $attr = null){

        $em = $this->get('doctrine.orm.entity_manager');
        $dql = $em->createQueryBuilder();
        if (is_null($field))
            if(!$query || $query == '*')
                $dql->select('u', 'r')
                    ->from('INCESComedorBundle:Usuario', 'u')
                    ->from('INCESComedorBundle:Rol ', 'r')
                    ->where('r.id = u.rol');
            else
                $dql = "SELECT u, r FROM INCES\ComedorBundle\Entity\Usuario u JOIN u.rol r WHERE " . $query;

        elseif ($attr == '1')
            if($field != 'rol')
                $dql->select('u', 'r')
                    ->from('INCESComedorBundle:Usuario', 'u')
                    ->join('u.rol', 'r')
                    ->where('r.id = u.rol')
                    ->orderBy('u.'.$field, 'ASC');
            else
                $dql->select('u', 'r')
                    ->from('INCESComedorBundle:Usuario', 'u')
                    ->join('u.rol', 'r')
                    ->where('r.id = u.rol')
                    ->orderBy('r.nombre', 'ASC');
        else
            if($field != 'rol')
                $dql->select('u', 'r')
                    ->from('INCESComedorBundle:Usuario', 'u')
                    ->join('u.rol', 'r')
                    ->where('r.id = u.rol')
                    ->orderBy('u.'.$field, 'DESC');
            else
                $dql->select('u', 'r')
                    ->from('INCESComedorBundle:Usuario', 'u')
                    ->join('u.rol', 'r')
                    ->where('r.id = u.rol')
                    ->orderBy('r.nombre', 'DESC');

        $qry = $em->createQuery($dql);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $qry,
            $this->get('request')->query->get('page', 1),//page number
            2//limit per page
        );
        return $pagination;
    }

    public function params($params){
        $params = trim($params);
        $explote = explode(" ", $params);
        $res = "";

        foreach($explote as $value){
            $res .= " (u.cedula like '%" . $value . "%'";
            $res .= " or u.nombre like '%" . $value . "%'";
            $res .= " or u.apellido like '%" . $value . "%'";
            $res .= " or u.ncarnet like '%" . $value . "%'";
            $res .= " or u.correo like '%" . $value . "%') AND";
        }
        $res = substr_replace($res ,"",-4);
        return $res;
    }

    public function paramsFacturar($params){
        $params = trim($params);
        $explote = explode(" ", $params);
        $res = "";

        foreach($explote as $value){
            $res .= " (u.cedula like '%" . $value . "%'";
            $res .= " or u.nombre like '%" . $value . "%'";
            $res .= " or u.apellido like '%" . $value . "%'";
            $res .= " or u.ncarnet like '%" . $value . "%'";
            $res .= " or u.correo like '%" . $value . "%'";
            $res .= " or r.nombre like '%" . $value . "%') AND";
        }
        $res = substr_replace($res ,"",-4);
        return $res;
    }

    /*
     *  Search by Cedula
     */
    public function searchAction(){

        /*
        $request = $this->get('request');
        $entity = "";
        $query = "";

        if ($request->getMethod() == 'POST') {
            //$request = $this->get('request');
            $query   = $request->request->get('query');

            //print_r($query);
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('INCESComedorBundle:Usuario')->findBy(array('cedula'=>$query));


            //if (!$entity) {
            //    throw $this->createNotFoundException('Unable to find Usuario entity.');
            //}

            return $this->render('INCESComedorBundle:Usuario:search_show.html.twig', array(
                  'users' => $entity
                 ,'query' => $query
            ));
        }

        return $this->render('INCESComedorBundle:Usuario:search.html.twig', array(
              'users' => $entity
             ,'query' => $query
        ));
        */
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->get('request');
        $query   = $request->request->get('query');

        if (!$query) {
            $entity = $em->getRepository('INCESComedorBundle:Usuario')->findBy(array('cedula'=>$query));
            return $this->render('INCESComedorBundle:Usuario:_search_show.html.twig', array(
                 'query' => $query
                ,'users' => $entity
            ));
        }else{
            if ($request->isXmlHttpRequest()){
                //if ('*' == $query){
                    //$query = '';
                    $entity = $em->getRepository('INCESComedorBundle:Usuario')->findBy(array('cedula'=>$query));
                    return $this->render('INCESComedorBundle:Usuario:_search_show.html.twig', array(
                         'query' => $query
                        ,'users' => $entity
                    ));
                //}
            }
        }

    }

    /*
     *  Search Ajax
     */
    public function searchAjaxAction(){
        $request = $this->get('request');
        $query   = $request->request->get('query');

        if (!$query) {
            $field      = $request->request->get('field');
            $attr       = $request->request->get('attr');
            $pagination = $this->_indexAction($query, $field, $attr);
            return $this->render('INCESComedorBundle:Usuario:_index.html.twig', array(
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
                    return $this->render('INCESComedorBundle:Usuario:_index.html.twig', array(
                        'pagination' => $pagination
                        ,'query' => $query
                        ,'field' => $field
                        ,'attr'  => $attr
                    ));
                }
                $query = substr_replace($query ,"",-1);
                $_query = $this->params($query);
                $pagination = $this->_indexAction($_query);
                return $this->render('INCESComedorBundle:Usuario:_list.html.twig', array(
                    'pagination'  => $pagination
                    ,'query'      => $query
                ));
            }
        }
    }

    /*
     *  Search Ajax Facturar
     */
    public function searchAjaxFacturarAction(){
        $request = $this->get('request');
        $query   = $request->request->get('query');

        if (!$query) {
            $field      = $request->request->get('field');
            $attr       = $request->request->get('attr');
            $pagination = $this->_indexActionFacturar($query, $field, $attr);
            return $this->render('INCESComedorBundle:Usuario:_index_facturar.html.twig', array(
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
                    $pagination = $this->_indexActionFacturar($query, $field, $attr);
                    return $this->render('INCESComedorBundle:Usuario:_index_facturar.html.twig', array(
                        'pagination' => $pagination
                        ,'query' => $query
                        ,'field' => $field
                        ,'attr'  => $attr
                    ));
                }
                $query = substr_replace($query ,"",-1);
                $_query = $this->paramsFacturar($query);
                $pagination = $this->_indexActionFacturar($_query);
                return $this->render('INCESComedorBundle:Usuario:_list_facturar.html.twig', array(
                    'pagination'  => $pagination
                    ,'query'      => $query
                ));
            }
        }
    }

}
