<?php

namespace INCES\ComedorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INCES\ComedorBundle\Entity\Usuario;
use INCES\ComedorBundle\Form\UsuarioType;
use INCES\ComedorBundle\Form\CargaMasivaType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


/**
 * Usuario controller.
 *
 */
class UsuarioController extends Controller
{
    /*
    public function menuToday(){

        $em = $this->get('doctrine.orm.entity_manager');
        $emConfig = $em->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        $emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');

        // Buscando las personas que ya comieron hoy
        $now = new \DateTime('now');
        $dql = $em->createQueryBuilder();
        $dql->select('m')
            ->from('INCESComedorBundle:Menu','m')
            ->where("YEAR(m.dia) = '".$now->format("Y")."'")
            ->andWhere("MONTH(m.dia) = '".$now->format("m")."'")
            ->andWhere("DAY(m.dia) = '".$now->format("d")."'");
        $qry = $em->createQuery($dql);
        $userMenuTd = $qry->getResult();

        return $userMenuTd;

    }
     */

    /**
     * Lists all Usuario entities.
     *
     */
    /*
    public function indexAction($query = '')
    {
        //$em = $this->getDoctrine()->getEntityManager();

        //$entities = $em->getRepository('INCESComedorBundle:Usuario')->findAll();

        //return array('entities' => $entities);

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
     */

    /**
     * Finds and displays a Usuario entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INCESComedorBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('INCESComedorBundle:Usuario:show.html.twig', array(
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

            if(!is_null($form->getData()->getImage()))
                $form->getData()->getImage()->move($dir);

            //return $this->redirect($this->generateUrl('usuario_show', array('id' => $entity->getId())));
            $route = $request->getBaseUrl();
            return new Response($route.'/#!/usuario/'.$entity->getId().'/show');
        }

        return $this->render('INCESComedorBundle:Usuario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
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

        return $this->render('INCESComedorBundle:Usuario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Usuario entity.
     *
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

            $dir = dirname(__FILE__).'/../../../../web/img/uploaded/';

            if(!is_null($editForm->getData()->getImage()))
                $editForm->getData()->getImage()->move($dir);

            //return $this->redirect($this->generateUrl('usuario_show', array('id' => $id)));
            $route = $request->getBaseUrl();
            //return new Response($route.'/usuario/');
            return new Response($route.'/#!/usuario/'.$entity->getId().'/show');
        }

        return $this->render("INCESComedorBundle:Usuario:edit.html.twig", array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Usuario entity.
     *
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
        return new Response($route.'/#!/usuario');
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

    public function _indexLunchAction($query, $field = null, $attr = null){

        $em = $this->get('doctrine.orm.entity_manager');
        $emConfig = $em->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        $emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');

        $dql = $em->createQueryBuilder();
        $isnotquery = false;
        if (is_null($field))
            if(!$query || $query == '*')
                $dql->select('um')
                    ->from('INCESComedorBundle:UsuarioMenu', 'um')
                    ->join('um.usuario', 'u')
                    ->orderBy('um.dia', 'DESC');
            else
                $dql = "SELECT um FROM INCES\ComedorBundle\Entity\UsuarioMenu um JOIN um.usuario u WHERE " . $query;

        elseif ($attr == '1')
            if($field != 'cedula' && $field != 'nombre' && $field != 'apellido')
                $dql->select('um')
                    ->from('INCESComedorBundle:UsuarioMenu', 'um')
                    ->join('um.usuario', 'u')
                    ->orderBy('um.'.$field, 'ASC');
            else
                $dql->select('um')
                    ->from('INCESComedorBundle:UsuarioMenu', 'um')
                    ->join('um.usuario', 'u')
                    ->orderBy('u.'.$field, 'ASC');
        else
            if($field != 'cedula' && $field != 'nombre' && $field != 'apellido')
                $dql->select('um')
                    ->from('INCESComedorBundle:UsuarioMenu', 'um')
                    ->join('um.usuario', 'u')
                    ->orderBy('um.'.$field, 'DESC');
            else
                $dql->select('um')
                    ->from('INCESComedorBundle:UsuarioMenu', 'um')
                    ->join('um.usuario', 'u')
                    ->orderBy('u.'.$field, 'DESC');

        $qry = $em->createQuery($dql);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $qry,
            $this->get('request')->query->get('page', 1),//page number
            2//limit per page
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
            $res .= " (u.cedula like '%" . $value . "%'";
            $res .= " or u.nombre like '%" . $value . "%'";
            $res .= " or u.apellido like '%" . $value . "%'";
            $res .= " or u.ncarnet like '%" . $value . "%'";
            $res .= " or u.correo like '%" . $value . "%') AND";
        }
        $res = substr_replace($res ,"",-4);
        return $res;
    }

    public function paramsLunch($params){
        $params = trim($params);
        $explote = explode(" ", $params);
        $res = "";

        foreach($explote as $value){
            $res .= $this->setDate($value);
            if($res == ""){
                $res .= " (u.cedula like '%" . $value . "%'";
                $res .= " or u.nombre like '%" . $value . "%'";
                $res .= " or u.apellido like '%" . $value . "%') AND";
            }
            //$res .= " or YEAR(um.dia) like '%" . $value . "%'";
            //$res .= " or MONTH(um.dia) like '%" . $value . "%'";
            //$res .= " or DAY(um.dia) like '%" . $value . "%') AND";
        }
        if(strlen($res) > 3)
            $res = substr_replace($res ,"",-4);
        return $res;
    }

    /*
     *  Search by Cedula
     */
    public function searchAction(){

        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->get('request');
        $query   = $request->request->get('query');
        $query = substr_replace($query ,"",-1);

        $dql   = $em->createQueryBuilder();
            $dql->select('um')
                ->from('INCESComedorBundle:UsuarioMenu', 'um')
                ->join('um.usuario', 'u')
                ->where("u.cedula = '".$query."'");

        $qry         = $em->createQuery($dql);
        $usuariomenu = $qry->getResult();
        return $this->render('INCESComedorBundle:Usuario:_search_show.html.twig', array(
             'query'       => $query
            ,'usuariomenu' => $usuariomenu
        ));
    }

    /*
     *  Search Ajax
     */
    public function searchAjaxAction(){
        $request = $this->get('request');
        $query   = $request->request->get('query');
        if(is_null($query))
            $query   = $request->query->get('query')."*";

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
     *  Search Ajax Lunch de los usuarios que han comido
     */
    public function searchAjaxLunchAction(){
        $request = $this->get('request');
        $query   = $request->request->get('query');
        if(is_null($query))
            $query   = $request->query->get('query')."*";

        if (!$query) {
            $field      = $request->request->get('field');
            $attr       = $request->request->get('attr');
            $pagination = $this->_indexLunchAction($query, $field, $attr);

            // Buscando las personas que ya comieron hoy
            //$userMenuTd = $this->menuToday();
            return $this->render('INCESComedorBundle:Usuario:_index_lunch.html.twig', array(
                'pagination'   => $pagination
                ,'query'       => $query
                ,'field'       => $field
                ,'attr'        => $attr
                //,'userMenuTd'  => $userMenuTd
            ));
        }else{
            if ($request->isXmlHttpRequest()){
                if ('*' == $query){
                    $query = '';
                    $field = $request->request->get('field');
                    $attr  = $request->request->get('attr');
                    $pagination = $this->_indexLunchAction($query, $field, $attr);

                    // Buscando las personas que ya comieron hoy
                    //$userMenuTd = $this->menuToday();
                    return $this->render('INCESComedorBundle:Usuario:_index_lunch.html.twig', array(
                        'pagination'   => $pagination
                        ,'query'       => $query
                        ,'field'       => $field
                        ,'attr'        => $attr
                        //,'userMenuTd'  => $userMenuTd
                    ));
                }
                $query = substr_replace($query ,"",-1);
                $_query = $this->paramsLunch($query);
                $pagination = $this->_indexLunchAction($_query);

                // Buscando las personas que ya comieron hoy
                //$userMenuTd = $this->menuToday();
                return $this->render('INCESComedorBundle:Usuario:_list_lunch.html.twig', array(
                    'pagination'   => $pagination
                    ,'query'       => $query
                    //,'userMenuTd'  => $userMenuTd
                ));
            }
        }
    }

    public function validaciones($arr){
        $i     = 0;
        $em    = $this->getDoctrine()->getEntityManager();
        $dql = $em->createQueryBuilder();
        $dql->select('r.nombre')
            ->from('INCESComedorBundle:Rol', 'r');
        $qry = $em->createQuery($dql);
        $_roles = $qry->getResult();
        $roles = array();
        foreach($_roles as $value)
            array_push($roles, $value['nombre']);

        foreach($arr as $value){
            $i++;
            if($i == 1) continue;

            // Cantidad de valores
            $split = explode(",", $value[0]);
            if(count($split) != 6)
                return "La línea ".$i." no tiene el correcto número de campos";

            // Rol
            if(!in_array($split[0], $roles))
                return "Para la línea ".$i." el campo 'Rol' no se encuentra en base de datos";

            // Nombre
            if($split[1] == "")
                return "Para la línea ".$i." el campo 'Nombre' no puede ser vacio";
            elseif(!ctype_alpha($split[1]))
                return "Para la línea ".$i." el campo 'Nombre' contiene caracters inválidos";

            // Apellido
            if($split[2] == "")
                return "Para la línea ".$i." el campo 'Apellido' no puede ser vacio";
            elseif(!ctype_alpha($split[2]))
                return "Para la línea ".$i." el campo 'Apellido' contiene caracters inválidos";

            // Cedula
            if($split[3] == "")
                return "Para la línea ".$i." el campo 'Cédula' no puede ser vacio";
            elseif(!ctype_digit($split[3]))
                return "Para la línea ".$i." el campo 'Cédula' contiene caracters inválidos";

            // N Carnet
            if($split[4] == "")
                return "Para la línea ".$i." el campo 'Número de Carnet' no puede ser vacio";
            elseif(!ctype_digit($split[4]))
                return "Para la línea ".$i." el campo 'Número de Carnet' contiene caracters inválidos";

            // Correo
            if($split[5] == "") continue;
            elseif(!filter_var($split[5], FILTER_VALIDATE_EMAIL))
                return "Para la línea ".$i." el campo 'Correo' es inválido";
        }
        return "";
    }

    public function saveValues($arr){
        $i      = 0;
        $rol_id = 0;
        $em     = $this->getDoctrine()->getEntityManager();
        $roles  = $em->getRepository('INCESComedorBundle:Rol')->findAll();
        $conn   = $this->get('database_connection');

        foreach($arr as $value){
            $i++;
            if($i == 1) continue;

            // Obteniendo valores
            $split = explode(",", $value[0]);

            // Rol
            foreach($roles as $rol)
                if($rol->getNombre() == $split[0]){
                    $rol_id = $rol->getId();
                    break;
                }

            $conn->insert('Usuario',
                array('rol_id'   => $rol_id
                     ,'nombre'   => $split[1]
                     ,'apellido' => $split[2]
                     ,'cedula'   => $split[3]
                     ,'ncarnet'  => $split[4]
                     ,'correo'   => $split[5]
                )
            );
        }
        return "";
    }

    public function cargaMasivaAction(){

        $em      = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        $cm_form = $this->createForm(new CargaMasivaType());
        //$cm_form->bindRequest($request);

        if ($request->getMethod() == 'POST') {
            $cm_form->bindRequest($request);

            $dir = dirname(__FILE__).'/../../../../web/uploads/';

            // Colocando en el archivo en la carpeta web/uploads/
            $name        = $cm_form['file']->getData()->move($dir);
            $nameExplode = explode("/", $name);
            $nameFile    = end($nameExplode);

            // Comprobando que el archivo tenga los parametros adecuados
            // Llenando estructura temporal con la informacion del archivo
            $f = fopen ($dir . $nameFile, 'r');
            while (false !== $data = fgetcsv($f, 0, ';'))
                $arr[] = $data;
            fclose($f);

            $errores = $this->validaciones($arr);

            if($errores != "")
               return new Response("<p>".$errores."</p>");

            // Guardando en Base de Datos
            $this->saveValues($arr);

            // Eliminar el archivo .csv
            unlink($dir . $nameFile);

            //return $this->redirect($this->generateUrl('usuario_show', array('id' => $entity->getId())));
            $route = $request->getBaseUrl();
            return new Response($route.'/#!/usuario/');
        }


        return $this->render('INCESComedorBundle:Usuario:carga_masiva.html.twig', array(
            'cm_form'    => $cm_form->createView()
        ));
    }
}
