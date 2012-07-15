<?php

namespace INCES\ComedorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('INCESComedorBundle:Default:index.html.twig');
    }

    public function errorAction()
    {
        return $this->render('INCESComedorBundle:Default:error.html.twig');
    }
}
