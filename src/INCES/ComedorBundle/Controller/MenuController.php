<?php

namespace INCES\ComedorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use INCES\ComedorBundle\Entity\Usuario;
use INCES\ComedorBundle\Entity\Menu;
use INCES\ComedorBundle\Entity\UsuarioMenu;
use INCES\ComedorBundle\Form\MenuType;
use INCES\ComedorBundle\Form\UsuarioMenuType;
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
        $emConfig = $em->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        $emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');

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
            $res .= " (DAY(a.dia) = " . $explote[0] . ") AND";
        if($explote[1] != '*')
            $res .= " (MONTH(a.dia) = " . $explote[1] . ") AND";
        if($explote[2] != '*')
            $res .= " (YEAR(a.dia) = " . $explote[2] . ") AND";
        return $res;
    }

    public function params($params){
        $params = trim($params);
        $explote = explode(" ", $params);
        $res = "";
        $ret = "";

        foreach($explote as $value){
            $ret = $this->setDate($value);
            $res .= $ret;
            if($ret == ""){
                $res .= " (a.seco LIKE '%" . $value . "%'";
                $res .= " OR a.sopa LIKE '%" . $value . "%'";
                $res .= " OR a.salado LIKE '%" . $value . "%'";
                $res .= " OR a.jugo LIKE '%" . $value . "%'";
                $res .= " OR a.ensalada LIKE '%" . $value . "%'";
                $res .= " OR a.postre LIKE '%" . $value . "%' ) AND";
            }
            /*
            $res .= " (a.seco LIKE '%" . $value . "%'";
            $res .= " OR a.sopa LIKE '%" . $value . "%'";
            $res .= " OR a.salado LIKE '%" . $value . "%'";
            $res .= " OR a.jugo LIKE '%" . $value . "%'";
            $res .= " OR a.ensalada LIKE '%" . $value . "%'";
            $res .= " OR a.postre LIKE '%" . $value . "%' ) AND";
            */
        }
        if(strlen($res) > 3)
            $res = substr_replace($res ,"",-4);
        return $res;
    }

    /*
     * Search Action dos
     */
    public function searchAction(){
        $request = $this->get('request');
        $query   = $request->request->get('query');
        if(is_null($query))
            $query   = $request->query->get('query')."*";

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

                $query = htmlspecialchars(urldecode($query));
                print_r($query);
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
            return new Response($route.'/#!/menu/'.$entity->getId().'/show');
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
            //return new Response($route.'/#!/menu/');
            return new Response($route.'/#!/menu/'.$entity->getId().'/show');
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
        return new Response($route.'/#!/menu');
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

    /**
     * Creates a new Facturar Procesar entity.
     *
     */
    public function facturarProcesarAction()
    {
        $request = $this->get('request');
        $conn    = $this->get('database_connection');

        $usuario = $_POST["usuario"];
        $dia     = new \DateTime('now');
        $dia     = $dia->format('Y-m-d H:i:s');

        if(!isset($_POST["menus"]))
            $conn->insert('UsuarioMenu',
                array('usuario_id' => $usuario
                     ,'dia'        => $dia
                )
            );
        else{
            $menu    = $_POST["menus"];
            $conn->insert('UsuarioMenu',
                array('usuario_id' => $usuario
                     ,'dia'        => $dia
                     ,'menu_id'    => $menu
                )
            );
        }

        $route = $request->getBaseUrl();
        return new Response($route.'/#!/menu/facturar');
    }

    /**
     * Finds and displays a Usuario entity.
     *
     */
    public function showFacturarAction($id)
    {
        $request = $this->getRequest();

        $em = $this->getDoctrine()->getEntityManager();
        $emConfig = $em->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        $emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');

        $entity = $em->getRepository('INCESComedorBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }
        $deleteForm = $this->createDeleteForm($id);

        //Verificar si se encuentra dentro del horario
        $em = $this->get('doctrine.orm.entity_manager');
        $dql = $em->createQueryBuilder();
        $dql->select('u, r')
            ->from('INCESComedorBundle:Usuario', 'u')
            ->join('u.rol', 'r')
            ->where('u.id = '. $id);
        $qry    = $em->createQuery($dql);
        $entity = $qry->getResult();
        $entity = $entity[0];

        $now = new \DateTime('now');
        $hour = $now->format('H');
        if ($entity->getRol()->getHoraComerStartAMPM() == "pm"){
            $hourStart = $entity->getRol()->getHoraComerStart() + 12;
            $hourEnd = $entity->getRol()->getHoraComerEnd() + 12;
        }elseif ($entity->getRol()->getHoraComerStartAMPM() == "pm" and $entity->getRol()->getHoraComerEndAMPM() == "am"){
            $hourStart = $entity->getRol()->getHoraComerStart() + 12;
            $hourEnd = $entity->getRol()->getHoraComerEnd();
        }elseif ($entity->getRol()->getHoraComerStartAMPM() == "am" and $entity->getRol()->getHoraComerEndAMPM() == "pm"){
            $hourStart = $entity->getRol()->getHoraComerStart();
            $hourEnd = $entity->getRol()->getHoraComerEnd() + 12;
        }else{
            $hourStart = $entity->getRol()->getHoraComerStart();
            $hourEnd = $entity->getRol()->getHoraComerEnd();
        }
        if ($hour < $hourStart || $hour > $hourEnd)
            return new Response(
                "<p> ".
                    "<span class='ui-icon ui-icon-alert' style='float:left; margin:0 7px 20px 0;'></span> ".
                    "El usuario <b>".ucfirst($entity->getNombre())." ".ucfirst($entity->getApellido())."</b> tiene el rol <b>".strtoupper($entity->getRol()->getNombre())."</b>. <br /><br /> ".
                    "El <b>".strtoupper($entity->getRol()->getNombre())."</b> puede hacer uso del servicio del comedor desde <b>".$entity->getRol()->getHoraComerStart()." ".$entity->getRol()->getHoraComerStartAMPM()."</b> hasta <b>".$entity->getRol()->getHoraComerEnd()." ".$entity->getRol()->getHoraComerEndAMPM()."</b>." .
                "</p>"
            );
        //Verificar si ya ha comido esa persona ese mismo dia
        $now = new \DateTime('now');
        $dql = $em->createQuery('SELECT COUNT(um.id) FROM INCES\ComedorBundle\Entity\UsuarioMenu um WHERE um.usuario = :id and YEAR(um.dia) = :year and MONTH(um.dia) = :month and DAY(um.dia) = :day');
        $dql->setParameter('id', $id);
        $dql->setParameter('year', $now->format("Y"));
        $dql->setParameter('month', $now->format("m"));
        $dql->setParameter('day', $now->format("d"));
        $count = $dql->getSingleScalarResult();

        /* TODO Optimizar estos 2 querys
        *  Arreglar al URL
        */
        if($count > 0){
            $dql = $em->createQuery('SELECT um FROM INCES\ComedorBundle\Entity\UsuarioMenu um WHERE um.usuario = :id and YEAR(um.dia) = :year and MONTH(um.dia) = :month and DAY(um.dia) = :day');
            $dql->setParameter('id', $id);
            $dql->setParameter('year', $now->format("Y"));
            $dql->setParameter('month', $now->format("m"));
            $dql->setParameter('day', $now->format("d"));
            $_entity   = $dql->getResult();
            $_entity   = $_entity[0];
            $lncHora   = $_entity->getDia()->format("H");
            $lncMinuto = $_entity->getDia()->format("i");
            $ampm      = "am";
            if($lncHora > 12){
               $lncHora = $lncHora - 12;
               $ampm = "pm";
            }
            if($lncHora == 12) $ampm = "pm";
            if($lncHora == 24) $ampm = "am";
            $path = $request->getBaseUrl().'/#!/usuario/searchalnc';
            return new Response(
                "<p> ".
                    "<span class='ui-icon ui-icon-alert' style='float:left; margin:0 7px 20px 0;'></span> ".
                    "El usuario <b>".ucfirst($entity->getNombre())." ".ucfirst($entity->getApellido())."</b> ya almorzó a la hora <b>".strval($lncHora).":".strval($lncMinuto)." ".$ampm."</b>. <br /><br /> ".
                    "<a id='closer' href='".$path."' alt='ultimos almuerzos'>Ver últimos usuarios que almorzaron.</a>".
                "</p>"
            );
        }


        // Buscando menus del dia
        $now = new \DateTime;
        $menus = $em->createQueryBuilder();
        $menus->add('select', 'm')
            ->add('from', 'INCESComedorBundle:Menu m')
            ->add('where', "m.dia = '".$now->format("Y-m-d 00:00:00")."'");

        $qry   = $em->createQuery($menus);
        $menus = $qry->getResult();

        return $this->render('INCESComedorBundle:Menu:show_facturar.html.twig', array(
            'entity'      => $entity,
            'menus'       => $menus,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function lncToday(){

        $em = $this->get('doctrine.orm.entity_manager');
        $emConfig = $em->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        $emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');

        // Buscando las personas que ya comieron hoy
        $now = new \DateTime('now');
        $dql = $em->createQueryBuilder();
        $dql->select('um')
            ->from('INCESComedorBundle:UsuarioMenu','um')
            ->where("YEAR(um.dia) = '".$now->format("Y")."'")
            ->andWhere("MONTH(um.dia) = '".$now->format("m")."'")
            ->andWhere("DAY(um.dia) = '".$now->format("d")."'");
        $qry = $em->createQuery($dql);
        $userLncTd = $qry->getResult();

        return $userLncTd;
    }

    /**
     * Lists all Usuario entities.
     */
    public function _indexFacturarAction($query, $field = null, $attr = null){

        $em = $this->get('doctrine.orm.entity_manager');
        $dql = $em->createQueryBuilder();
        $isnotquery = false;
        if (is_null($field))
            if(!$query || $query == '*')
                $dql->select('u')
                    ->from('INCESComedorBundle:Usuario', 'u')
                    //->from('INCESComedorBundle:Rol', 'r')
                    //->from('INCESComedorBundle:UsuarioMenu', 'um');
                    ->join('u.rol', 'r');
                    //->where('r.id = u.rol')
                /*
                $dql->select('u')
                    ->from('INCESComedorBundle:Usuario', 'u')
                    ->join('u.rol', 'r')
                    ->where('r.id = u.rol');
                */
            else
                //$isnotquery = true;
                $dql = "SELECT u FROM INCES\ComedorBundle\Entity\Usuario u JOIN u.rol r WHERE " . $query;

        elseif ($attr == '1')
            if($field != 'rol')
                $dql->select('u')
                    ->from('INCESComedorBundle:Usuario', 'u')
                    //->from('INCESComedorBundle:Rol', 'r')
                    //->from('INCESComedorBundle:UsuarioMenu', 'um')
                    ->join('u.rol', 'r')
                    ->where('r.id = u.rol')
                    ->orderBy('u.'.$field, 'ASC');
            else
                $dql->select('u')
                    ->from('INCESComedorBundle:Usuario', 'u')
                    //->from('INCESComedorBundle:Rol', 'r')
                    //->from('INCESComedorBundle:UsuarioMenu', 'um')
                    ->join('u.rol', 'r')
                    ->where('r.id = u.rol')
                    ->orderBy('r.nombre', 'ASC');
        else
            if($field != 'rol')
                $dql->select('u')
                    ->from('INCESComedorBundle:Usuario', 'u')
                    //->from('INCESComedorBundle:Rol', 'r')
                    //->from('INCESComedorBundle:UsuarioMenu', 'um')
                    ->join('u.rol', 'r')
                    ->where('r.id = u.rol')
                    ->orderBy('u.'.$field, 'DESC');
            else
                $dql->select('u')
                    ->from('INCESComedorBundle:Usuario', 'u')
                    //->from('INCESComedorBundle:Rol', 'r')
                    //->from('INCESComedorBundle:UsuarioMenu', 'um')
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
     *  Search Ajax Facturar
     */
    public function searchAjaxFacturarAction(){
        $request = $this->get('request');
        $query   = $request->request->get('query');

        if (!$query) {
            $field      = $request->request->get('field');
            $attr       = $request->request->get('attr');
            $pagination = $this->_indexFacturarAction($query, $field, $attr);

            // Buscando las personas que ya comieron hoy
            $userLncTd = $this->lncToday();
            return $this->render('INCESComedorBundle:Menu:_index_facturar.html.twig', array(
                'pagination'  => $pagination
                ,'query'      => $query
                ,'field'      => $field
                ,'attr'       => $attr
                ,'userLncTd'  => $userLncTd
            ));
        }else{
            if ($request->isXmlHttpRequest()){
                if ('*' == $query){
                    $query = '';
                    $field = $request->request->get('field');
                    $attr  = $request->request->get('attr');
                    $pagination = $this->_indexFacturarAction($query, $field, $attr);

                    // Buscando las personas que ya comieron hoy
                    $userLncTd = $this->lncToday();
                    return $this->render('INCESComedorBundle:Menu:_index_facturar.html.twig', array(
                        'pagination'  => $pagination
                        ,'query'      => $query
                        ,'field'      => $field
                        ,'attr'       => $attr
                        ,'userLncTd'  => $userLncTd
                    ));
                }
                $query = substr_replace($query ,"",-1);
                $_query = $this->paramsFacturar($query);
                $pagination = $this->_indexFacturarAction($_query);

                // Buscando las personas que ya comieron hoy
                $userLncTd = $this->lncToday();
                return $this->render('INCESComedorBundle:Menu:_list_facturar.html.twig', array(
                    'pagination'  => $pagination
                    ,'query'      => $query
                    ,'userLncTd'  => $userLncTd
                ));
            }
        }
    }
}
