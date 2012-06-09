<?php

namespace INCES\ComedorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use INCES\ComedorBundle\Entity\Menu;
use INCES\ComedorBundle\Form\MenuType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Menu controller.
 *
 */
class MenuController extends Controller
{

    public function _indexAction($query, $field = null, $attr = null){

        $em = $this->get('doctrine.orm.entity_manager');
        $dql = $em->createQueryBuilder();
        if (is_null($field))
            if(!$query || $query == '*')
                $dql->add('select', 'a')
                ->add('from', 'INCESComedorBundle:Menu a');
            else
                $dql = "SELECT a FROM INCES\ComedorBundle\Entity\Menu a WHERE " . $query;
        elseif ($attr == '1')
            $dql->add('select', 'a')
            ->add('from', 'INCESComedorBundle:Menu a')
            ->add('orderBy', 'a.'.$field.' ASC');
        else
            $dql->add('select', 'a')
            ->add('from', 'INCESComedorBundle:Menu a')
            ->add('orderBy', 'a.'.$field.' DESC');

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
            $res .= " (a.seco LIKE '%" . $value . "%'";
            $res .= " OR a.sopa LIKE '%" . $value . "%'";
            $res .= " OR a.salado LIKE '%" . $value . "%'";
            $res .= " OR a.jugo LIKE '%" . $value . "%'";
            $res .= " OR a.ensalada LIKE '%" . $value . "%'";
            $res .= " OR a.postre LIKE '%" . $value . "%' ) AND";
            /*
            $res .= " OR a.postre LIKE '%" . $value . "%'";
            $res .= " OR YEAR(a.dia)  = " . $value;
            $res .= " OR MONTH(a.dia) = " . $value;
            $res .= " OR DAY(a.dia)   = " . $value . " ) AND";
             */
        }
        $res = substr_replace($res ,"",-4);
        return $res;
    }

    /*
     * Search Action dos
     */
    public function searchAction(){
        $request = $this->get('request');
        $query   = $request->request->get('query');

        if (!$query) {
            $field      = $request->request->get('field');
            $attr       = $request->request->get('attr');
            $pagination = $this->_indexAction($query, $field, $attr);
            return $this->render('INCESComedorBundle:Menu:_index.html.twig', array(
                'pagination' => $pagination
                ,'query' => $query
                ,'field' => $field
                ,'attr'  => $attr
            ));
        }else{
            if ($request->isXmlHttpRequest()){
                if ('*' == $query){
                    print_r("*");
                    $query = '';
                    $field = $request->request->get('field');
                    $attr  = $request->request->get('attr');
                    $pagination = $this->_indexAction($query, $field, $attr);
                    return $this->render('INCESComedorBundle:Menu:_index.html.twig', array(
                        'pagination' => $pagination
                        ,'query' => $query
                        ,'field' => $field
                        ,'attr'  => $attr
                    ));
                }

                $query = substr_replace($query ,"",-1);
                $_query = $this->params($query);
                $pagination = $this->_indexAction($_query);
                return $this->render('INCESComedorBundle:Menu:_list.html.twig', array(
                    'pagination'  => $pagination
                    ,'query'      => $query
                ));
            }
        }
    }
    /**
     * Search for Menus.
     *
     */
/*
    public function searchAction(){
        $search = $this->get('ewz_search.lucene');

        $request = $this->get('request');
        $query   = $request->request->get('query');
        if (!$query) {
            print_r("no query");
            $field      = $request->request->get('field');
            $attr       = $request->request->get('attr');
            $pagination = $this->_indexAction($query, $field, $attr);
            return $this->render('INCESComedorBundle:Menu:_index.html.twig', array(
                'pagination' => $pagination
                ,'query' => $query
                ,'field' => $field
                ,'attr'  => $attr
            ));
        }else{
            if ($request->isXmlHttpRequest()){
                if ('*' == $query){
                    print_r("*");
                    $field = $request->request->get('field');
                    $attr  = $request->request->get('attr');
                    $pagination = $this->_indexAction($query, $field, $attr);
                    return $this->render('INCESComedorBundle:Menu:_index.html.twig', array(
                        'pagination' => $pagination
                        ,'query' => $query
                        ,'field' => $field
                        ,'attr'  => $attr
                    ));

                }

                //$query = $this->cleanParam($query);
                //$query = '2012';
                //$term  = new \Zend\Search\Lucene\Index\Term($query.'*','dia');
                //$query = new \Zend\Search\Lucene\Search\Query\Wildcard($term);
                //print_r($query);
                $menus = $search->find($query);
                //print_r($menus);
                return $this->render('INCESComedorBundle:Menu:_list.html.twig', array(
                    'menus'  => $menus
                    ,'query' => 'hola'
                ));
            }
        }
    }
*/

    /**
     * Lists all Menu entities.
     *
     */
    public function indexAction($query = '')
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $dql = $em->createQueryBuilder();
            $dql->add('select', 'a')
            ->add('from', 'INCESComedorBundle:Menu a');
        $qry = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $qry,
            $this->get('request')->query->get('page', 1),//page number
            2//limit per page
        );
        return $this->render('INCESComedorBundle:Menu:index.html.twig', array(
             'pagination' => $pagination
            ,'query' => $query
        ));
    }

    /**
     * Finds and displays a Menu entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INCESComedorBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('INCESComedorBundle:Menu:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Menu entity.
     *
     */
    public function newAction()
    {
        $entity = new Menu();
        $form   = $this->createForm(new MenuType(), $entity);

        return $this->render('INCESComedorBundle:Menu:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Menu entity.
     *
     */
    public function createAction()
    {
        $entity  = new Menu();
        $request = $this->getRequest();
        $form    = $this->createForm(new MenuType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            $route = $request->getBaseUrl();
            return new Response($route.'/menu/'.$entity->getId().'/show');
        }

        return $this->render('INCESComedorBundle:Menu:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Menu entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INCESComedorBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        $editForm = $this->createForm(new MenuType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('INCESComedorBundle:Menu:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Menu entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INCESComedorBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        $editForm   = $this->createForm(new MenuType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $route = $request->getBaseUrl();
            return new Response($route.'/menu/');
            //return new Response($route.'/menu/'.$entity->getId().'/show');
            //return $this->redirect($this->generateUrl('menu_edit', array('id' => $id)));
        }

        return $this->render('INCESComedorBundle:Menu:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Menu entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('INCESComedorBundle:Menu')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Menu entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        $route = $request->getBaseUrl();
        return new Response($route.'/menu');
        //return $this->redirect($this->generateUrl('menu'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /*
     * Mostrar el menu del dia
     */
    public function todayAction(){

        //$em = $this->get('doctrine.orm.entity_manager');
/*
        $config = new \Doctrine\DBAL\Configuration();
        //..
        $params = array(
            'dbname'   => 'ComedorINCES',
            'user'     => 'root',
            'password' => 'admin',
            'host'     => 'localhost',
            'driver'   => 'pdo_mysql',
        );

        $conn = DriverManager::getConnection($params, $config);

        $sql = "SELECT * FROM Menu WHERE DATE_FORMAT(dia, '%d/%m/%Y') = :date";
        $dql = $conn->prepare($sql);
        $dql ->bindValue("date", $date);
        $sql ->execute();
*/

        $now = new \DateTime;
        //print_r($now);

        $em = $this->get('doctrine.orm.entity_manager');
        $dql = $em->createQueryBuilder();
            $dql->add('select', 'a')
            ->add('from', 'INCESComedorBundle:Menu a')
            ->add('where', "a.dia = '".$now->format("Y-m-d 00:00:00")."'");

        $qry = $em->createQuery($dql);
        $dql = $qry->getResult();
        return $this->render('INCESComedorBundle:Menu:today.html.twig', array(
             'menusToday' => $dql
        ));
    }

    /*
     * Clean the parameter to remove / -
     */
    public function cleanParam($param){
        $res = str_replace("/","", $param);
        $res = str_replace("-","", $param);
        return $res;
    }
}
