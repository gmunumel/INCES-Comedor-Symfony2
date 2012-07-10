<?php

namespace INCES\ComedorBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends BaseController
{
    public function registerAction()
    {
        $form                = $this->container->get('fos_user.registration.form');
        $formHandler         = $this->container->get('fos_user.registration.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');
        $request             = $this->container->get('request');
        $route               = $request->getBaseUrl();

        $process = $formHandler->process($confirmationEnabled);
        if ($process) {
            $user = $form->getData();

            /*****************************************************
             * Add new functionality (e.g. log the registration) *
             *****************************************************/
            $this->container->get('logger')->info(
                sprintf('New user registration: %s', $user)
            );

            if ($confirmationEnabled) {
                $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                $route = 'fos_user_registration_check_email';
            } else {
                $this->authenticateUser($user);
                $route = 'fos_user_registration_confirmed';
            }

            $this->setFlash('fos_user_success', 'registration.flash.user_created');
            $url = $this->container->get('router')->generate($route);

            //$request = $this->getRequest();
            //$request = $this->container->get('request');
            $route = $request->getBaseUrl();
            return new Response($route);
            //return new RedirectResponse($url);
        }
        if ('POST' === $request->getMethod()) {
            return new Response(
                "<p>ERROR: ha ocurrido un error. Por favor, coloque otro nombre de usuario o correo.</p>"
            );
        }

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:register.html.'.$this->getEngine(), array(
            'form'  => $form->createView(),
            'theme' => $this->container->getParameter('fos_user.template.theme'),
            'route' => $route
        ));
    }
}
