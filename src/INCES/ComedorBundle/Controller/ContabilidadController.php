<?php

namespace INCES\ComedorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use INCES\ComedorBundle\Entity\Usuario;
use INCES\ComedorBundle\Entity\Menu;
use INCES\ComedorBundle\Entity\UsuarioMenu;
use INCES\ComedorBundle\Form\ContabilidadType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Contabilidad controller.
 *
 */
class ContabilidadController extends Controller
{
    public function indexAction(){
        return new Response("hola");
    }

    public function isValid($value){
        $valid = false;
        $from = $value->get('from')->getData();
        $to   = $value->get('to')->getData();
        $rol  = $value->get('rol')->getData();
    }

    public function reporteIngresosAction(){

        $em = $this->getDoctrine()->getEntityManager();
        $request    = $this->getRequest();
        $filterForm = $this->createForm(new ContabilidadType());
        //$filterForm->bindRequest($request);

        if ($request->getMethod() == 'POST') {
            $filterForm->bindRequest($request);
            //print_r($filterForm->getData());
            //if($filterForm->isValid()){
            //if ($this->isValid($filterForm)) {
            if(true){

                /* TODO Hacer el calculo del dinero ganado */
                $montoTotal = 0;
                $cantidadTotal = 0;
                //print_r($filterForm->get('from')->getData()->format('d/m/Y'));
                $from  = $filterForm->get('from')->getData();
                $to    = $filterForm->get('to')->getData();
                $rol   = $filterForm->get('rol')->getData();
                $_roles = $em->getRepository('INCESComedorBundle:Rol')->findAll();
                //print_r($rol);
                //if($from != "") $from = $filterForm->get('from')->getData()->format('d/m/Y');
                //if($to   != "") $to   = $filterForm->get('to')->getData()->format('d/m/Y');

                $dql = $em->createQueryBuilder();
                // First Case: Fechas vacio y rol vacio
                if($from == "" and $to == "" and $rol == "")
                    $dql->select('um', 'u', 'r')
                        ->from('INCESComedorBundle:UsuarioMenu', 'um')
                        ->join('um.usuario', 'u')
                        ->join('u.rol', 'r')
                        //->groupBy('r.id');
                        ->addOrderby('r.id', 'ASC');
                // Second Case: fechas no vacio y rol vacio
                elseif($from != "" and $to != "" and $rol == "" )
                    $dql->select('um', 'u', 'r')
                        ->from('INCESComedorBundle:UsuarioMenu', 'um')
                        ->join('um.usuario', 'u')
                        ->join('u.rol', 'r')
                        ->where("um.dia <= '". $to->format('Y-m-d'). "'")
                        ->andWhere("um.dia >= '". $from->format('Y-m-d'). "'")
                        ->addOrderby('r.id', 'ASC');
                // Thrid Case: fechas vacio y rol no vacio
                elseif($from == "" and $to == "" and $rol != "" )
                    $dql->select('um', 'u', 'r')
                        ->from('INCESComedorBundle:UsuarioMenu', 'um')
                        ->join('um.usuario', 'u')
                        ->join('u.rol', 'r')
                        ->where('r.id = '. $rol->getId())
                        ->addOrderby('r.id', 'ASC');
                // Forth Case: fechas no vacio y rol no vacio
                else
                    $dql->select('um', 'u', 'r')
                        ->from('INCESComedorBundle:UsuarioMenu', 'um')
                        ->join('um.usuario', 'u')
                        ->join('u.rol', 'r')
                        ->where('r.id = '. $rol->getId())
                        ->andWhere("um.dia <= '". $to->format('Y-m-d'). "'")
                        ->andWhere("um.dia >= '". $from->format('Y-m-d'). "'")
                        ->addOrderby('r.id', 'ASC');

                $qry = $em->createQuery($dql);
                $pagination = $qry->getResult();
                /*
                $paginator  = $this->get('knp_paginator');
                $pagination = $paginator->paginate(
                    $qry,
                    $this->get('request')->query->get('page', 1),//page number
                    2//limit per page
                );
                 */

                // Get cantidadTotal
                $cantidadTotal = count($pagination);

                // Get monto total
                foreach($pagination as $value){
                    $montoTotal += intval($value->getUsuario()->getRol()->getMonto());
                }

                // Get total values
                $totals = array();
                $count  = 0;
                $money  = 0.0;
                foreach($_roles as $rol){
                    foreach($pagination as $value){
                        if($rol == $value->getUsuario()->getRol()->getNombre()){
                            $count++;
                            $money = floatval($value->getUsuario()->getRol()->getMonto());
                        }
                    }
                    $money = $money * $count;
                    if($count == 0)
                        $temp = array((string)$rol => array("0", (string)$money));
                    else
                        $temp = array((string)$rol => array((string)$count, (string)$money));
                    $count  = 0;
                    $money  = 0.0;
                    $totals = array_merge((array)$totals, (array)$temp);
                }

                return $this->render('INCESComedorBundle:Contabilidad:_reporte_ingresos.html.twig', array(
                     //'entities' => $entities
                     //'filter_form' => $filterForm->createView(),
                    'pagination'     => $pagination
                    ,'montoTotal'    => $montoTotal
                    ,'cantidadTotal' => $cantidadTotal
                    ,'from'          => $from
                    ,'to'            => $to
                    ,'totals'        => $totals
                ));
            }
        }

        return $this->render('INCESComedorBundle:Contabilidad:reporte_ingresos.html.twig', array(
             //'entities' => $entities
            'filter_form' => $filterForm->createView(),
        ));
    }

    public function reporteUsuarioAllAction(){

        $em = $this->getDoctrine()->getEntityManager();
        $request    = $this->getRequest();
        $filterForm = $this->createForm(new ContabilidadType());

        if ($request->getMethod() == 'POST') {
            $filterForm->bindRequest($request);
            if(true){

                $from   = $filterForm->get('from')->getData();
                $to     = $filterForm->get('to')->getData();
                $ced    = $filterForm->get('cedula')->getData();

                $dql = $em->createQueryBuilder();
                // First Case: Fechas vacio
                if($from == "" and $to == "")
                    $dql->select('um', 'u', 'r')
                        ->from('INCESComedorBundle:UsuarioMenu', 'um')
                        ->join('um.usuario', 'u')
                        ->join('u.rol', 'r')
                        ->where("u.cedula = '".$ced."'");
                // Second Case: fechas no vacio
                else
                    $dql->select('um', 'u', 'r')
                        ->from('INCESComedorBundle:UsuarioMenu', 'um')
                        ->join('um.usuario', 'u')
                        ->join('u.rol', 'r')
                        ->where("u.cedula = '".$ced."'")
                        ->andWhere("um.dia <= '". $to->format('Y-m-d'). "'")
                        ->andWhere("um.dia >= '". $from->format('Y-m-d'). "'");

                $qry = $em->createQuery($dql);
                $paginator  = $this->get('knp_paginator');
                $pagination = $paginator->paginate(
                    $qry,
                    $this->get('request')->query->get('page', 1),//page number
                    2//limit per page
                );

                return $this->render('INCESComedorBundle:Contabilidad:_reporte_usuario_all.html.twig', array(
                     //'entities' => $entities
                     //'filter_form' => $filterForm->createView(),
                    'pagination'     => $pagination
                    ,'from'          => $from
                    ,'to'            => $to
                ));
            }
        }

        return $this->render('INCESComedorBundle:Contabilidad:reporte_usuario_all.html.twig', array(
             //'entities' => $entities
            'filter_form' => $filterForm->createView(),
        ));
    }
}
