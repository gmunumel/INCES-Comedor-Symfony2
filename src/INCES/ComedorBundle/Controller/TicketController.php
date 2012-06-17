<?php

namespace INCES\ComedorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use INCES\ComedorBundle\Entity\Usuario;

class TicketController extends Controller
{
    public function indexAction()
    {
        //$this->container->get('knp_snappy.pdf')->generate('http://www.google.com', __DIR__.'/../../../../web/pdf/file.pdff');
        $html = $this->renderView('INCESComedorBundle:Ticket:index.html.twig');

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="file.pdf"'
            )
        );

        //return $this->render('INCESComedorBundle:Default:index.html.twig');
    }

    public function showAction($id)
    {

        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INCESComedorBundle:Usuario')->find($id);

        $html = $this->renderView('INCESComedorBundle:Ticket:show.html.twig', array(
            'entity'      => $entity
        ));
        //$this->container->get('knp_snappy.pdf')->generate('http://www.google.com', __DIR__.'/../../../../web/pdf/file.pdff');

        /*
        return $this->render('INCESComedorBundle:Ticket:show.html.twig', array(
            'entity'      => $entity
        ));
        */

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="file.pdf"'
            )
        );
    }
}
