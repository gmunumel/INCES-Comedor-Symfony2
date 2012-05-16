<?php

namespace INCES\ComedorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $ar = "kdsk";
        return $this->render('INCESComedorBundle:Default:index.html.twig');
    }
}
