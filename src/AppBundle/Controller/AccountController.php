<?php

// src/AppBundle/Controller/AccountController.php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;

class AccountController extends Controller {

    public function registerAction() {
        $userRegistration = new RegistrationType();
        $form = $this->createForm($userRegistration, new User(),  array(
            'action' => $this->generateUrl('account_create')
        ));

        return $this->render('AppBundle:Account:register.html.twig',
                array('form' => $form->createView())
        );
    }

    public function createAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new RegistrationType());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $registration = $form->getData();
            $em->persist($registration);
            $em->flush();
            return $this->redirectToRoute('login_route');
        }

        return $this->render('AppBundle:Account:register.html.twig',
                array('form' => $form->createView())
        );
    }
}
