<?php

namespace INCES\ComedorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use EWZ\Bundle\SearchBundle\Lucene\Document;
use EWZ\Bundle\SearchBundle\Lucene\Field;
use Zend\Search\Search\Lucene\Search\Query\MultiTerm;
use INCES\ComedorBundle\Entity\Menu;
use INCES\ComedorBundle\Form\MenuType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Menu controller.
 *
 */
class MenuController extends Controller
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
        print_r($form->getData()->getId());
        print_r($form->getData()->getDia()->format('d-m-Y'));
        $doc->addField(Field::keyword('key', $form->getData()->getId()));

        // index job fields
        $doc->addField(Field::text('seco', $form->getData()->getSeco()));
        $doc->addField(Field::text('sopa', $form->getData()->getSopa()));
        $doc->addField(Field::text('dia',  $form->getData()->getDia()->format('d-m-Y')));

        // add job to the index
        $search->addDocument($doc);
        $search->updateIndex();
        //$index->addDocument($doc);
        //$index->commit();
    }

    public function _indexAction($query, $field, $attr){

        $em = $this->get('doctrine.orm.entity_manager');
        $dql = $em->createQueryBuilder();
        if (!$field)
            $dql->add('select', 'a')
            ->add('from', 'INCESComedorBundle:Menu a');
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

    /**
     * Search for Menus.
     *
     */
    public function searchAction(){
        $search = $this->get('ewz_search.lucene');

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

                $menus = $search->find($query);
                return $this->render('INCESComedorBundle:Menu:_list.html.twig', array(
                    'menus' => $menus
                    ,'query' => $query
                ));
            }
        }
    }

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

            // Update Index Lucene
            $this->updateLuceneIndex($form);

            return $this->redirect($this->generateUrl('menu_show', array('id' => $entity->getId())));

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

            return $this->redirect($this->generateUrl('menu_edit', array('id' => $id)));
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

        return $this->redirect($this->generateUrl('menu'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

}
