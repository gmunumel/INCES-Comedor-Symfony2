<?php

namespace INCES\ComedorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INCES\ComedorBundle\Entity\Usuario;
use INCES\ComedorBundle\Form\UsuarioType;
use Symfony\Component\HttpFoundation\Response;
use EWZ\Bundle\SearchBundle\Lucene\Document;
use EWZ\Bundle\SearchBundle\Lucene\Field;
use EWZ\Bundle\SearchBundle\Lucene\LuceneSearch;
use Zend\Search\Search\Lucene\Search\Query\MultiTerm;

/**
 * Usuario controller.
 *
 * @Route("/usuario")
 */
class UsuarioController extends Controller
{

    public function updateLuceneIndex($form)
    {
        $search = $this->get('ewz_search.lucene');
        //$index = Menu::getLuceneIndex();

        // remove existing entries
        /*
        foreach ($index->find('id:'.$this->getId()) as $hit)
        {
            $index->delete($hit->id);
        }
        */
        //$query = new MultiTerm();

        //$doc = new Zend_Search_Lucene_Document();
        $doc = new Document();

        // store job primary key to identify it in the search results
        //print_r($form->getData()->getId());
        //print_r($form->getData()->getDia()->format('d-m-Y'));
        //print_r($form->getData()->getCedula());
        $doc->addField(Field::keyword('key', $form->getData()->getId()));

        // index job fields
        $doc->addField(Field::text('cedula', $form->getData()->getCedula()));
        //$doc->addField(Field::text('nombre', $form->getData()->getNombre()));
        //$doc->addField(Field::text('apellido', $form->getData()->getApellido()));
        //$doc->addField(Field::text('ncarnet', $form->getData()->getNcarnet()));
        //$doc->addField(Field::text('correo', $form->getData()->getCorreo()));
        //$doc->addField(Field::text('dia',  $form->getData()->getDia()->format('d-m-Y')));

        // add job to the index
        $search->addDocument($doc);
        $search->updateIndex();
        //$index->addDocument($doc);
        //$index->commit();
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
     * Displays a form to create a new Usuario entity.
     *
     * @Route("/new", name="usuario_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Usuario();
        $form   = $this->createForm(new UsuarioType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Usuario entity.
     *
     * @Route("/create", name="usuario_create")
     * @Method("post")
     * @Template("INCESComedorBundle:Usuario:new.html.twig")
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

            // Update Index Lucene
            $this->updateLuceneIndex($form);

            return $this->redirect($this->generateUrl('usuario_show', array('id' => $entity->getId())));

        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
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

            return $this->redirect($this->generateUrl('usuario_edit', array('id' => $id)));
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

        return $this->redirect($this->generateUrl('usuario'));
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
                $dql->add('select', 'a')
                ->add('from', 'INCESComedorBundle:Usuario a');
            else
                //$query = "(a.cedula LIKE '%17387134%' OR a.nombre LIKE '%17387134%' OR a.apellido LIKE '%17387134%' OR a.ncarnet LIKE '%17387134%' OR a.correo LIKE '%17387134%')";
                //$conn = $this->get('database_connection');
                $dql = "SELECT a FROM INCES\ComedorBundle\Entity\Usuario a WHERE " . $query;

        elseif ($attr == '1')
            $dql->add('select', 'a')
            ->add('from', 'INCESComedorBundle:Usuario a')
            ->add('orderBy', 'a.'.$field.' ASC');
        else
            $dql->add('select', 'a')
            ->add('from', 'INCESComedorBundle:Usuario a')
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
            $res .= " (a.cedula LIKE '%" . $value . "%'";
            $res .= " OR a.nombre LIKE '%" . $value . "%'";
            $res .= " OR a.apellido LIKE '%" . $value . "%'";
            $res .= " OR a.ncarnet LIKE '%" . $value . "%'";
            $res .= " OR a.correo LIKE '%" . $value . "%') AND";
        }
        $res = substr_replace($res ,"",-4);
        return $res;
    }

    /*
     *  Search by Cedula
     */
    public function searchAction(){

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
                //$query = 'gabo';
                $query = substr_replace($query ,"",-1);
                $_query = $this->params($query);
                $pagination = $this->_indexAction($_query);
                //print_r($query);
                //$search = $this->get('ewz_search.lucene');
                //$pagination = $search->find($query);
                //$pagination = $search->find($query);
                //$term  = new \Zend\Search\Lucene\Index\Term($query);
                //$query = new \Zend\Search\Lucene\Search\Query\Wildcard($term);
                //$menus = array();
                //$pagination = $search->find($query);
                //$pagination = $query;
                //$pagination = array();
                //print_r($pagination);
                return $this->render('INCESComedorBundle:Usuario:_list.html.twig', array(
                    'pagination'  => $pagination
                    ,'query'      => $query
                ));
            }
        }
    }
}
